<?php

namespace Intelligent\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleTablePermission
 *
 * @ORM\Table(name="role_table_permission")
 * @ORM\Entity
 */
class RoleTablePermission
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
     *
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    private $roleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="table_id", type="integer", nullable=false)
     */
    private $tableId;

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
     * @var boolean
     *
     * @ORM\Column(name="save_common_reports_permission", type="boolean", nullable=false)
     */
    private $saveCommonReportsPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="edit_field_permission", type="boolean", nullable=false)
     */
    private $editFieldPermission;

    /**
     * @var boolean
     *
     * @ORM\Column(name="access_field_permission", type="boolean", nullable=false)
     */
    private $accessFieldPermission;



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
     * Set roleId
     *
     * @param integer $roleId
     * @return RoleTablePermission
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return integer 
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set tableId
     *
     * @param integer $tableId
     * @return RoleTablePermission
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;

        return $this;
    }

    /**
     * Get tableId
     *
     * @return integer 
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * Set viewPermission
     *
     * @param boolean $viewPermission
     * @return RoleTablePermission
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
     * @return RoleTablePermission
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
     * @return RoleTablePermission
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
     * @return RoleTablePermission
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
     * Set saveCommonReportsPermission
     *
     * @param boolean $saveCommonReportsPermission
     * @return RoleTablePermission
     */
    public function setSaveCommonReportsPermission($saveCommonReportsPermission)
    {
        $this->saveCommonReportsPermission = $saveCommonReportsPermission;

        return $this;
    }

    /**
     * Get saveCommonReportsPermission
     *
     * @return boolean 
     */
    public function getSaveCommonReportsPermission()
    {
        return $this->saveCommonReportsPermission;
    }

    /**
     * Set editFieldPermission
     *
     * @param boolean $editFieldPermission
     * @return RoleTablePermission
     */
    public function setEditFieldPermission($editFieldPermission)
    {
        $this->editFieldPermission = $editFieldPermission;

        return $this;
    }

    /**
     * Get editFieldPermission
     *
     * @return boolean 
     */
    public function getEditFieldPermission()
    {
        return $this->editFieldPermission;
    }

    /**
     * Set accessFieldPermission
     *
     * @param boolean $accessFieldPermission
     * @return RoleTablePermission
     */
    public function setAccessFieldPermission($accessFieldPermission)
    {
        $this->accessFieldPermission = $accessFieldPermission;

        return $this;
    }

    /**
     * Get accessFieldPermission
     *
     * @return boolean 
     */
    public function getAccessFieldPermission()
    {
        return $this->accessFieldPermission;
    }
}
