<?php
namespace Intelligent\UserBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Intelligent\UserBundle\Entity\Role;
use Intelligent\UserBundle\Entity\RoleGlobalPermission;
use Intelligent\UserBundle\Entity\RoleModulePermission;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This service will give information about the user settings
 *
 * @author tejaswi
 */
class UserPermissions {
    
    private $user;
    private $doctrine;
    private $globalPermission;
    private $modulePermissions;
    
    public function __construct(TokenStorage $tokenStorage, Registry $doctrine) {
        // Recieve other services
        
        $this->doctrine = $doctrine;
        $this->user = $tokenStorage->getToken()->getUser();
        //$role = null;
        $role = $this->user->getRole();
        
        // Get global and module level permissions
        if(($role instanceof Role)){
            $this->globalPermission = $role->getGlobalPermission();
            $this->modulePermissions= $role->getModulePermissions();
        }else{
            $this->globalPermission = null;
            $this->modulePermissions= new ArrayCollection();
        }
    }
    
    public function getUser(){
        return $this->user;
    }
    
    /**
     * This function will tell if the user have permission for
     * managing users and sharing the app
     * 
     * @return bool true if it has permission false if not.
     */
    public function getManageUserAndShareAppPermission(){
        if($this->globalPermission instanceof RoleGlobalPermission){
            return $this->globalPermission->getManageUserAppPermission();
        }else{ 
            return false;
        }
    }
    
    /**
     * This function will tell if the user have permission for
     * editing app structure
     * 
     * @return bool true if it has permission false if not.
     */
    
    public function getEditAppStructurePermission() {
        if($this->globalPermission instanceof RoleGlobalPermission){
            return $this->globalPermission->getEditAppStructurePermission();
        }else{ 
            return false;
        }
    }
    
    /**
     * This function will return the permissions user have for
     * viewing rows of the module
     * 
     * @param string $module Name of the module
     * @return bool true if it has permission false if not
     */
    
    public function getViewPermission($module) {
        $modulePermission = $this->_getModulePermissions($module);
        if($modulePermission instanceof RoleModulePermission){
            return $modulePermission->getViewPermission();
        }else{
            return false;
        }
    }
    
    /**
     * This function will return the permissions user have for
     * editing rows of the module
     * 
     * @param string $module Name of the module
     * @return bool true if it has permission false if not
     */
    
    public function getEditPermission($module){
        $modulePermission = $this->_getModulePermissions($module);
        if($modulePermission instanceof RoleModulePermission){
            return $modulePermission->getModifyPermission();
        }else{
            return false;
        }
    }
    
    /**
     * This function will return the permissions user have for
     * adding rows to the module
     * 
     * @param string $module Name of the module
     * @return bool true if it has permission false if not
     */
    
    public function getAddPermission($module){
        $modulePermission = $this->_getModulePermissions($module);
        if($modulePermission instanceof RoleModulePermission){
            return $modulePermission->getAddPermission();
        }else{
            return false;
        }
    }
    
    /**
     * This function will return the permissions user have for
     * adding rows to the module
     * 
     * @param string $module Name of the module
     * @return bool true if it has permission false if not
     */
    public function getDeletePermission($module){
        $modulePermission = $this->_getModulePermissions($module);
        if($modulePermission instanceof RoleModulePermission){
            return $modulePermission->getDeletePermission();
        }else{
            return false;
        }
    }
    
    /**
     * This will find the module settings for the current role
     * 
     * @param type $module name of the module
     * @return mixed RoleModulePermission if there is a setting for module or null
     */
    private function _getModulePermissions($module){
        if(count($this->modulePermissions) == 0){
            return null;
        }else{
            foreach($this->modulePermissions as $modulePermission){
                if($modulePermission->getModule() === $module){
                    return $modulePermission;
                }
            }
            return null;
        }
    }
    
}
