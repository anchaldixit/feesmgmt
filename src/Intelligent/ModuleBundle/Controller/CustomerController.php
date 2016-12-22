<?php

namespace Intelligent\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Intelligent\ModuleBundle\Lib\Customer;
use Symfony\Component\HttpFoundation\Request;


class CustomerController extends Controller
{
    public function indexAction()
    {
        return $this->render('IntelligentModuleBundle:Customer:index.html.twig');
    }
    
    public function editAction($edit_id){
        
        //Need all the columns that need to be shown
        
        //Need columns that need to be hide in edit
        
        
        $conn = $this->get('database_connection');
        #echo get_class($conn);
        $customer = new Customer($conn);
        
        //var_dump($customer->module_settings);
        
        echo $module_display_name = $customer->module_settings->getModule('customer');
        
        $request = Request::createFromGlobals();
        $id = null;
        
        try {
            if ($request->isMethod('POST')) {//Result submited
                $post = $request->request->all();
                $result = array();
                $result[] = $post;
                if (empty($request->request->get('id'))) {
                    //save

                    $id = $customer->save($post);
                    $this->get('session')->getFlashBag()->add('success', "Row added successfully.");
                    return $this->redirectToRoute('intelligent_customer_edit', array('edit_id' => $id));
                } else {

                    if (!empty($request->request->get('delete_submit'))) {
                        //delete
                        $customer->delete($request->request->get('id'));
                        //@todo: redirect should be done 
                        $this->get('session')->getFlashBag()->add('success', "Row Deleted Successfully.");
                        return $this->redirectToRoute('intelligent_customer_view');
                    } else {//update
                        $id = $edit_id;
                        $customer->update($post);
                        $this->get('session')->getFlashBag()->add('success', "Row Updated successfully.");
                        return $this->redirectToRoute('intelligent_customer_edit', array('edit_id' => $edit_id));
                    }
                }
                $id = is_numeric($edit_id) ? $edit_id : null;
            } else {
                
                echo $edit_id,'edd';
                

                if (is_numeric($edit_id)) {
                    
                    $result = $customer->getRow( $edit_id);
                    var_dump(is_numeric($edit_id));
                    echo 'on';
                    var_dump($result);exit;
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
        //var_dump($result);exit;
        $parameters = array('row' => '$result',
            'schema' => '$schema',
            'id' => $id);
        
        // getRow($edit_id)
        
        return $this->render('IntelligentModuleBundle:Customer:edit.html.twig',$parameters);
        
        //$module_name = $settings->getModule('');
        
    }
}
