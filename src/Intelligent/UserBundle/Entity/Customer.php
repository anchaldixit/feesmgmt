<?php

namespace Intelligent\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 */
class Customer {
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
     * @ORM\Column(name="customer_name", type="string", length=100, nullable=false)
     */
    private $name; 
    
    /**
     * 
     * Many Customer have Many Reports.
     * @ORM\ManyToMany(targetEntity="Report")
     * @ORM\JoinTable(name="customer_allowed_reports",
     *      joinColumns={@ORM\JoinColumn(name="customer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="report_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $reports;

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
     * @return Customer
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
     * Constructor
     */
    public function __construct()
    {
        $this->reports = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reports
     *
     * @param \Intelligent\UserBundle\Entity\Report $reports
     * @return Customer
     */
    public function addReport(\Intelligent\UserBundle\Entity\Report $reports)
    {
        $this->reports[] = $reports;

        return $this;
    }

    /**
     * Remove reports
     *
     * @param \Intelligent\UserBundle\Entity\Report $reports
     */
    public function removeReport(\Intelligent\UserBundle\Entity\Report $reports)
    {
        $this->reports->removeElement($reports);
    }

    /**
     * Get reports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReports()
    {
        return $this->reports;
    }
}
