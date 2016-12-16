<?php

namespace Intelligent\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\Role;

/**
 * RoleGlobalPermission
 *
 * @ORM\Table(name="role_global_permission")
 * @ORM\Entity
 */
class RoleGlobalPermission
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Role
     * 
     * @ORM\OneToOne(targetEntity="Role", inversedBy="globalPermission")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var boolean
     *
     * @ORM\Column(name="manage_user_app_permission", type="boolean", nullable=false)
     */
    private $manageUserAppPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="edit_app_structure_permission", type="boolean", nullable=false)
     */
    private $editAppStructurePermission;



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
     * Set manageUserAppPermission
     *
     * @param boolean $manageUserAppPermission
     * @return RoleGlobalPermission
     */
    public function setManageUserAppPermission($manageUserAppPermission)
    {
        $this->manageUserAppPermission = $manageUserAppPermission;

        return $this;
    }

    /**
     * Get manageUserAppPermission
     *
     * @return boolean 
     */
    public function getManageUserAppPermission()
    {
        return $this->manageUserAppPermission;
    }

    /**
     * Set editAppStructurePermission
     *
     * @param boolean $editAppStructurePermission
     * @return RoleGlobalPermission
     */
    public function setEditAppStructurePermission($editAppStructurePermission)
    {
        $this->editAppStructurePermission = $editAppStructurePermission;

        return $this;
    }

    /**
     * Get editAppStructurePermission
     *
     * @return boolean 
     */
    public function getEditAppStructurePermission()
    {
        return $this->editAppStructurePermission;
    }

    /**
     * Set role
     *
     * @param \Intelligent\UserBundle\Entity\Role $role
     * @return RoleGlobalPermission
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
}
