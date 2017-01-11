<?php
namespace Intelligent\UserBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Intelligent\UserBundle\Entity\Customer;
use Intelligent\UserBundle\Entity\User;
use Intelligent\UserBundle\Entity\Role;
use Intelligent\UserBundle\Entity\RoleGlobalPermission;
/**
 * Description of ImportUserCommand
 *
 * @author tejaswi
 */
class ImportUserCommand extends ContainerAwareCommand{
    protected function configure(){
        $this
            ->setName('import:users')
            ->setDescription('This cmd will import users from quickbase csv files')
            ->addArgument("csvFile",  InputArgument::REQUIRED, "The csv file imported from quickbase")
            ->addArgument("customer", InputArgument::REQUIRED, "Name of the customer for which the users are being imported")
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln("Reading csv file");
        $users = $this->getUsers($input->getArgument("csvFile"));
        $output->writeln("Getting customer details");
        $customer = $this->getCustomer($input->getArgument("customer"));
        
        # Now traverse the user array
        foreach($users as $user){
            $output->writeln("Processing user: " . $user['name']);
            try{
                $this->processUser($user, $customer, $output);
            } catch (\Exception $ex) {
                echo $ex->getTraceAsString();
                throw $ex;
            }
            
        }
    }
    
    /**
     * This function will process the user
     * 
     * @param array $user
     * @param Customer $customer
     * @param OutputInterface $output
     */
    private function processUser(array $user, Customer $customer, OutputInterface $output){
        $em = $this->getContainer()->get("doctrine")->getManager();
        # First get the user. If the user is already there we will not touch it
        $userObj = $em->getRepository("IntelligentUserBundle:User")->findOneBy(array("email" => $user['email']));
        if(!$userObj){
            # Now check if the Role is already there of not
            $role = $this->getRole($user['role']);
            $userObj = new User();
            $userObj->setName($user['name']);
            $userObj->setQuickbaseId($user['quickbase_id']);
            $userObj->setEmail($user['email']);
            $userObj->setPassword(NULL);
            $userObj->setCreateDatetime(new \DateTime());
            $userObj->setUpdateDatetime(new \DateTime());
            $userObj->setStatus(User::PASSWORD_RESET);
            $userObj->setRole($role);
            $em->persist($userObj);
            $em->flush();
        }
        # This will attach the customer to the user;
        $this->getContainer()
                ->get('user_customers')
                ->attachCustomerToUser($customer->getId(),true,$userObj)
                ->flush();
    }
    
    /**
     * This function will get the Role object from the role name
     * 
     * @param string $roleName Name of the role
     * @return Role
     */
    private function getRole($roleName){
        $em = $this->getContainer()->get("doctrine")->getManager();
        $role = $em->getRepository("IntelligentUserBundle:Role")->findOneBy(array("name"=>$roleName));
        if(!$role){
            # Create role
            $role = new Role();
            $role->setName($roleName);
            $role->setDescription("Default description");
            $role->setStatus(Role::ACTIVE);
            $role->setCreateDatetime(new \DateTime());
            $role->setUpdateDatetime(new \DateTime());

            # Create global role permission
            $new_role_global_premission = new RoleGlobalPermission();
            $new_role_global_premission->setEditAppStructurePermission(FALSE);
            $new_role_global_premission->setManageUserAppPermission(FALSE);
            $new_role_global_premission->setReportPermission(FALSE);

            # bind them two
            $new_role_global_premission->setRole($role);

            $em->persist($role);
            $em->persist($new_role_global_premission);
            $em->flush();
        }
        return $role;
    }
    
    /**
     * This function will parse the csv file downloaded from quickbase and 
     * return the user details in array
     * 
     * @param string $csvFile This is the path of the file of the csv file downloaded
     *                        from quickbase
     * @return array users
     * @throws \Exception
     */
    private function getUsers($csvFile){
        $real_path = realpath($csvFile);
        if(is_file($real_path)){
            $fd = fopen($real_path, "r");
            if(is_resource($fd)){
                $user_arr = array();
                $keys = array("name" => 0, "quickbase_id" => 1, "email" => 2, "role" => 4, "app_permission" => 5, "status" => 6);
                // Waste first line
                fgetcsv($fd);
                // Start reading from next line
                while($data = fgetcsv($fd)){
                    $row = array();
                    foreach($keys as $key_name => $key_position){
                        $row[$key_name] = $data[$key_position];
                    }
                    $user_arr[] = $row;
                }
                return $user_arr;
            }else{
                throw new \Exception("Not able to open csv file");
            }
        }else{
            throw new \Exception("csvFile is not a valid file");
        }
    }
    
    /**
     * This function will return the Customer entity object.
     * If the customer is not available it create one
     * 
     * @param string $customerName Name of the customer
     * @return Intelligent\UserBundle\Entity\Customer
     */
    private function getCustomer($customerName){
        $doctrine = $this->getContainer()->get("doctrine");
        $em = $doctrine->getManager();
        $repo = $em->getRepository("IntelligentUserBundle:Customer");
        $customer = $repo->findOneBy(array('name' => $customerName));
        if(!$customer){
            $customer = new Customer();
            $customer->setName($customerName);
            $em->persist($customer);
            $em->flush();
        }
        return $customer;
    }
    
    
}
