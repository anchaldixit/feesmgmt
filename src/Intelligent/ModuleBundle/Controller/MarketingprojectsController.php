<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;


class MarketingprojectsController extends ModulebaseController {
    
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'marketing_projects';
    }


    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));

    }

}
