<?php

namespace Intelligent\SettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intelligent\SettingBundle\Lib\Settings;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('IntelligentSettingBundle:Default:index.html.twig');
    }

    public function editAction($edit_id) {

        $conn = $this->get('database_connection');
        #echo get_class($conn);
        $settings = new Settings($conn);
        $modules = $settings->getModule();
        $datatypes = $settings->getModuleDataTypes();
        //$columns = $settings->fetch(array('module'=>'marketing_projects'));


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
                    return $this->redirectToRoute('intelligent_setting_edit', array('edit_id' => $id));
                } else {

                    if (!empty($request->request->get('delete_submit'))) {
                        //delete
                        $settings->delete($request->request->get('id'));
                        //@todo: redirect should be done 
                        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
                        return $this->redirectToRoute('intelligent_setting_view');
                    } else {//update
                        $id = $edit_id;
                        $settings->update($post);
                        $this->get('session')->getFlashBag()->add('success', "Row Updated successfully.");
                        return $this->redirectToRoute('intelligent_setting_edit', array('edit_id' => $edit_id));
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


        $parameters = array('field' => $result,
            'modules' => $modules,
            'datatypes' => $datatypes,
            'id' => $id);

//        if (!empty($message)) {
//            $parameters['msg'] = $message;
//        }

        return $this->render('IntelligentSettingBundle:Default:edit.html.twig', $parameters);
    }

    public function viewAction($page_no) {

        $conn = $this->get('database_connection');

        $request = Request::createFromGlobals();
        $settings = new Settings($conn);

        $filters = $request->query->all();
        array_walk_recursive($filters, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });
        //var_dump($filters);
        $params = array();
        $sort = array('module' => 'ASC');
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
        if($page_no>0){
            $limit = 10;
            $offset = ($page_no-1)*$limit;
            $limit_plus_offset="$offset,$limit";
        }
        $row = $settings->fetch($params, $sort, $limit_plus_offset);
        
        $count = $settings->totalCountOfLastFetch();
        $total_page_count = ceil($count / $limit );
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

    public function deleteAction($delete_id) {

        $conn = $this->get('database_connection');

        $settings = new Settings($conn);

        $settings->delete($delete_id);
        
        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
        return $this->redirectToRoute('intelligent_setting_view');
    }

}
