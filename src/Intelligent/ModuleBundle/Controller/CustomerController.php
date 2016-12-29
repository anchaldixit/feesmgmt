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

    public function indexAction() {
        return $this->render('IntelligentModuleBundle:Customer:index.html.twig');
    }

    public function autocompleteAction() {

        return new JsonResponse(array(array('id' => 1, 'label' => 'first Label', 'value' => 'fist_label')));
    }

}
