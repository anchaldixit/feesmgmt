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

    public function getUser() {
        return $this->user;
    }
    
    public function getSetting(){
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
     * This function will return the permissions user have for
     * individual fields in the module row
     * 
     * @param string $module Name of the module
     * @param string $field  Name of the field
     * @return mixed false => if module or field do not exists
     *               0 => if no view or edit access,
     *               1 => if only view access is enabled
     *               2 => if view and edit both permissions are enabled
     */
    public function getFieldPermissionFor($module, $field) {
        # First check if the module and field exists
        if ($this->isfieldExists($module,$field)) {
            # Then see if the module permission exists then we have to see
            # if we have explicit information on the fields or not 
            # First get the module permission object
            $module_permission = $this->role->getSingleModulePermission($module);
            if ($module_permission instanceof RoleModulePermission) {
                # Let's see if the custom permission is on or not
                $custom_field_permission = $module_permission->getFieldPermission();
                if ($custom_field_permission === FALSE) {
                    # Then it will fall back on the global module permission
                    if ($module_permission->getModifyPermission()) {
                        return 2; // give edit permission
                    } else if ($module_permission->getViewPermission()) {
                        return 1; // give read permission
                    } else {
                        return 0; // no permission
                    }
                } else {
                    $field_permission = $module_permission->getSingleFieldPermissions($field);
                    if ($field_permission instanceof RoleModuleFieldPermission) {
                        return $field_permission->getPermission();
                    } else {
                        # Again it will fall back on the global module permission
                        if ($module_permission->getModifyPermission()) {
                            return 2; // give edit permission
                        } else if ($module_permission->getViewPermission()) {
                            return 1; // give read permission
                        } else {
                            return 0; // no permission
                        }
                    }
                }
            } else {
                return 0; // Not even a view access
            }
        } else {
            return false;
        }
    }

    public function isModuleExists($moduleName) {
        return in_array($moduleName, array_keys($this->settings->getModule()));
    }

    public function isfieldExists($moduleName, $fieldName) {
        if($this->isModuleExists($moduleName)){
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
