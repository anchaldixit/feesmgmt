<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;

class CustomerController extends ModulebaseController {

    public function __construct() {

        $this->setModuleName();

        parent::__construct();
    }

    function setModuleName() {

        $this->module_name = 'customer';
    }

    public function autocompleteAction() {

        return new JsonResponse(array(array('id' => 1, 'label' => 'first Label', 'value' => 'fist_label')));
    }
    
    /*
     * Override of parent  function
     */
    public function _afterSaveEvent($param) {
        
        if(!empty($param)){
            //customer module is root module. this means new customer is created, add customer access to login user. Also also switch the current active customer.
            $this->get('user_customers')->assignCustomerAndMakeDefault($param);
            $this->get('session')->getFlashBag()->add('success', "App scope is switched to newly created customer.");
        }
               
        
    }



}
