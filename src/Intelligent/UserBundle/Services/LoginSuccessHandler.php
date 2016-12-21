<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\UserBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
/**
 * Description of LoginSuccessHandler
 *
 * @author tejaswi
 */
class LoginSuccessHandler extends DefaultAuthenticationSuccessHandler{
    public function __construct(HttpUtils $httpUtils, EntityManager $entityManager)
    {
        parent::__construct($httpUtils, array());
        $this->entityManager = $entityManager;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token){
        $user = $token->getUser();
        // Update login time at successful login 
        $user->setLastLogin(new \DateTime());
        $this->entityManager->flush();
        return parent::onAuthenticationSuccess( $request, $token );
    }
            
}
