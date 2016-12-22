<?php

namespace Intelligent\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IntelligentModuleBundle:Default:index.html.twig');
    }
}
