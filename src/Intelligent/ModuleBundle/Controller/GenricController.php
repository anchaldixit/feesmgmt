<?php

namespace Intelligent\ModuleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Intelligent\ModuleBundle\Controller\ModulebaseController;

class GenricController extends ModulebaseController {
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        //$this->module_name = 'degrees';
        $this->module_type = 'genric';
    }

    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));
    }
    public function viewAction(Request $request, $page_no) {

        #$request = Request::createFromGlobals();
        $m = $request->attributes->get('module');
        $this->module_name = $m;

        return parent::viewAction($request, $page_no);
    }
    public function editAction(Request $request, $edit_id) {

         #$request = Request::createFromGlobals();
         $m = $request->attributes->get('module');
         $this->module_name = $m;
         return parent::editAction($request, $edit_id);
     }
     public function deleteAction(Request $request, $delete_id) {

         #$request = Request::createFromGlobals();
         $m = $request->attributes->get('module');
         $this->module_name = $m;
         return parent::deleteAction($request, $delete_id);
     }
     public function fieldsetAction(Request $request) {

         #$request = Request::createFromGlobals();
         $m = $request->attributes->get('module');
         $this->module_name = $m;
         return parent::fieldsetAction($request);
     }

}
