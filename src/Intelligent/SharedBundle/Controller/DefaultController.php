<?php

namespace Intelligent\SharedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IntelligentSharedBundle:Default:index.html.twig');
    }
}
