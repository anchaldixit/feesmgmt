<?php

namespace Intelligent\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Intelligent\UserBundle\Entity\User;

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
        $email = $status = $role = '';
        /**
         * @TODO create this page
         */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("IntelligentUserBundle:User")->findOneBy(array("verificationId" => $emailVerifyId));
        if($user){
            $status = $user->getStatus();
            if($user->getStatus() == User::UNVERIFIED){
                $user->setStatus(User::UNREGISTERED);
                $em->flush();
            }
            $email = $user->getEmail();
            $role  = $user->getRole()->getName();
        }else{
            $status = false;
        }
        return $this->render('IntelligentUserBundle:Default:userregistration.html.twig', $param = array(
            'emailVerifyId' => $emailVerifyId,
            'status' => $status,
            "email"  => $email,
            "role"   => $role
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
