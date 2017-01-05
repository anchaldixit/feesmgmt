<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;


class LinkratesController extends ModulebaseController {
    
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'link_rates';
    }


    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));

    }

}
