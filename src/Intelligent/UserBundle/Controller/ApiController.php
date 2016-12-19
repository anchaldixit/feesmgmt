<?php

namespace Intelligent\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Intelligent\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Util\StringUtils;

class ApiController extends Controller {

    /**
     * This is a api end for all the api requests. This will 
     * parse the json request and call the appropriate method
     * to cater the request
     * 
     * @param Request $request
     * @return type
     * @throws \Exception
     */
    public function v1EndPointAction(Request $request) {
        # Get the request json
        # See if the json is parseable
        # If the json is not parseable then throw excpetion
        # If json is parseable then get the head.action variable
        # If this do not exists then throw Exception
        # If head.action exists then find a function in the controller to server it.
        # if the function no not exists the throw exception
        # if the function exists then call that function and get the result.
        # if the function throws exception then deliver error response
        # If the function dont throw exception then deliver success responce.
        
        try {
            if ($request->isMethod('POST')) {
                $request_json = $request->getContent();
                $parsed_request_json = json_decode($request_json);
                if (is_null($parsed_request_json)) {
                    throw new \Exception("Request json is parseable", 400);
                } else {
                    if (isset($parsed_request_json->head) && isset($parsed_request_json->body)) {
                        if (isset($parsed_request_json->head->action) && !empty($parsed_request_json->head->action)) {
                            $request_action = $parsed_request_json->head->action;
                            if($this->_isAllowed($request_action)){
                                if (method_exists($this, $request_action)) {
                                    return $this->{$request_action}($request, $parsed_request_json);
                                } else {
                                    throw new \Exception("Method '$request_action' do not exists in the api", 405);
                                }
                            }else{
                                throw new \Exception("User not allowed to access api without login", 401);
                            }
                        } else {
                            throw new \Exception("head.action is not available in the request json", 400);
                        }
                    } else {
                        throw new \Exception("head or body keys are not available in the request json", 400);
                    }
                }
            } else {
                throw new \Exception("Any method other than POST is not allowed", 400);
            }
        } catch (\Exception $e) {
            return $this->_handleException($e);
        }
    }
    
    /**
     * This function will reset the password for a user and send 
     * a mail to him with reset email
     * 
     * @param Request $request
     * @param type $json
     * @return Response 
     * @throws \Exception
     */
    private function forgetPassword(Request $request, $json) {
        if (isset($json->body->email) && !empty($json->body->email)) {
            $email = $json->body->email;
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("IntelligentUserBundle:User");
            $single_user = $user->findOneBy(array("email" => $email));
            if (!$single_user) {
                throw new \Exception("User with email '$email' not found", 404);
            } else {
                # Only registered users can reset their passwords
                if (!in_array($single_user->getStatus(), array(User::REGISTERED, User::PASSWORD_RESET))) {
                    throw new \Exception("User not allowed to reset password", 403);
                }

                # Reset user password
                try {
                    $reset_id = uniqid();
                    $single_user->setPasswordResetId($reset_id)
                            ->setUpdateDatetime(new \DateTime())
                            ->setStatus(User::PASSWORD_RESET);

                    $em->persist($single_user);
                    $em->flush();
                } catch (\Exception $e) {
                    throw new \Exception("Unable to reset password", 500);
                }
                # 
                try {
                    # Send email
                    $body = $this->_getEmailBody("resetPassword.html.twig", array('resetPasswordId' => $reset_id));
                    $this->_sendEmail($single_user->getEmail(), "Your password is reset", $body);
                } catch (\Exception $ex) {
                    throw new \Exception("Unable to send reset password email", 500);
                }

                return $this->_handleSuccessfulRequest();
            }
        } else {
            throw new \Exception("email variable do not exists in the request json", 400);
        }
    }

    /**
     * This function will change the current user password.
     * This will first check the current password and if it matches
     * it will change the password
     * 
     * @param Request $request
     * @param type $json
     * @return Response
     * @throws \Exception
     */
    private function changePassword(Request $request, $json) {
        $user = $this->getUser();
        if(isset($json->body->old_password) && isset($json->body->new_password)){
            # Now compare passwords
            if(StringUtils::equals($user->getPassword(), $json->body->old_password)){
                $em = $this->getDoctrine()->getManager();
                $user->setPassword(trim($json->body->new_password))
                        ->setUpdateDatetime(new \DateTime());
                
                $em->persist($user);
                $em->flush();
                return $this->_handleSuccessfulRequest();
            }else{
                throw new \Exception("Old password do not match with the current user" , 403);
            }
        }else{
            throw new \Exception("old_password or new_password variable do not exists in the request body",400);
        }
    }
    
    /**
     * This function will reset the password of a user from the link
     * sent in the email
     * 
     * @param Request $request
     * @param type $json
     * @return Response
     * @throws \Exception
     */
    private function resetPassword(Request $request, $json) {
        if(isset($json->body->reset_password_id) && isset($json->body->new_password)){
            $em = $this->getDoctrine()->getManager();
            $em->getRepository("IntelligentUserBundle:User");
            $user = $em->findOneBy(array('passwordResetId' => $json->body->reset_password_id));
            if($user){
                // Change password
                $user->setPassword($json->body->new_password)
                // Clear reset password id
                        ->setPasswordResetId(null)
                        ->setUpdateDatetime(new \DateTime());
                
                $em->persist($user);
                $em->flush();
                return $this->_handleSuccessfulRequest();
            }else{
                throw new \Exception("reset_password_id do not exists or has already used" , 403);
            }
            
        }else{
            throw new \Exception("reset_password_id or new_password variable do not exists in the request body",400);
        }
    }
    
    /**
     * This function will change first and last name of the user.
     * We will all more variables to it in the future 
     * 
     * @param Request $request
     * @param type $json
     * @return Response
     * @throws \Exception
     */
    private function changePreference(Request $request, $json){
        $user = $this->getUser();
        if(isset($json->body->first_name) && isset($json->body->last_name)){
            $em = $this->getDoctrine()->getManager();
            $user->setFirstName($json->body->first_name)
                    ->setLastName($json->body->last_name)
                    ->setUpdateDatetime(new \DateTime());
            
            $em->persist($user);
            $em->flush();
            return $this->_handleSuccessfulRequest();
        }else{
            throw new \Exception("First name or last name is not set in the request json",400);
        }
    }

    private function getUsers(Request $request, $json){
        $user = $this->getUser();
    }
    
    private function disableUser(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions){
            if(isset($json->body->user_id)){
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository("IntelligentUserBundle:User")->find($json->body->user_id);
                if($user){
                    $user->setStatus(4)->setUpdateDatetime(new \DateTime());
                    $em->flush();
                    return $this->_handleSuccessfulRequest();
                }else{
                    throw new \Exception("User with this user_id not found",404);
                }
            }else{
                throw new \Exception("user_id is not set in the request json",400);
            }
        }else{
            throw new \Exception("Current user has no access to change user role", 403);
        }
    }
    
    private function changeRole(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions){
            if(isset($json->body->user_id) && isset($json->body->new_role_id)){
                $em = $this->getDoctrine()->getManager();
                // Get user
                $user = $em->getRepository("IntelligentUserBundle:User")->find($json->body->user_id);
                if($user){
                    // Now get role 
                    $role = $em->getRepository("IntelligentUserBundle:Role")->find($json->body->new_role_id);
                    if($role){
                        $user->setRole($role)->setUpdateDatetime(new \DateTime());
                        $em->flush();
                        return $this->_handleSuccessfulRequest();
                    }else{
                        throw new \Exception("Role with this new_role_id not found",404);
                    }
                }else{
                    throw new \Exception("User with this user_id not found",404);
                }
            }else{
                throw new \Exception("user_id or new_role_id is not set in the request json",400);
            }
        }else{
            throw new \Exception("Current user has no access to change user role", 403);
        }
    }
    
    /**
     * This function will convert the exception into a response object 
     * 
     * @param \Exception $exception
     * @param type $responseCode
     * @return Response
     */
    private function _handleException(\Exception $exception) {
        $response = new Response(json_encode(array(
                    'head' => array(
                        'status' => 'error'
                    ),
                    'body' => array(
                        'error_msg' => $exception->getMessage()
                    )
        )));
        $http_code = $exception->getCode()? $exception->getCode() :500;
        $response->setStatusCode($http_code);
        $response->headers->set("Content-Type", "application/json");
        return $response;
    }

    /**
     * This function will return response object for success requests
     * 
     * @param type $responseData
     * @return Response
     */
    private function _handleSuccessfulRequest($responseData = null) {
        if(is_null($responseData)){
            $final_response = array(
                'head' => array(
                    'status' => 'success'
                )
            );
        }else{
            $final_response = array(
                'head' => array(
                    'status' => 'success'
                ),
                'body' => $responseData
            );
        }
        $response = new Response(json_encode($final_response));
        $response->setStatusCode(200);
        $response->headers->set("Content-Type", "application/json");
        return $response;
    }

    /**
     * This function will create html from a twig email template
     * and required data
     * 
     * @param type $emailTemplate
     * @param type $data
     * @return string
     */
    private function _getEmailBody($emailTemplate, $data) {
        $email_template = $this->get('kernel')
                ->locateResource("@IntelligentUserBundle/Resources/views/Emails/$emailTemplate");

        return $this->get('templating')
                        ->render($email_template, $data);
    }

    /**
     * This function will send emails
     * 
     * @param type $reciepient
     * @param type $subject
     * @param type $body
     * @param type $from
     */
    private function _sendEmail($reciepient, $subject, $body, $from = "admin@aizan.com") {
        $message = \Swift_Message::newInstance();
        $message->setSubject($subject)
                ->setFrom($from)
                ->setTo($reciepient)
                ->setBody($body, "text/html");
        $this->get('mailer')->send($message);
    }
    
    /**
     * This method determine which api actions could be
     * called without login
     * 
     * @param type $actionName
     * @return boolean
     */
    private function _isAllowed($actionName){
        if(in_array($actionName,array("forgetPassword","resetPassword"))){
            return true;
        }else{
            if($this->getUser()){
                return true;
            }else{
                return false;
            }
        }
    }
}
