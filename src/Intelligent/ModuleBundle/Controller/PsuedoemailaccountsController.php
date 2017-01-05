<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;


class PsuedoemailaccountsController extends ModulebaseController {
    
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'psuedo_email_accounts';
    }


    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));

    }

}
