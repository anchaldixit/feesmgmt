<?php

namespace Intelligent\UserBundle\Services;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Intelligent\UserBundle\Controller\ApiController;


/**
 * Description of ControllerListener
 *
 * @author tejaswi
 */
class ControllerListener {
    public function __construct($resolver) {
        $this->resolver = $resolver;
    }
    public function onKernelController(FilterControllerEvent $event){
        $request = $event->getRequest();
        $request_url = $request->getRequestUri();
        $controller = $event->getController();
        
        if(!preg_match("/chooseCustomer/", $request_url)){
            if(($controller[0] instanceof Controller) && !($controller[0] instanceof ApiController)){
                $user = $controller[0]->getUser();
                if(is_null($user->getCurrentCustomer()) || !$user->getCurrentCustomer()->getIsActive()){
                    if(count($user->getAllowedCustomers(true)) > 0){
                        $request->attributes->set('_controller', 'IntelligentUserBundle:Default:choosecustomer');
                    }else{
                        $request->attributes->set('_controller', 'IntelligentUserBundle:Default:noaccess');
                    }
                    $event->setController($this->resolver->getController($request));
                }
            }
        }
    }
}
