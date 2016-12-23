<?php

namespace Intelligent\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('IntelligentUserBundle:Default:index.html.twig');
    }

    public function loginAction(Request $request) {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session &&
                $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = "Email and password do not match";
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' :
                $session->get(SecurityContextInterface::LAST_USERNAME);
        
        return $this->render('IntelligentUserBundle:Default:login.html.twig', array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }
    public function registerAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:userregistration.html.twig', array());
    }
    public function inviteUserAction($emailVerifyId){
        /**
         * @TODO create this page
         */
        return $this->render('IntelligentUserBundle:Default:inviteUser.html.twig', array(
            'emailVerifyId' => $emailVerifyId
        ));
    }
    
    public function resetPasswordAction($resetPasswordId){
        return $this->render('IntelligentUserBundle:Default:reset.html.twig', array(
            'resetPasswordId' => $resetPasswordId
        ));
    }
    public function changePasswordAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:changepassword.html.twig', array());
    }
    
    public function usersAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:users.html.twig', array());
    }
    
    public function rolesAction(Request $request){
        return $this->render('IntelligentUserBundle:Default:roles.html.twig', array());
    }
    
    public function mypreferencesAction(Request $request){
        
        return $this->render('IntelligentUserBundle:Default:mypreferences.html.twig', array());
    }
    public function noaccessAction(Request $request){
        
        return $this->render('IntelligentUserBundle:Default:noaccess.html.twig', array());
    }

}
