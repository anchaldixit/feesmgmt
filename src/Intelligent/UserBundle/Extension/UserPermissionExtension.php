<?php
namespace Intelligent\UserBundle\Extension;
use Intelligent\UserBundle\Services\UserPermissions;

/**
 * Description of UserPermissionExtension
 *
 * @author tejaswi
 */
class UserPermissionExtension extends \Twig_Extension{
    private $permission;
    
    public function __construct(UserPermissions $permission) {
        $this->permissions = $permission;
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('is_module_visible', array($this->permissions, 'isModuleVisible')),
            new \Twig_SimpleFunction('is_user_admin', array($this->permissions, 'getManageUserAndShareAppPermission')),
            new \Twig_SimpleFunction('is_app_admin', array($this->permissions, 'getEditAppStructurePermission')),
        );
    }
}
