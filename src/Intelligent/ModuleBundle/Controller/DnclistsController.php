<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;


class DnclistsController extends ModulebaseController {
    
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'dnc_lists';
    }


    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));

    }

}
