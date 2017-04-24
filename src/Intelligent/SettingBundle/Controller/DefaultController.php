<?php

namespace Intelligent\SettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intelligent\SettingBundle\Lib\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {
    /*
     * Not in use
     */

    const TOTAL_PAGINATION_VISIBLE_PAGES = 11; // Always an odd number

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
        $is_ajax = $request->query->get('ajax');
        $id = null;

        try {
            if ($request->isMethod('POST')) {//Result submited
                //Not get, this time its post request
                $is_ajax = $request->request->get('ajax');

                $post = $request->request->all();
                $result = array();
                $result[] = $post;

                if (empty($request->request->get('id'))) {
                    //save

                    $id = $settings->save($post);
                    $this->get('session')->getFlashBag()->add('success', "Row added successfully.");
                    if ($is_ajax) {
                        $updated_row_html = $this->viewRowHtml($id);
                        return new JsonResponse(array('msg' => 'Row added successfully.', 'action' => 'add', 'id' => $id, 'row' => $updated_row_html));
                    } else {
                        return $this->redirectToRoute('intelligent_setting_edit', array_merge($request->query->all(), array('edit_id' => $id)));
                    }
                } else {

                    if (!empty($request->request->get('delete_submit'))) {
                        //delete
                        //$settings->delete($request->request->get('id'));
                        //@todo: redirect should be done 
                        if ($is_ajax) {

                            return new JsonResponse(array('msg' => 'Row Deleted Successfully.', 'action' => 'delete'));
                        } else {
                            $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
                            return $this->redirectToRoute('intelligent_setting_view', $request->query->all());
                        }
                    } else {//update
                        $id = $edit_id;
                        $settings->update($post);

                        if ($is_ajax) {
                            $updated_row_html = $this->viewRowHtml($edit_id);
                            return new JsonResponse(array('msg' => 'Row Updated successfully.', 'action' => 'update', 'row' => $updated_row_html));
                        } else {
                            $this->get('session')->getFlashBag()->add('success', "Row Updated successfully.");
                            return $this->redirectToRoute('intelligent_setting_edit', array_merge($request->query->all(), array('edit_id' => $id)));
                        }
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
            if ($is_ajax) {
                return new JsonResponse(array('error' => 'set', 'error_msgs' => $e->getMessage()));
            } else {
                $this->get('session')->getFlashBag()->add('error', $e->getMessage() . '<br>' . $e->getTraceAsString());
            }
            //var_dump($e);
        }

        //$groupId = $result[0]['field_group_id'];
        //$groupOrder = $settings->getGroupOrderById(array('id'=>$groupId));

        $parameters = array('field' => $result,
            'modules' => $modules,
            'datatypes' => $datatypes,
            'allgroups' => $allgroups,
            'id' => $id,
            'is_ajax' => $is_ajax);

        if ($is_ajax == 'yes') {
            return $this->render('IntelligentSettingBundle:Default:edit-form.html.twig', $parameters);
        } else {
            return $this->render('IntelligentSettingBundle:Default:edit.html.twig', $parameters);
        }
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
            $limit = 200;
            $offset = ($page_no - 1) * $limit;
            $limit_plus_offset = "$offset,$limit";
        }
        $row = $settings->fetch($params, $sort, $limit_plus_offset);

        $count = $settings->totalCountOfLastFetch();
        $total_page_count = ceil($count / $limit);
        $pagination = array('active' => $page_no, 'limit' => $limit, 'total_record' => $count, 'total_count' => $total_page_count);
        $paging = $this->getPagination($page_no, $limit, $count);

        $modules = $settings->getModule();
        $datatypes = $settings->getModuleDataTypes();

        //var_dump($filters);

        $parameters = array('rows' => $row,
            'modules' => $modules,
            'datatypes' => $datatypes,
            'selected_filters' => $filters,
            'pagination' => $pagination,
            'paging' => $paging
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
     * Get view row for axaj response
     */

    function viewRowHtml($id) {


        $settings = $this->get('intelligent.setting.module');

        $row = $settings->fetch(array('id' => $id));
        $datatypes = $settings->getModuleDataTypes();
        $modules = $settings->getModule();

        $parameters = array('rows' => $row,
            'modules' => $modules,
            'datatypes' => $datatypes,
        );
        return $this->renderView('IntelligentSettingBundle:Default:view-row.html.twig', $parameters);
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

    public function importAction() {

        //
        ini_set('memory_limit', '25600M');
        ini_set('max_execution_time', 0);


        $parameters = array();
        $request = Request::createFromGlobals();
        $path = $request->get('path');
        $m = $request->get('module');
        $c = $request->get('config');
        echo $customer = $request->get('customer');
        $f = trim($request->get('foreign_key'));

        $user_permission = $this->get("user_permissions");
        echo $active_customer_filter = $user_permission->getCurrentViewCustomer()->getId();

        if ($active_customer_filter != $customer) {
            echo 'customer dont match';
        } else {

            //var_dump($c);
            if (!empty($customer) and ! empty($m) and ! empty($path)) {
                $import = $this->get('intelligent.import.module');
                if ($c) {

                    $import->setTestOnlyHeader(isset($c['test_header']));
                    $import->setDeleteBeforeInsert(isset($c['delete_existing_before_insert']));
                }
                if (!empty($f) and strpos($f, '|') !== false) {
                    $f2 = explode('|', $f);
                    $import->setForeignKey(array($f2[0] => $f2[1]));
                }
                $import->init($m);

                $import->csvUpload($path);
            } else {
                //throw new \Exception('Missing parameters');
            }
        }




        return $this->render('IntelligentSettingBundle:Default:import.html.twig', $parameters);
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

}
