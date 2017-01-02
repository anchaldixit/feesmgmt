<?php

namespace Intelligent\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Intelligent\UserBundle\Entity\User;

class DefaultController extends Controller {

    /**
     * This is an index page of the site
     * 
     * @return Response
     */
    public function indexAction() {
        return $this->render('IntelligentUserBundle:Default:index.html.twig');
    }

    /**
     * This is a login page
     * 
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request) {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session &&
                $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = "Email and password do not match";
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' :
                $session->get(SecurityContextInterface::LAST_USERNAME);
        
        return $this->render('IntelligentUserBundle:Default:login.html.twig', array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }
     
    /**
     * This is the page where invited users will land by the 
     * link sent to their emails and will register themselves
     * 
     * @param type $emailVerifyId
     * @return type
     */
    public function inviteUserAction($emailVerifyId){
        $email = $status = $role = '';
        /**
         * @TODO create this page
         */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("IntelligentUserBundle:User")->findOneBy(array("verificationId" => $emailVerifyId));
        if($user){
            $status = $user->getStatus();
            if($user->getStatus() == User::UNVERIFIED){
                $user->setStatus(User::UNREGISTERED);
                $em->flush();
            }
            $email = $user->getEmail();
            $role  = $user->getRole()->getName();
        }else{
            $status = false;
        }
        return $this->render('IntelligentUserBundle:Default:userregistration.html.twig', $param = array(
            'emailVerifyId' => $emailVerifyId,
            'status' => $status,
            "email"  => $email,
            "role"   => $role
        ));
    }
    
    /**
     * Reset password
     * 
     * @param type $resetPasswordId
     * @return Response
     */
    public function resetPasswordAction($resetPasswordId){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("IntelligentUserBundle:User")->findOneBy(array("passwordResetId" => $resetPasswordId));
        if($user){
            $status = 1;
        }else{
            $status = 0;
        }
        
        return $this->render('IntelligentUserBundle:Default:reset.html.twig', array(
            'resetPasswordId' => $resetPasswordId,
            'status' => $status
        ));
    }
    
    /**
     * Change password
     * 
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:changepassword.html.twig', array());
    }
    
    /**
     * Show list of users
     * 
     * @param Request $request
     * @return Response
     */
    public function usersAction(Request $request){
        $data = array('customers' => $this->_getAllCustomers());
        return $this->render('IntelligentUserBundle:Default:users.html.twig', $data);
    }
    
    /**
     * Show list of roles
     * 
     * @param Request $request
     * @return type
     */
    public function rolesAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:roles.html.twig', array());
    }
    
    /**
     * Show MyPreference page
     *  
     * @param Request $request
     * @return type
     */
    public function mypreferencesAction(Request $request){
        
        return $this->render('IntelligentUserBundle:Default:mypreferences.html.twig', array());
    }
    
    /**
     * Show RolePermissions page
     * 
     * @param type $roleId
     * @return Response
     */
    public function rolePermissionsAction($roleId){
        return $this->render('IntelligentUserBundle:Default:rolepermissions.html.twig', array('roleId' => $roleId));
        
    }
    
    /**
     * This is an action to show AccessDenied page
     * 
     * @param Request $request
     * @return Response
     */
    public function noaccessAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
    }
    
    /**
     * This is an action to choose Customer page
     * 
     * @param Request $request
     * @return Response
     */
    public function choosecustomerAction(Request $request){
        $data = array('customers' => $this->_getAllCustomersForUser($this->getUser()));
        return $this->render('IntelligentUserBundle:Default:choosecustomer.html.twig', $data);
    }

    /**
     * This function will return the array of customers 
     * for a role
     * 
     * @param User $user
     * @return array of customers
     */
    private function _getAllCustomersForUser(User $user) {
        $customer_pointers = $user->getAllowedCustomers(true);
        $result = array();
        foreach ($customer_pointers as $customer_pointer) {
            $customer = $customer_pointer->getCustomer();
            $result[] = array(
                'id' => $customer->getId(),
                'name' => $customer->getName()
            );
        }
        return $result;
    }
    
    /**
     * This method will return all the customers
     * 
     * @return array
     */
    private function _getAllCustomers() {
        $repo = $this->getDoctrine()->getManager()->getRepository("IntelligentUserBundle:Customer");
        $customers = $repo->findAll();
        $result = array();
        foreach ($customers as $customer) {
            $result[] = array(
                'id' => $customer->getId(),
                'name' => $customer->getName()
            );
        }
        return $result;
    }
}
