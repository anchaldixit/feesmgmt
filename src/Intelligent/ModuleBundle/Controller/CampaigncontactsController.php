<?php

namespace Intelligent\ModuleBundle\Controller;

use Intelligent\ModuleBundle\Controller\ModulebaseController;


class CampaigncontactsController extends ModulebaseController {
    
    
    public function __construct() {
        
        $this->setModuleName();
        
        parent::__construct();
    }
    
    function setModuleName(){
        
        $this->module_name = 'campaign_contacts';
    }


    public function autocompleteAction(){
        
        return new JsonResponse(array('name' => 'shashank'));

    }

}
