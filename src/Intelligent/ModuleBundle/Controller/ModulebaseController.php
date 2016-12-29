<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Intelligent\ModuleBundle\Lib\Marketingprojects;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class ModulebaseController extends Controller {

    var $module_name; //variable should be initialize by extend class in constructor
    var $module_classname;
    var $module; //Module object
    var $module_route_identifier;
    protected $permissions;
    protected $limit = 20;

    function __construct() {

        if (empty($this->module_name)) {
            throw new \Exception('Module name not configured', '001');
        } else {
            $this->module_route_identifier = str_replace('_', '', $this->module_name);
            $this->module_classname = ucfirst($this->module_route_identifier);
            $class = "Intelligent\\ModuleBundle\\Lib\\{$this->module_classname}";
            if (!class_exists($class)) {
                throw new \Exception("{$this->module_classname} Module class not found", '001');
            }
        }
    }

    /*
     * Forcing the user to call this function to initialize $module variable
     */

    abstract function setModuleName();

    public function editAction($edit_id) {


        $this->initPermissionsDetails();
        if ($this->noAccess('view')) {
            return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
        }



        $conn = $this->get('database_connection');
        #echo get_class($conn);
        #$module = new Marketingprojects($conn);
        $class = "Intelligent\\ModuleBundle\\Lib\\{$this->module_classname}";
        $module = new $class($conn);

        $module_display_name = $module->module_settings->getModule($this->module_name);

        $request = Request::createFromGlobals();
        $id = null;

        try {
            if ($request->isMethod('POST')) {//Result submited
                $post = $request->request->all();
                $result = array();
                $result['row'][0] = $post;
                if (empty($request->request->get('id'))) {
                    //save
                    if ($this->noAccess('add')) {
                        return $this->noAccessPage();
                    }
                    $id = $module->save($post);

                    $this->get('session')->getFlashBag()->add('success', "Row added successfully.");
                    return $this->redirectToRoute("intelligent_{$this->module_route_identifier}_edit", array('edit_id' => $id));
                } else {

                    if (!empty($request->request->get('delete_submit'))) {
                        //delete
                        if ($this->noAccess('delete')) {
                            return $this->noAccessPage();
                        }
                        $module->delete($request->request->get('id'));

                        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
                        return $this->redirectToRoute("intelligent_{$this->module_route_identifier}_view");
                    } else {//update
                        if ($this->noAccess('edit')) {
                            return $this->noAccessPage();
                        }
                        $id = $edit_id;
                        $module->update($post);

                        $this->get('session')->getFlashBag()->add('success', "Row Updated successfully.");
                        return $this->redirectToRoute("intelligent_{$this->module_route_identifier}_edit", array('edit_id' => $edit_id));
                    }
                }
                $id = is_numeric($edit_id) ? $edit_id : null;
            } else {
                //Display form with fields

                if (is_numeric($edit_id)) {
                    //Display forms with fetched data

                    $result = $module->getRow($edit_id);
                    $id = $edit_id;

                    if (empty($result)) {
                        //@todo: just for testing, redirect to listing page
                        throw new \Exception('Invalid Edit Request', '011');
                    }
                } else {
                    //new item, display empty form
                    //schema need to initilize separately becuase on no db required, its add request
                    $result = array('schema' => $module->getFormFields());
                    $id = null; //no id will be there
                }
            }
        } catch (\Exception $e) {
            //$message = $e->getMessage();
            $this->get('session')->getFlashBag()->add('error', $e->getMessage() . '|' . $e->getLine() . '|' . $e->getFile());
            if (!isset($result['schema'])) {
                //There are chance that schema is not initialized and exception is thrown. To display form schema is must required to create page
                $result['schema'] = $module->getFormFields();
            }
        }
        //All active users
        $all_users = $this->getUsers();

        //var_dump($result);exit;
        $parameters = array('data' => isset($result['row']) ? $result['row'][0] : array(),
            'schema' => $result['schema'],
            'id' => $id,
            'users' => $all_users,
            'module_name' => $module_display_name,
            'module' => $this->module_route_identifier,
            'module_permission_asscess_key' => $this->moduleSessionKey(),
            'permissions' => $this->permissions
        );


        return $this->render('IntelligentModuleBundle:Default:edit.html.twig', $parameters);
    }

    public function viewAction($page_no) {


        $this->initPermissionsDetails();
        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }

        $conn = $this->get('database_connection');

        $request = Request::createFromGlobals();
        $class = "Intelligent\\ModuleBundle\\Lib\\{$this->module_classname}";
        $module = new $class($conn);

        $module_display_name = $module->module_settings->getModule($this->module_name);

        $filters = $request->query->all();
        array_walk_recursive($filters, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });

        $params = $this->prepareFilterCondtion($filters);


        //Set sort filter
        $sort = $this->prepareSort($filters);
        //Fetch the data
        $limit_plus_offset = $this->prepareLimit($page_no);



        $rows = $module->getRows($params, $sort, $limit_plus_offset);

        $count = $module->totalCountOfLastFetch();
        $total_page_count = ceil($count / $this->limit);
        $pagination = array('active' => $page_no, 'total_count' => $total_page_count);

        $all_users = $this->getUsers();

        $parameters = array('rows' => $rows['row'],
            'schema' => $rows['schema'],
            'selected_filters' => $filters,
            'pagination' => $pagination,
            'users' => $all_users,
            'module_name' => $module_display_name,
            'module' => $this->module_route_identifier,
            'module_permission_asscess_key' => $this->moduleSessionKey(),
            'permissions' => $this->permissions
        );
        return $this->render('IntelligentModuleBundle:Default:view.html.twig', $parameters);
    }

    function getUsers() {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder();
        $query->select("u")
                ->from("IntelligentUserBundle:User", "u");
        $query->andWhere($query->expr()->in("u.status", 1));

        $dql = $query->getQuery();
        $results = $dql->getResult();
        $userlist = array();
        foreach ($results as $key => $user) {
            $userlist[$user->getId()] = $user->getName();
        }
        return $userlist;
    }

    function setLimit($limit) {
        $this->limit = $limit;
    }

    function prepareSort($filters) {

        $sort = array("{$this->module_name}.id" => 'DESC');

        //Set sort filter
        if (isset($filters['sort']) and ! empty($filters['sort'])) {
            $sort = array();
            $arr_sort = explode('|', $filters['sort']);
            $sort[$arr_sort[0]] = $arr_sort[1];
        }
        return $sort;
    }

    function prepareFilterCondtion($filters) {

        $params = array();
        if (isset($filters['filter'])) {
            if (!empty($filters['filter']['text'])) {
                foreach ($filters['filter']['text'] as $key => $value) {
                    $params[$key]['like'] = "%{$value}%";
                }
            }
            if (!empty($filters['filter']['match'])) {
                foreach ($filters['filter']['match'] as $field => $value) {
                    $params[$field] = $value;
                }
            }
        }
        return $params;
    }

    function prepareLimit($page_no) {
        $limit_plus_offset = '';
        if ($page_no > 0) {
            $limit = $this->limit;
            $offset = ($page_no - 1) * $limit;
            $limit_plus_offset = "$offset,$limit";
        }
        return $limit_plus_offset;
    }

    function initPermissionsDetails() {


        // $permission = 0; // No view
// $permission = 1; // Only view
// $permission = 2; // Edit and view both

        $session = new Session();

        $cache_permission = $session->get($this->moduleSessionKey());

        if (1 or ! count($cache_permission)) {

            $user_permission = $this->get("user_permissions");

            $permission['add'] = $user_permission->getAddPermission($this->module_name);
            $permission['view'] = $user_permission->getViewPermission($this->module_name);
            $permission['delete'] = $user_permission->getDeletePermission($this->module_name);
            $permission['edit'] = $user_permission->getEditPermission($this->module_name);
            $permission['custom'] = $user_permission->getCustomFieldPermission($this->module_name);
            $permission['custom_field'] = $user_permission->getAllFieldPermissions($this->module_name);

            $session->set($this->moduleSessionKey(), $permission);
            $this->permissions = $permission;
        } else {
            $permission = $cache_permission;
            $this->permissions = $permission;
        }

        return $permission;
    }

    function noAccess($action) {

        return isset($this->permissions[$action]) ? !$this->permissions[$action] : true;
    }

    function noAccessPage() {
        
        return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
        
    }

    function moduleSessionKey() {

        return "access-key-{$this->module_name}-permission";
    }

}
