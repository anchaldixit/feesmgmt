<?php
namespace Intelligent\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\User;
use Intelligent\UserBundle\Entity\Customer;


/**
 * RoleAllowedCustomer
 *
 * @ORM\Table(name="user_allowed_customers")
 * @ORM\Entity
 */
class UserAllowedCustomer {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * Many RoleAllowedCustomers can point to one role
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="allowedCustomers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * Many Users have One Address.
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_disabled", type="boolean", nullable=false)
     */
    private $isDisabled;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isDisabled
     *
     * @param boolean $isDisabled
     * @return UserAllowedCustomer
     */
    public function setIsDisabled($isDisabled)
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * Get isDisabled
     *
     * @return boolean 
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }

    /**
     * Set user
     *
     * @param \Intelligent\UserBundle\Entity\User $user
     * @return UserAllowedCustomer
     */
    public function setUser(\Intelligent\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Intelligent\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set customer
     *
     * @param \Intelligent\UserBundle\Entity\Customer $customer
     * @return UserAllowedCustomer
     */
    public function setCustomer(\Intelligent\UserBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Intelligent\UserBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
