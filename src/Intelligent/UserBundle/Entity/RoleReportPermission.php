<?php
namespace Intelligent\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Intelligent\UserBundle\Entity\Role;
use Intelligent\UserBundle\Entity\Report;

/**
 * RoleReportPermission
 *
 * @ORM\Table(name="role_report_permission")
 * @ORM\Entity
 */
class RoleReportPermission {
    
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
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="reportPermissions")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * 
     */
    private $role;
    
    /**
     * Many Role permission have one report.
     * @ORM\ManyToOne(targetEntity="Report")
     * @ORM\JoinColumn(name="report_id", referencedColumnName="id")
     */
    
    private $report;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="permission", type="boolean", nullable=false)
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
     * Set permission
     *
     * @param boolean $permission
     * @return RoleReportPermission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return boolean 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set report
     *
     * @param \Intelligent\UserBundle\Entity\Report $report
     * @return RoleReportPermission
     */
    public function setReport(\Intelligent\UserBundle\Entity\Report $report = null)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \Intelligent\UserBundle\Entity\Report 
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set role
     *
     * @param \Intelligent\UserBundle\Entity\Role $role
     * @return RoleReportPermission
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
