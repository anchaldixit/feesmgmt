<?php

namespace Intelligent\UserBundle\Services;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Intelligent\UserBundle\Entity\Role;
use Intelligent\UserBundle\Entity\RoleModulePermission;
use Intelligent\UserBundle\Entity\RoleGlobalPermission;
use Intelligent\UserBundle\Entity\RoleModuleFieldPermission;
use Intelligent\SettingBundle\Lib\Settings;

/**
 * This service will give information about the user settings
 *
 * @author tejaswi
 */
class UserPermissions {

    /**
     * @var Settings
     */
    private $settings;

    /**
     * Role of the current loggedin user
     * 
     * @var Role
     */
    private $role;

    public function __construct(TokenStorage $tokenStorage, Settings $settings) {
        // Recieve other services
        $this->settings = $settings;
        $this->role = $tokenStorage->getToken()->getUser()->getRole();
    }

    /**
     * Get the seetings
     * 
     * @return Intelligent\SettingBundle\Lib\Settings
     */
    public function getSetting() {
        return $this->settings;
    }

    /**
     * This function will tell if the user have permission for
     * managing users and sharing the app
     * 
     * @return bool true if it has permission false if not.
     */
    public function getManageUserAndShareAppPermission() {
        if ($this->role->getGlobalPermission() instanceof RoleGlobalPermission) {
            return $this->role->getGlobalPermission()->getManageUserAppPermission();
        } else {
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
        if ($this->role->getGlobalPermission() instanceof RoleGlobalPermission) {
            return $this->role->getGlobalPermission()->getEditAppStructurePermission();
        } else {
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
        $modulePermission = $this->role->getSingleModulePermission($module);
        if ($modulePermission instanceof RoleModulePermission) {
            return $modulePermission->getViewPermission();
        } else {
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
    public function getEditPermission($module) {
        $modulePermission = $this->role->getSingleModulePermission($module);
        if ($modulePermission instanceof RoleModulePermission) {
            return $modulePermission->getModifyPermission();
        } else {
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
    public function getAddPermission($module) {
        $modulePermission = $this->role->getSingleModulePermission($module);
        if ($modulePermission instanceof RoleModulePermission) {
            return $modulePermission->getAddPermission();
        } else {
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
    public function getDeletePermission($module) {
        $modulePermission = $this->role->getSingleModulePermission($module);
        if ($modulePermission instanceof RoleModulePermission) {
            return $modulePermission->getDeletePermission();
        } else {
            return false;
        }
    }

    /**
     * This function will return true if that module have custom 
     * access enabled for individual fields
     * 
     * @param string $module Name of the module
     * @return bool true if custom access is enabled. false if not
     */
    public function getCustomFieldPermission($module) {
        $modulePermission = $this->role->getSingleModulePermission($module);
        if ($modulePermission instanceof RoleModulePermission) {
            return $modulePermission->getFieldPermission();
        } else {
            return false;
        }
    }

    /**
     * This function returns the permission of fields in the module
     * 
     * @param type $module
     * @param type $userFieldIdAsKey
     * @return mixed It returns array of field and permission if module exists
     * and returns false if module dont exists
     */
    public function getAllFieldPermissions($module,$userFieldIdAsKey=true) {
        $fields_permission = array();
        if ($this->isModuleExists($module)) {
            $fields = $this->getSetting()->fetch(array("module" => $module));
            if(count($fields) > 0){
                $module_permission = $this->role->getSingleModulePermission($module);
                foreach ($fields as $field) {
                    if(!($module_permission instanceof RoleModulePermission)){
                        $permission = 0; // Not even a view access;
                    }else{
                        $view_permission = $module_permission->getViewPermission();
                        $edit_permission = $module_permission->getModifyPermission();
                        // If custom field permission exists
                        if($module_permission->getFieldPermission()){
                            // If we have a explicit field permission
                            $explicit_field_permission = $module_permission->getSingleFieldPermissions($field['module_field_name']);
                            if($explicit_field_permission instanceof RoleModuleFieldPermission){
                                $permission = $explicit_field_permission->getPermission();
                            }else{
                                if($edit_permission && $view_permission){
                                    $permission = 2; // Edit pemission
                                }else if($view_permission){
                                    $permission = 1; // View permission
                                }else{
                                    $permission = 0; // Not even view permission
                                }
                            }
                        }else{
                            if($edit_permission && $view_permission){
                                $permission = 2; // Edit pemission
                            }else if($view_permission){
                                $permission = 1; // View permission
                            }else{
                                $permission = 0; // Not even view permission
                            }
                        }
                    }
                    // Chose return format;
                    if($userFieldIdAsKey){
                        $fields_permission[$field['module_field_name']] = $permission;
                    }else{
                        $fields_permission[] = array(
                            'id' => $field['module_field_name'],
                            'name' => $field['module_field_display_name'],
                            'permission' => $permission
                        );
                    }
                }
            }
            return $fields_permission;
        }else{
            return false;
        }
    }

    /**
     * Check is the module with the module name exists
     * 
     * @param type $moduleName
     * @return bool
     */
    public function isModuleExists($moduleName) {
        return in_array($moduleName, array_keys($this->settings->getModule()));
    }

    /**
     * Check is the field exists in a module
     * 
     * @param type $moduleName
     * @param type $fieldName
     * @return boolean
     */
    public function isfieldExists($moduleName, $fieldName) {
        if (!$this->isModuleExists($moduleName)) {
            return false;
        }
        $fields = $this->settings->fetch(array('module' => $moduleName));
        foreach ($fields as $field) {
            if ($field['module_field_name'] == $fieldName) {
                return true;
            }
        }
        return false;
    }

}
