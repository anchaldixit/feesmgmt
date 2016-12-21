<?php

namespace Intelligent\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Intelligent\UserBundle\Entity\Role;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity
 */
class User implements AdvancedUserInterface, \Serializable
{
    const REGISTERED = 1;
    const UNREGISTERED = 2;
    const UNVERIFIED = 3;
    const DEACTIVATED = 4;
    const DENIED = 5;
    const PASSWORD_RESET = 6;
            
            
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="verification_id", type="string", length=100, nullable=true)
     */
    private $verificationId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password_reset_id", type="string", length=100, nullable=true)
     */
    private $passwordResetId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var Role
     * @ORM\OneToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;
    
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
     * 
     * @return type
     */
    public function getSalt(){
        return null;
    }
    
    public function isEnabled() {
        if($this->status == User::REGISTERED){
            return true;
        }else{
            return false;
        }
    }
    
    public function isAccountNonExpired() {
        return true;
    }
    
    public function isAccountNonLocked() {
        return true;;
    }
    
    public function isCredentialsNonExpired() {
        return true;
    }
    
    /**
     * This function returns the username which is
     * the email in this case
     * 
     * @return string returns the email as username
     */
    public function getUsername() {
        return $this->email;
    }
    
    /**
     * This function will return the symfony roles
     * 
     * @return array 
     */
    public function getRoles() {
        return array("ROLE_USER");
    }

    /**
     * This function will be called to erase the user credentials
     * Not sure what it is
     */
    public function eraseCredentials() {
        ;
    }
    
    /**
     * This will return the serialized array of the 
     * user information 
     * 
     * @return string
     */
    public function serialize() {
        return serialize(array($this->id, $this->email, $this->password ));
    }
    
    /**
     * This function will return the user object from
     * the serialized array
     * 
     * @param type $serialized
     */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * This function will return the password
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * Set Name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set verificationId
     *
     * @param string $verificationId
     * @return User
     */
    public function setVerificationId($verificationId)
    {
        $this->verificationId = $verificationId;

        return $this;
    }

    /**
     * Get verificationId
     *
     * @return string 
     */
    public function getVerificationId()
    {
        return $this->verificationId;
    }

    /**
     * Set passwordResetId
     *
     * @param string $passwordResetId
     * @return User
     */
    public function setPasswordResetId($passwordResetId)
    {
        $this->passwordResetId = $passwordResetId;

        return $this;
    }

    /**
     * Get passwordResetId
     *
     * @return string 
     */
    public function getPasswordResetId()
    {
        return $this->passwordResetId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    
    /**
     * Set createDatetime
     *
     * @param \DateTime $createDatetime
     * @return User
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
     * @return User
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
     * Set role
     *
     * @param \Intelligent\UserBundle\Entity\Role $role
     * @return User
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
