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
                        return $this->redirectToRoute('intelligent_setting_edit', array('edit_id' => 'new'));
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



}
