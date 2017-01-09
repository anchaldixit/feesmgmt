<?php

namespace Intelligent\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function reportLandingAction()
    {
        # Get the reports visible to the user
        $reports = $this->get('user_customers')->getVisibleReports();
        return $this->render('IntelligentReportBundle:Default:reportlanding.html.twig', array("reports" => $reports));
    }
    
    public function reportAction()
    {
        return $this->render('IntelligentReportBundle:Default:index.html.twig');
    }
}
