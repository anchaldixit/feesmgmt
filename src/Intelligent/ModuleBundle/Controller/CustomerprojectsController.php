<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;

class CustomerprojectsController extends ModulebaseController {
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'customer_projects';
    }

    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));
    }

}
