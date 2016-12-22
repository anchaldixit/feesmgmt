<?php
namespace Intelligent\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\RoleModulePermission;

/**
 * RoleModuleFieldPermission
 *
 * @ORM\Table(name="role_module_field_permission")
 * @ORM\Entity
 */
class RoleModuleFieldPermission {
    const VIEW = 1;
    const EDIT = 2;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var RoleModulePermission
     * @ORM\ManyToOne(targetEntity="RoleModulePermission", inversedBy="fieldPermissions")
     * @ORM\JoinColumn(name="module_permission_id", referencedColumnName="id")
     */
    private $modulePermission;
    /**
     * @var string
     *
     * @ORM\Column(name="field_name_id", type="string", nullable=false)
     */
    private $fieldNameId;
    /**
     * @var integer
     *
     * @ORM\Column(name="permission", type="integer", nullable=false)
     */
    private $permission;

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
     * Set fieldNameId
     *
     * @param string $fieldNameId
     * @return RoleModuleFieldPermission
     */
    public function setFieldNameId($fieldNameId)
    {
        $this->fieldNameId = $fieldNameId;

        return $this;
    }

    /**
     * Get fieldNameId
     *
     * @return string 
     */
    public function getFieldNameId()
    {
        return $this->fieldNameId;
    }

    /**
     * Set permission
     *
     * @param integer $permission
     * @return RoleModuleFieldPermission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return integer 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set modulePermission
     *
     * @param \Intelligent\UserBundle\Entity\RoleModulePermission $modulePermission
     * @return RoleModuleFieldPermission
     */
    public function setModulePermission(\Intelligent\UserBundle\Entity\RoleModulePermission $modulePermission = null)
    {
        $this->modulePermission = $modulePermission;

        return $this;
    }

    /**
     * Get modulePermission
     *
     * @return \Intelligent\UserBundle\Entity\RoleModulePermission 
     */
    public function getModulePermission()
    {
        return $this->modulePermission;
    }
}
