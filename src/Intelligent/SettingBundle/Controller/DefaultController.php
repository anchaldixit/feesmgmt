<?php

namespace Intelligent\SettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intelligent\SettingBundle\Lib\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller {

    /*
     * Not in use
     */
    public function indexAction() {
        return $this->render('IntelligentSettingBundle:Default:index.html.twig');
    }

    /*
     * Edit Action
     */
    public function editAction($edit_id) {

        $this->initPermissionsDetails();
        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }

        $settings = $this->get('intelligent.setting.module');
        $modules = $settings->getModule();
        $datatypes = $settings->getModuleDataTypes();

        // Get All group Name to Fill in Group Drop Down
        $allgroups = $settings->getGroupName();

        $request = Request::createFromGlobals();
        $id = null;

        try {
            if ($request->isMethod('POST')) {//Result submited
                $post = $request->request->all();
                $result = array();
                $result[] = $post;
                if (empty($request->request->get('id'))) {
                    //save

                    $id = $settings->save($post);
                    $this->get('session')->getFlashBag()->add('success', "Row added successfully.");
                    return $this->redirectToRoute('intelligent_setting_edit', array_merge($request->query->all(), array('edit_id' => $id)));
                } else {

                    if (!empty($request->request->get('delete_submit'))) {
                        //delete
                        $settings->delete($request->request->get('id'));
                        //@todo: redirect should be done 
                        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
                        return $this->redirectToRoute('intelligent_setting_view', $request->query->all());
                    } else {//update
                        $id = $edit_id;
                        $settings->update($post);
                        $this->get('session')->getFlashBag()->add('success', "Row Updated successfully.");
                        return $this->redirectToRoute('intelligent_setting_edit', array_merge($request->query->all(), array('edit_id' => $id)));
                    }
                }
                $id = is_numeric($edit_id) ? $edit_id : null;
            } else {

                if (is_numeric($edit_id)) {
                    $result = $settings->fetch(array('id' => $edit_id));
                    $id = $edit_id;
                    if (empty($result)) {
                        //@todo: just for testing, redirect to listing page
                        throw new \Exception('Invalid Edit Request', '011');
                    }
                } else {//new item
                    $result = array(array());
                    $id = null;
                }
            }
        } catch (\Exception $e) {
            //$message = $e->getMessage();
            $this->get('session')->getFlashBag()->add('error', $e->getMessage() . '<br>' . $e->getTraceAsString());
            //var_dump($e);
        }

        //$groupId = $result[0]['field_group_id'];
        //$groupOrder = $settings->getGroupOrderById(array('id'=>$groupId));

        $parameters = array('field' => $result,
            'modules' => $modules,
            'datatypes' => $datatypes,
            'allgroups' => $allgroups,
            'id' => $id);

        return $this->render('IntelligentSettingBundle:Default:edit.html.twig', $parameters);
    }

    /*
     * View action
     */
    public function viewAction($page_no) {

        $this->initPermissionsDetails();
        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }

        $this->initPermissionsDetails();

        $request = Request::createFromGlobals();
        $settings = $this->get('intelligent.setting.module');

        $filters = $request->query->all();
        array_walk_recursive($filters, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });
        //var_dump($filters);
        $params = array();
        $sort = array('module' => 'ASC', 'display_position' => 'ASC');
        if (isset($filters['filter'])) {
            if (!empty($filters['filter']['text']['module_field_display_name'])) {
                $params['module_field_display_name']['like'] = "%{$filters['filter']['text']['module_field_display_name']}%";
            }
            if (!empty($filters['filter']['match'])) {

                foreach ($filters['filter']['match'] as $field => $value) {
                    $params[$field] = $value;
                }
            }
        }
        //Set sort filter
        if (isset($filters['sort']) and ! empty($filters['sort'])) {
            $sort = array();
            $arr_sort = explode('|', $filters['sort']);
            $sort[$arr_sort[0]] = $arr_sort[1];
        }
        //Fetch the data
        if ($page_no > 0) {
            $limit = 20;
            $offset = ($page_no - 1) * $limit;
            $limit_plus_offset = "$offset,$limit";
        }
        $row = $settings->fetch($params, $sort, $limit_plus_offset);

        $count = $settings->totalCountOfLastFetch();
        $total_page_count = ceil($count / $limit);
        $pagination = array('active' => $page_no, 'total_count' => $total_page_count);


        $modules = $settings->getModule();
        $datatypes = $settings->getModuleDataTypes();

        //var_dump($filters);

        $parameters = array('rows' => $row,
            'modules' => $modules,
            'datatypes' => $datatypes,
            'selected_filters' => $filters,
            'pagination' => $pagination
        );
        return $this->render('IntelligentSettingBundle:Default:view.html.twig', $parameters);
    }

    /*
     * Delete action
     * Param1: number $delete_id
     */
    public function deleteAction($delete_id) {

        $request = Request::createFromGlobals();
        $settings = $this->get('intelligent.setting.module');

        $settings->delete($delete_id);

        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");

        return $this->redirectToRoute('intelligent_setting_view', $request->query->all());
    }

    /*
     * Initialize the permissions to session.
     */
    private function initPermissionsDetails() {


        $session = $this->get('session');

        $cache_permission = $session->get($this->moduleSessionKey());

        if (1 or ! count($cache_permission)) {

            $user_permission = $this->get("user_permissions");

            $permission['view'] = $user_permission->getManageUserAndShareAppPermission();
            $permission['edit'] = $user_permission->getEditAppStructurePermission();


            $session->set($this->moduleSessionKey(), $permission);
            $this->permissions = $permission;
        } else {
            $permission = $cache_permission;
            $this->permissions = $permission;
        }

        return $permission;
    }

    /*
     * Return the key to store permssion in session. 
     */
    private function moduleSessionKey() {

        return "access-key-settings-permission";
    }

    /*
     * Check if the user action have permission or not
     * Param1 : string $action
     * return : boolean
     */
    private function noAccess($action) {

        return isset($this->permissions[$action]) ? !$this->permissions[$action] : true;
    }

    /*
     * Show No access page to user
     */
    private function noAccessPage() {

        return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
    }

    /*
     * Get all field names of module
     * 
     */
    public function fieldsetAction($module_name) {

        $var = str_replace('_', '', $module_name);
        $controller_class = $this->routeToControllerName("intelligent_{$var}_fieldset");
        $response = $this->forward($controller_class);

        return $response;

    }

    /*
     * Get the Controller name from the route name
     */
    private function routeToControllerName($routename) {
        
        $routes = $this->get('router')->getRouteCollection();
        return $routes->get($routename)->getDefaults()['_controller'];
        
    }

}
