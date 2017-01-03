<?php

namespace Intelligent\UserBundle\Services;

use Intelligent\UserBundle\Services\UserPermissions;
use Doctrine\ORM\EntityManager;
use Intelligent\UserBundle\Entity\User;
use Intelligent\UserBundle\Entity\UserAllowedCustomer;

/**
 * This class will deal with the user assigned customers
 *
 * @author tejaswi
 */
class UserCustomers {

    private $permission;
    private $em;

    public function __construct(UserPermissions $permission, EntityManager $entityManager) {
        $this->permission = $permission;
        $this->em = $entityManager;
    }

    /**
     * This function will attach all the customer to a user 
     * 
     * @param array $customerIds ids of all customers to be attched
     * @param mixed $user id or the user, User entity object or just null
     * @return \Intelligent\UserBundle\Services\UserCustomers
     * @throws \Exception if any of the customer_ids not found or user not found
     */
    public function attachCustomersToUser(array $customerIds, $user = null) {
        $em = $this->em;
        if (is_null($user)) {
            $user = $this->permission->getUser();
        } else if (is_numeric($user)) {
            # Get user
            $user = $em->getRepository("IntelligentUserBundle:User")->find($user);
            # Check user
            if (!$user) {
                throw new \Exception("User with user_id($user) do not exists", 404);
            }
        } else if ($user instanceof User) {
            // User supplied is good
        } else {
            throw new \Exception("User is illegal", 412);
        }

        // Check all the customer ids
        foreach ($customerIds as $customer_id) {
            # Get customer
            $customer = $em->getRepository("IntelligentUserBundle:Customer")->find($customer_id);
            # Check customer
            if (!$customer) {
                throw new \Exception("Customer with customer_id($customer_id) do not exists", 404);
            }
        }
        // First detach all the customers first
        $allowed_customers = $user->getAllowedCustomers();
        foreach ($allowed_customers as $allowed_customer) {
            $allowed_customer->setIsActive(FALSE);
        }
        // Now allow only the one which is needed
        foreach ($customerIds as $customer_id) {
            # Check if the customer is already attached to the role
            $corresponding_allowed_customer = null;
            foreach ($allowed_customers as $allowed_customer) {
                if ($customer_id == $allowed_customer->getCustomer()->getId()) {
                    $corresponding_allowed_customer = $allowed_customer;
                    break;
                }
            }
            # If there is no joining object
            if (is_null($corresponding_allowed_customer)) {
                $customer = $em->getRepository("IntelligentUserBundle:Customer")->find($customer_id);
                $joining_object = new UserAllowedCustomer();
                $joining_object->setCustomer($customer);
                $joining_object->setUser($user);
                $joining_object->setIsActive(TRUE);
                $em->persist($joining_object);
            } else {
                $corresponding_allowed_customer->setIsActive(TRUE);
            }
        }
        return $this;
    }

    /**
     * This function will make a default customer for current user
     * 
     * @param type $customerId id of the customer
     * @throws \Exception if the customer is not found or its not already in the user assigned list
     * @return \Intelligent\UserBundle\Services\UserCustomers
     */
    public function changeUserAssignedCustomer($customerId) {
        $user = $this->permission->getUser();
        $em = $this->em;
        $customer = $em->getRepository("IntelligentUserBundle:Customer")->find($customerId);
        if ($customer) {
            $allowed_customers = $user->getAllowedCustomers(true);
            # Check if the current customer is in the allowed list or not
            $required_allowed_customer = null;
            foreach ($allowed_customers as $allowed_customer) {
                if ($allowed_customer->getCustomer()->getId() == $customerId) {
                    $required_allowed_customer = $allowed_customer;
                    break;
                }
            }

            if (is_null($required_allowed_customer)) {
                throw new \Exception("This customer is not in user's role list", 412);
            } else {
                $user->setCurrentCustomer($required_allowed_customer);
            }
        } else {
            throw new \Exception("Customer with customer_id($customerId) not found", 404);
        }
        
        return $this;
    }
    
    /**
     * This function will add the given customer to the user's assigned list
     * and make this user the default one
     * 
     * @param type $customerId
     * @throws \Exception if underlying functions throw exceptions
     */
    public function assignCustomerAndMakeDefault($customerId){
        $this->attachCustomersToUser(array($customerId))
                ->flush()
                ->changeUserAssignedCustomer($customerId)
                ->flush();
    }
    
    /**
     * This function will flush the changes into db
     * 
     * @return \Intelligent\UserBundle\Services\UserCustomers
     */
    public function flush(){
        $this->em->flush();
        return $this;
    }

}
