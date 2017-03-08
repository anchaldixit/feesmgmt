<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;
use Intelligent\SettingBundle\Lib\Helper;

abstract class ModulebaseController extends Controller {

    const TOTAL_PAGINATION_VISIBLE_PAGES = 11; // Always an odd number

    var $module_name; //variable should be initialize by extend class in constructor
    var $module_classname;
    var $module; //Module object
    var $module_route_identifier;
    protected $permissions;
    protected $limit = 30;
    protected $helper;

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

        $this->helper = new Helper();
    }

    /*
     * Forcing the user to call this function to initialize $module variable
     */

    abstract function setModuleName();

    public function editAction($edit_id) {


        $this->initPermissionsDetails();

        //$this->initRowAccessPermission();

        if ($this->noAccess('view')) {
            return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
        }

        $module = $this->get("intelligent.{$this->module_name}.module");


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
                    $this->_afterSaveEvent($id);
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



                    if (!count($result['row'])) {
                        //@todo: just for testing, redirect to listing page
                        $this->get('session')->getFlashBag()->add('error', "Invalid URL/Access");
                        return $this->redirectToRoute("intelligent_{$this->module_route_identifier}_view");
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

        $parent_relationship_rows = $module->collectParentRelationshipRows();

        $result['schema'] = array_merge_recursive($result['schema'], $parent_relationship_rows);

        //All active users
        $all_users = $this->getUsers();

        //var_dump($result);exit;
        $parameters = array('data' => isset($result['row'][0]) ? $result['row'][0] : array(),
            'schema' => $result['schema'],
            'id' => $id,
            'users' => $all_users,
            'module_display_name' => $module_display_name,
            'module' => $this->module_route_identifier,
            'module_permission_asscess_key' => $this->moduleSessionKey(),
            'module_name' => $this->module_name,
            'permissions' => $this->permissions,
            'parent_relationship_rows' => $parent_relationship_rows
        );

        return $this->render('IntelligentModuleBundle:Default:edit.html.twig', $parameters);
    }

    public function viewAction($page_no) {


        $this->initPermissionsDetails();
        //$this->initRowAccessPermission();

        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }


        $module = $this->get("intelligent.{$this->module_name}.module");

        $request = Request::createFromGlobals();
        //$class = "Intelligent\\ModuleBundle\\Lib\\{$this->module_classname}";
        //$module = new $class($conn);

        $module_display_name = $module->module_settings->getModule($this->module_name);

        $filters = $request->query->all();

        array_walk_recursive($filters, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });

        $filters = $this->helper->removeEmptyConditions($filters);

        $params = $this->prepareFilterCondtion($filters);

        //Set sort filter
        $sort = $this->prepareSort($filters);
        //Fetch the data
        $limit_plus_offset = $this->prepareLimit($page_no);

        $rows = $module->getRows($params, $sort, $limit_plus_offset);

        $count = $module->totalCountOfLastFetch();
        $total_page_count = ceil($count / $this->limit);
        $pagination = array('active' => $page_no, 'limit' => $this->limit, 'total_record' => $count, 'total_count' => $total_page_count);
        $paging = $this->getPagination($page_no, $this->limit, $count);
        $all_users = $this->getUsers();

        $parameters = array('rows' => $rows['row'],
            'schema' => $rows['schema'],
            'selected_filters' => $filters,
            'pagination' => $pagination,
            'paging' => $paging,
            'users' => $all_users,
            'module_display_name' => $module_display_name,
            'module' => $this->module_route_identifier,
            'module_permission_asscess_key' => $this->moduleSessionKey(),
            'module_name' => $this->module_name,
            'permissions' => $this->permissions
        );
        return $this->render('IntelligentModuleBundle:Default:view.html.twig', $parameters);
    }

    public function exportAction() {


        $this->initPermissionsDetails();
        //$this->initRowAccessPermission();

        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }


        $module = $this->get("intelligent.{$this->module_name}.module");

        $request = Request::createFromGlobals();
        //$class = "Intelligent\\ModuleBundle\\Lib\\{$this->module_classname}";
        //$module = new $class($conn);

        $module_display_name = $module->module_settings->getModule($this->module_name);

        $filters = $request->query->all();

        array_walk_recursive($filters, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });

        $filters = $this->helper->removeEmptyConditions($filters);

        $params = $this->prepareFilterCondtion($filters);

        //Set sort filter
        $sort = $this->prepareSort($filters);
        //Fetch the data
        $page_no = 1;
        //$limit_plus_offset = $this->prepareLimit($page_no);

        $rows = $module->getRows($params, $sort, null);

        /*
          $count = $module->totalCountOfLastFetch();
          $total_page_count = ceil($count / $this->limit);
          $pagination = array('active' => $page_no, 'limit' => $this->limit, 'total_record' => $count, 'total_count' => $total_page_count);
          $paging = $this->getPagination($page_no, $this->limit, $count);
          $all_users = $this->getUsers();

          $parameters = array('rows' => $rows['row'],
          'schema' => $rows['schema'],
          'selected_filters' => $filters,
          'pagination' => $pagination,
          'paging' => $paging,
          'users' => $all_users,
          'module_display_name' => $module_display_name,
          'module' => $this->module_route_identifier,
          'module_permission_asscess_key' => $this->moduleSessionKey(),
          'module_name' => $this->module_name,
          'permissions' => $this->permissions
          );
         * 
         */

        //var_dump($rows['schema']);
//        var_dump($rows['row']);
//        exit;
        $app_path = $this->get('kernel')->getRootDir();
        $filename = $this->module_name . date("-Ymd-his") . '.csv';
        $filepath = "$app_path/../web/export/$filename";
        $file = new \SplFileObject($filepath, 'w');
        $header_fields = $this->helper->prepareKeyValuePair('module_field_name', 'module_field_display_name', array_values($rows['schema']));
        $header_fields = array_merge(array('Id'), $header_fields);
        $file->fputcsv($header_fields);
        foreach ($rows['row'] as $row) {
            //var_dump($row);
            $temp = array();
            $temp[] = $row['id'];
            foreach ($rows['schema'] as $field_name => $field_details) {
                if (array_key_exists($field_name, $row)) {

                    $row[$field_name] = $this->formatField($row[$field_name], $field_details);
                    $temp[] = $row[$field_name];
                }
            }
            $file->fputcsv($temp);
        }
        $file = null;


        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo file_get_contents($filepath);
        exit;
    }

    function formatField($value, $field_details) {

        //if($field_details['module_field_datatype'])
        $return = $value;
        switch ($field_details['module_field_datatype']) {
            case 'user':
                if ($value) {
                    $users = $this->getUsers();
                    $return = $users[$value];
                }
                break;
            case 'relationship':
                $return = $this->formatField($return, $field_details['core_field_settings']);

            default:
                break;
        }
        return $return;
    }

    /*
     * Delete action
     * Param1: number $delete_id
     */

    public function deleteAction($delete_id) {

        $this->initPermissionsDetails();
        //$this->initRowAccessPermission();

        if ($this->noAccess('view')) {
            return $this->noAccessPage();
        }


        $module = $this->get("intelligent.{$this->module_name}.module");
        $request = Request::createFromGlobals();


        $module->delete($delete_id);

        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");

        return $this->redirectToRoute("intelligent_" . str_replace('_', '', $this->module_name) . "_view");
    }

    function getUsers() {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder();
        $query->select("u")
                ->from("IntelligentUserBundle:User", "u");
        //$query->andWhere($query->expr()->in("u.status", 1));

        $dql = $query->getQuery();
        $results = $dql->getResult();

        //$this->helper->print_r($results);
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
                    if (!empty($value)) {
                        $params[$key]['like'] = "%{$value}%";
                    }
                }
            }
            if (!empty($filters['filter']['match'])) {
                foreach ($filters['filter']['match'] as $field => $value) {
                    $params[$field] = $value;
                }
            }
            if (!empty($filters['filter']['range']) and ! empty($filters['filter']['range'])) {
                foreach ($filters['filter']['range'] as $field => $value) {
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

            $this->permissionHack($permission);

            $permission['setting_permissions'] = $user_permission->getEditAppStructurePermission();

            $session->set($this->moduleSessionKey(), $permission);
            $this->permissions = $permission;
        } else {
            $permission = $cache_permission;
            $this->permissions = $permission;
        }

        return $permission;
    }

    function permissionHack(&$permission) {

        if ($permission['custom']) {

            $only_values = array_unique(array_values($permission['custom_field']));

            if (count($only_values) == 1) {
                //Only one kind of access is there

                $permission['custom'] = false;
                switch ($only_values[0]) {
                    case 0://NO access
                        $permission['view'] = false;
                        $permission['edit'] = false;
                        break;
                    case 1://only view access
                        $permission['view'] = true;
                        $permission['edit'] = false;
                        break;
                    case 2://view & edit
                        $permission['view'] = true;
                        $permission['edit'] = true;
                        break;
                }
            } elseif (count($only_values) == 2) {

                if (array_search(1, $only_values) === false) {
                    //some field have edit access, so view/edit both should be true
                    $permission['view'] = true;
                    $permission['edit'] = true;
                }
                if (array_search(2, $only_values) === false) {
                    //no edit access only vew
                    $permission['view'] = true;
                    $permission['edit'] = false;
                }
                if (array_search(0, $only_values) === false) {
                    //some fields have view and edit access
                    $permission['edit'] = true;
                    $permission['view'] = true;
                }
            } else {//some fields have view and edit access
                $permission['edit'] = true;
                $permission['view'] = true;
            }
        }
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

    public function indexAction() {

        $classnamelike = ucfirst($this->module_route_identifier);
        return $this->forward("IntelligentModuleBundle:$classnamelike:view", array('page_no' => 1));
    }

    /*
     * NOt in use
     */

    function initRowAccessPermission() {

        $user_permission = $this->get("user_permissions");
        $active_customer_filter = $user_permission->getCurrentViewCustomer()->getId();

        $session = new Session();

        $session->set('active_customer_filter', $active_customer_filter);
    }

    /*
     * Method to override 
     * param1: @mixed
     */

    protected function _afterSaveEvent($param) {
        //empty
    }

    /*
     * Get all field names for mudle
     * 
     */

    public function fieldsetAction() {

        $module = $this->get("intelligent.{$this->module_name}.module");


        $module_display_name = $module->module_settings->getModule($this->module_name);

        $fields = $module->getFormFields();
        $key_pair = array();
        foreach ($fields as $key => $value) {

            if ($value['module_field_datatype'] == 'relationship') {
                //field name of relationship table
                $k = $value['core_field_settings']['module'] . '.' . $value['core_field_settings']['module_field_name'];
                $key_pair[$k] = $value['module_field_display_name'];
            } elseif (!$module->module_settings->isNonDbField($value['module_field_datatype'])) {
                //other than formulative
                $k = $value['module'] . '.' . $value['module_field_name'];
                $key_pair[$k] = $value['module_field_display_name'];
            }
        }
        return new JsonResponse($key_pair);
    }

    public function getPagination($currentPage, $maxPage, $totalRecords) {
        $totalPage = ceil($totalRecords / $maxPage);
        $pagination = array();
        // First link
        if ($currentPage == 1) {
            $pagination['firstPage'] = array(
                'disabled' => true
            );
        } else {
            $pagination['firstPage'] = array(
                'disabled' => false,
                'number' => 1
            );
        }
        // Last link
        if ($currentPage == $totalPage) {
            $pagination['lastPage'] = array(
                'disabled' => true
            );
        } else {
            $pagination['lastPage'] = array(
                'disabled' => false,
                'number' => $totalPage
            );
        }

        // Link in between
        // We will have 19 links in between
        $pagesInBetween = array();
        if ($totalPage <= self::TOTAL_PAGINATION_VISIBLE_PAGES) {
            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $currentPage) {
                    $pagesInBetween[] = array(
                        'current' => true,
                        'number' => $i,
                        'disabled' => true
                    );
                } else {
                    $pagesInBetween[] = array(
                        'current' => false,
                        'number' => $i,
                        'disabled' => false
                    );
                }
            }
        } else {
            $belowHalfMark = ceil(self::TOTAL_PAGINATION_VISIBLE_PAGES / 2);
            $aboveHalfMark = floor(self::TOTAL_PAGINATION_VISIBLE_PAGES / 2);
            // Pages will start from 1
            if ($currentPage - $belowHalfMark <= 0) {
                $startPage = 1;
                for ($i = $startPage; $i <= self::TOTAL_PAGINATION_VISIBLE_PAGES; $i++) {
                    if ($i == $currentPage) {
                        $pagesInBetween[] = array(
                            'current' => true,
                            'number' => $i,
                            'disabled' => false
                        );
                    } else {
                        $pagesInBetween[] = array(
                            'current' => false,
                            'number' => $i,
                            'disabled' => false
                        );
                    }
                }
                $pagesInBetween[] = array(
                    'current' => false,
                    'number' => '.',
                    'disabled' => true
                );
            }
            // Last pages will come in continuity
            else if (($currentPage + $aboveHalfMark) >= $totalPage) {
                $pagesInBetween[] = array(
                    'current' => false,
                    'number' => '.',
                    'disabled' => true
                );
                $startPage = $totalPage - self::TOTAL_PAGINATION_VISIBLE_PAGES + 1;
                for ($i = $startPage; $i <= $totalPage; $i++) {
                    if ($i == $currentPage) {
                        $pagesInBetween[] = array(
                            'current' => true,
                            'number' => $i,
                            'disabled' => false
                        );
                    } else {
                        $pagesInBetween[] = array(
                            'current' => false,
                            'number' => $i,
                            'disabled' => false
                        );
                    }
                }
            }
            // Pages will start in middle and end in middle
            else {
                $pagesInBetween[] = array(
                    'current' => false,
                    'number' => '.',
                    'disabled' => true
                );
                $startPage = $currentPage - $belowHalfMark + 1;
                for ($i = $startPage; $i <= $currentPage + $aboveHalfMark; $i++) {
                    if ($i == $currentPage) {
                        $pagesInBetween[] = array(
                            'current' => true,
                            'number' => $i,
                            'disabled' => false
                        );
                    } else {
                        $pagesInBetween[] = array(
                            'current' => false,
                            'number' => $i,
                            'disabled' => false
                        );
                    }
                }
                $pagesInBetween[] = array(
                    'current' => false,
                    'number' => '.',
                    'disabled' => true
                );
            }
        }
        $pagination['inbetween'] = $pagesInBetween;
        return $pagination;
    }

    public function importAction() {

        $this->initPermissionsDetails();
        //$this->initRowAccessPermission();

        if ($this->noAccess('add')) {
            return $this->noAccessPage();
        }

        $request = Request::createFromGlobals();
        //$f_request = new UploadedFile();

        try {
            if ($request->isMethod('POST')) {//Result submited
                //var_dump($_FILES);
                if ($_FILES['import_file']['error'] == 0) {

                    $app_path = $this->get('kernel')->getRootDir();
                    $filename = $this->module_name . date("-Ymd-his") . '.csv';
                    $filepath = "$app_path/../web/import/frontend/$filename";
                    $test_header = $request->get('test_header');
                    //echo 'i m in';
                    //var_dump(file_exists($_FILES['import_file']['tmp_name']));
                    move_uploaded_file($_FILES['import_file']['tmp_name'], $filepath);

                    if (file_exists($filepath)) {
                        $relativepath = "frontend/$filename";

                        $import = $this->get('intelligent.import.module');

                        $import->init($this->module_name);

                        $import->setTestOnlyHeader(!empty($test_header));

                        $import->csvUpload($relativepath);
                        
                        if (empty($test_header)) {
                            $this->get('session')->getFlashBag()->add('success', 'Product Uploaded process completed ');
                        }
                    } else {
                        //throw exception
                        throw new \Exception("Some problem is file upload", '001');
                    }
                } else {
                    //exception for error
                    throw new \Exception("Upload Error", '001');
                }
            }
        } catch (\Exception $e) {

            $this->get('session')->getFlashBag()->add('error', 'Line ' . $e->getLine() . ':' . $e->getMessage());
        }


        $parameters = array(
            'module' => $this->module_route_identifier,
            'module_permission_asscess_key' => $this->moduleSessionKey(),
            'module_name' => $this->module_name,
            'permissions' => $this->permissions
        );
        return $this->render('IntelligentModuleBundle:Default:import.html.twig', $parameters);
    }

}
