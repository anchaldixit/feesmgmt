<?php
namespace Intelligent\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\Role;
use Intelligent\UserBundle\Entity\Customer;


/**
 * RoleAllowedCustomer
 *
 * @ORM\Table(name="role_allowed_customers")
 * @ORM\Entity
 */
class RoleAllowedCustomer {
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
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="allowedCustomers")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;
    
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
     * @return RoleAllowedCustomer
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
     * Set role
     *
     * @param \Intelligent\UserBundle\Entity\Role $role
     * @return RoleAllowedCustomer
     */
    public function setRole(\Intelligent\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Intelligent\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set customer
     *
     * @param \Intelligent\UserBundle\Entity\Customer $customer
     * @return RoleAllowedCustomer
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
