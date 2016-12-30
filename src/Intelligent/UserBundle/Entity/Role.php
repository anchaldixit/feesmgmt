<?php

namespace Intelligent\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\RoleGlobalPermission;
use Intelligent\UserBundle\Entity\RoleModulePermission;
use Doctrine\Common\Collections\Collection;


/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
    const ACTIVE = 1;
    const DEACTIVE = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_datetime", type="datetime", nullable=false)
     */
    private $createDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_datetime", type="datetime", nullable=false)
     */
    private $updateDatetime;
    
    /**
     * @var RoleGlobalPermission
     *
     * @ORM\OneToOne(targetEntity="RoleGlobalPermission", mappedBy="role" , cascade={"persist"})
     */
    private $globalPermission;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="RoleModulePermission", mappedBy="role")
     */
    private $modulePermissions;
    
    
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
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Role
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createDatetime
     *
     * @param \DateTime $createDatetime
     * @return Role
     */
    public function setCreateDatetime($createDatetime)
    {
        $this->createDatetime = $createDatetime;

        return $this;
    }

    /**
     * Get createDatetime
     *
     * @return \DateTime 
     */
    public function getCreateDatetime()
    {
        return $this->createDatetime;
    }

    /**
     * Set updateDatetime
     *
     * @param \DateTime $updateDatetime
     * @return Role
     */
    public function setUpdateDatetime($updateDatetime)
    {
        $this->updateDatetime = $updateDatetime;

        return $this;
    }

    /**
     * Get updateDatetime
     *
     * @return \DateTime 
     */
    public function getUpdateDatetime()
    {
        return $this->updateDatetime;
    }
    

    /**
     * Set globalPermission
     *
     * @param \Intelligent\UserBundle\Entity\RoleGlobalPermission $globalPermission
     * @return Role
     */
    public function setGlobalPermission(\Intelligent\UserBundle\Entity\RoleGlobalPermission $globalPermission = null)
    {
        $this->globalPermission = $globalPermission;

        return $this;
    }

    /**
     * Get globalPermission
     *
     * @return \Intelligent\UserBundle\Entity\RoleGlobalPermission 
     */
    public function getGlobalPermission()
    {
        return $this->globalPermission;
    }

    /**
     * Add modulePermissions
     *
     * @param \Intelligent\UserBundle\Entity\RoleModulePermission $modulePermissions
     * @return Role
     */
    public function addModulePermission(\Intelligent\UserBundle\Entity\RoleModulePermission $modulePermissions)
    {
        $this->modulePermissions[] = $modulePermissions;

        return $this;
    }

    /**
     * Remove modulePermissions
     *
     * @param \Intelligent\UserBundle\Entity\RoleModulePermission $modulePermissions
     */
    public function removeModulePermission(\Intelligent\UserBundle\Entity\RoleModulePermission $modulePermissions)
    {
        $this->modulePermissions->removeElement($modulePermissions);
    }

    /**
     * Get modulePermissions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModulePermissions()
    {
        return $this->modulePermissions;
    }
    
    /**
     * Get a single module permission
     * 
     * @param string $moduleName Name of the module
     * @return RoleModulePermission
     */
    
    public function getSingleModulePermission($moduleName){
        $all_module_permissions = $this->getModulePermissions();
        foreach($all_module_permissions as $module_permission_obj){
            if($module_permission_obj->getModule() == $moduleName){
                return $module_permission_obj;
            }
        }
        return null;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modulePermissions = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
