<?php

namespace Intelligent\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleModulePermission
 *
 * @ORM\Table(name="role_module_permission")
 * @ORM\Entity
 */
class RoleModulePermission
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="modulePermissions")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string", nullable=false)
     */
    private $module;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_permission", type="boolean", nullable=false)
     */
    private $viewPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modify_permission", type="boolean", nullable=false)
     */
    private $modifyPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="add_permission", type="boolean", nullable=false)
     */
    private $addPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delete_permission", type="boolean", nullable=false)
     */
    private $deletePermission;

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
     * Set viewPermission
     *
     * @param boolean $viewPermission
     * @return RoleModulePermission
     */
    public function setViewPermission($viewPermission)
    {
        $this->viewPermission = $viewPermission;

        return $this;
    }

    /**
     * Get viewPermission
     *
     * @return boolean 
     */
    public function getViewPermission()
    {
        return $this->viewPermission;
    }

    /**
     * Set modifyPermission
     *
     * @param boolean $modifyPermission
     * @return RoleModulePermission
     */
    public function setModifyPermission($modifyPermission)
    {
        $this->modifyPermission = $modifyPermission;

        return $this;
    }

    /**
     * Get modifyPermission
     *
     * @return boolean 
     */
    public function getModifyPermission()
    {
        return $this->modifyPermission;
    }

    /**
     * Set addPermission
     *
     * @param boolean $addPermission
     * @return RoleModulePermission
     */
    public function setAddPermission($addPermission)
    {
        $this->addPermission = $addPermission;

        return $this;
    }

    /**
     * Get addPermission
     *
     * @return boolean 
     */
    public function getAddPermission()
    {
        return $this->addPermission;
    }

    /**
     * Set deletePermission
     *
     * @param boolean $deletePermission
     * @return RoleModulePermission
     */
    public function setDeletePermission($deletePermission)
    {
        $this->deletePermission = $deletePermission;

        return $this;
    }

    /**
     * Get deletePermission
     *
     * @return boolean 
     */
    public function getDeletePermission()
    {
        return $this->deletePermission;
    }

    /**
     * Set role
     *
     * @param \Intelligent\UserBundle\Entity\Role $role
     * @return RoleModulePermission
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
     * Set module
     *
     * @param string $module
     * @return RoleModulePermission
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string 
     */
    public function getModule()
    {
        return $this->module;
    }
}
