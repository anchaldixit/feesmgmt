<?php

namespace Intelligent\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Intelligent\UserBundle\Entity\User;
use Intelligent\UserBundle\Entity\Role;
use Symfony\Component\Security\Core\Util\StringUtils;

class ApiController extends Controller {
    private static $DEBUG = true;
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
            if(self::$DEBUG){
                return $this->_handleException($e,$e->getTrace());
            }else{
                return $this->_handleException($e);
            }
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

    /**
     * This function will give the list of the users 
     * 
     * @param Request $request
     * @param type $json
     * @return Response
     * @throws \Exception
     */
    private function getUsers(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions->getManageUserAndShareAppPermission()){
            $body = $json->body;
            if(!isset($body->where)){
                throw new \Exception("where is not set in the request json",400);
            }else if(!isset($body->order_by)){
                throw new \Exception("order_by is not set in the request json",400);
            }else if(!isset($body->order_type)){
                throw new \Exception("order_type is not set in the request json",400);
            }else{
                $where = $body->where;
                if(!isset($where->name)){
                    throw new \Exception("where.name is not set in the request json",400);
                }else if(!isset($where->role)){
                    throw new \Exception("where.role is not set in the request json",400);
                }else if(!isset($where->status)){
                    throw new \Exception("where.status is not set in the request json",400);
                }else{
                    // Check roles or status ids 
                    $this->_checkRoles($where->role);
                    $this->_checkStatus($where->status);
                    // check order by and order type
                    $this->_checkOrderBy($body->order_by, array("name", "role", "status", "last_login"));
                    $this->_checkOrderType($body->order_type);
                    
                    // Fetch results 
                    $em = $this->getDoctrine()->getManager();
                    $query = $em->createQueryBuilder();
                    $query->select("u")
                            ->addSelect("r")
                            ->from("IntelligentUserBundle:User","u")
                            ->join("u.role","r");
                            
                    if($where->name){
                        $query->andWhere($query->expr()->like("u.name","%" . $where->name));
                    }
                        
                    if($where->role){
                        $query->andWhere($query->expr()->eq("r.id", $where->role));
                    }
                        
                    if($where->status){
                        $query->andWhere($query->expr()->eq("u.status", $where->status));
                    }
                    
                    // Get order by clause
                    switch($body->order_by){
                        case "name":
                            $order_by = "u.name";
                            break;
                        case "role":
                            $order_by = "r.id";
                            break;
                        case "status":
                            $order_by = "u.status";
                            break;
                        default:
                            $order_by = "u.name";
                            $body->order_by = 'name';
                    }
                    $body->order_type = ($body->order_type?$body->order_type:"asc");
                    $query->orderBy($order_by,$body->order_type);
                    
                    $dql = $query->getQuery();
                    $results = $dql->getResult();
                    
                    $users = array();
                    foreach($results as $user){
                        $users[] = array(
                            'id' => $user->getId(),
                            'name' => $user->getName(),
                            'role' => array(
                                'id' => $user->getRole()->getId(), 
                                'name' => $user->getRole()->getName()
                            ),
                            'status' => $user->getStatus(),
                            'last_login' => (!is_null($user->getLastLogin())? $user->getLastLogin()->format("m/d/Y H:i:s") : "Not loggedin yet")
                        );
                    }
                    return $this->_handleSuccessfulRequest(array('data' => $users,"order_by" => $body->order_by, "order_type" => $body->order_type));
                }
            }
        }else{
            throw new \Exception("Current user has no access to user data", 403);
        }
    }
    
    private function inviteUsers(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions->getManageUserAndShareAppPermission()){
            $body = $json->body;
            if(is_array($body)){
                $new_user_arr = array();
                foreach($body as $index => $new_user){
                    if(isset($new_user->email) && isset($new_user->new_role)){
                        $em = $this->getDoctrine()->getManager();
                        # check for already existing email/username
                        $already_existing_user = $em->getRepository("IntelligentUserBundle:User")
                                ->findOneBy(array("email" => $new_user->email));
                        if($already_existing_user){
                            throw new \Exception("Email ($new_user->email) already exists as user",412);
                        }
                        # Check the role
                        $attached_role = $em->getRepository("IntelligentUserBundle:Role")->find($new_user->new_role);
                        if(!$attached_role){
                            throw new \Exception("new_role ($new_user->new_role) is not valid",412);
                        }
                        $newUser = new User();
                        $newUser->setEmail($new_user->email);
                        $newUser->setRole($attached_role);
                        $newUser->setStatus(User::UNVERIFIED);
                        $newUser->setVerificationId(uniqid());
                        $newUser->setCreateDatetime(new \DateTime());
                        $newUser->setUpdateDatetime(new \DateTime());
                        $new_user_arr[] = $newUser;
                        
                    }else{
                        throw new \Exception("Email or new role_id is not set in json at index #$index",400);
                    }
                    foreach($new_user_arr as $new_user_final){
                        // Send email
                        $email_body = $this->_getEmailBody("inviteUser.html.twig", array('emailVerifyId' => $new_user_final->getVerificationId()));
                        $this->_sendEmail($new_user_final->getEmail(), "Verify your email", $email_body);
                        // Persist user
                        $em->persist($new_user_final);
                    }
                    # Now finish by sending email and saving new users 
                    $em->flush();
                    return $this->_handleSuccessfulRequest();
                }
            }else{
                throw new \Exception("Body should be array in the request json",400);
            }
        }else{
            throw new \Exception("Current user has no access to user data", 403);
        }
    }
    
    private function registerUser(Request $request, $json){
        $body = $json->body;
        if($isset($body->verification_id) && $isset($body->name) && $isset($body->password)){
            $em = $this->getDoctrine()->getManager();
            $new_user = $em->getRepository("IntelligentUserBundle:User")->findOneBy(array("verificationId" => $body->verification_id));
            $status = $new_user->getStatus();
            if($status == User::UNVERIFIED){
                $new_user->setName($body->name);
                $new_user->setStatus(User::REGISTERED);
                $new_user->setPassword($body->password);
                $new_user->setUpdateDateTime(new \DateTime());
                $em->flush();
                return $this->_handleSuccessfulRequest();
            }else{
                throw new \Exception("verification_id is not valid",412);
            }
        }else{
            throw new \Exception("verification_id or first_name or last_name or password is not set in the request json",400);
        }
    }
    /**
     * This api action will be used to disable users
     * 
     * @param Request $request
     * @param type $json
     * @return type
     * @throws \Exception
     */
    private function disableUser(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions->getManageUserAndShareAppPermission()){
            if(isset($json->body->user_id)){
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository("IntelligentUserBundle:User")->find($json->body->user_id);
                if($user){
                    // If user is available then disable it
                    $user->setStatus(User::DEACTIVATED)->setUpdateDatetime(new \DateTime());
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
    
    
    /**
     * This api action will be used to change role of the user 
     * 
     * @param Request $request
     * @param type $json
     * @return type
     * @throws \Exception
     */
    private function changeRole(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions->getManageUserAndShareAppPermission()){
            if(isset($json->body->user_id) && isset($json->body->new_role_id)){
                $em = $this->getDoctrine()->getManager();
                // Get user
                $user = $em->getRepository("IntelligentUserBundle:User")->find($json->body->user_id);
                if($user){
                    // Now get role 
                    $role = $em->getRepository("IntelligentUserBundle:Role")->find($json->body->new_role_id);
                    if($role){
                        // If both are present then change it
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
    
    private function getRoles(Request $request, $json){
        $user_permissions = $this->get('user_permissions');
        if($user_permissions->getManageUserAndShareAppPermission()){
            $body = $json->body;
            if(isset($body->where) && !isset($body->where->name)){
                throw new \Exception("where.name is not set in the request json",400);
            }else{
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQueryBuilder();
                $query->select("r")
                        ->addSelect("p")
                        ->from("IntelligentUserBundle:Role","r")
                        ->join("r.globalPermission","p");
                
                #Add where clauses;
                if(isset($body->where) && isset($body->where->name)){
                    $query->where($query->expr()->like("r.name", $body->where->name));
                }
                # Always order by name
                $query->orderBy("r.name","asc");
                echo $query->getQuery()->getSql();exit;
                $roles = $query->getQuery()->getResult();
                $roles_result = array();
                foreach($roles as $role){
                    $roles_result[] = array(
                        'id' => $role->getId(),
                        'name' => $role->getName(),
                        'app_permissions' => array(
                            'user' => ($role->getGlobalPermission()? $role->getGlobalPermission()->getManageUserAppPermission():false),
                            'app'  => ($role->getGlobalPermission()? $role->getGlobalPermission()->getEditAppStructurePermission():false)
                        ),
                        "is_active" => $role->getStatus()
                    );
                }
                return $this->_handleSuccessfulRequest(array('data' => $roles_result));
            }
        }else{
            throw new \Exception("Current user has no access to list roles", 403);
        }
    }
    
    /**
     * This function will convert the exception into a response object 
     * 
     * @param \Exception $exception
     * @param type $responseCode
     * @return Response
     */
    private function _handleException(\Exception $exception, $trace=null) {
        $error_response_arr = array(
            'head' => array(
                'status' => 'error'
            ),
            'body' => array(
                'error_msg' => $exception->getMessage()
            )
        );
        if(!is_null($trace)){
            $error_response_arr['body']['trace'] = $trace;
        }
        $response = new Response(json_encode($error_response_arr));
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
        if(in_array($actionName,array("forgetPassword","resetPassword","registerUser"))){
            return true;
        }else{
            if($this->getUser()){
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * This function will check if any role ids passed is
     * not available or inactive
     * 
     * @param type $rolesArr array of role ids
     * @throws \Exception if any role ids passed is not active
     */
    private function _checkRoles($rolesArr){
        if(!is_array($rolesArr)){
            $rolesArr = array($rolesArr);
        }
        $repo = $this->getDoctrine()->getManager()->getRepository("IntelligentUserBundle:Role");
        $all_active_roles = $repo->findBy(array("status" => Role::ACTIVE));
        $active_role_ids = array();
        foreach($all_active_roles as $role){
            $active_role_ids[] = $role->getId();
        }
        
        $not_available_roles = array();
        foreach($rolesArr as $role_id){
            if(!in_array($role_id,$active_role_ids)){
                $not_available_roles[] = $role_id;
            }
        }
        if(count($not_available_roles) > 0){
            $not_available_roles_str = implode(", ", $not_available_roles);
            throw new \Exception("role ids ($not_available_roles_str) not available or inactive", 412);
        }
        
    }
    
    /**
     * This function will check if all the status ids
     * are correct
     * 
     * @param mived $statusArr 
     * @throws \Exception
     */
    private function _checkStatus($statusArr){
        if(!is_array($statusArr)){
            $statusArr = array($statusArr);
        }
        
        $valid_status_id_arr = array(1,2,3,4,5,6);
        $not_valid_status_id_arr = array();
        foreach($statusArr as $status_id){
            if(!in_array($status_id,$valid_status_id_arr)){
                $not_valid_status_id_arr[] = $status_id;
            }
        }
        if(count($not_valid_status_id_arr) > 0){
            $not_valid_status_id_str = implode(", ", $not_valid_status_id_arr);
            throw new \Exception("status ids ($not_valid_status_id_str) not available or inactive", 412);
        }
    }
    
    private function _checkOrderBy($orderByKey, $permittedValues){
        if(!in_array($orderByKey,$permittedValues)){
            throw new \Exception("body.order_by value($orderByKey) is invalid",412);
        }
    }
    
    private function _checkOrderType($orderType){
        if($orderType  !== 'asc' && $orderType !== 'desc'){
            throw new \Exception("body.order_type value($orderType) is invalid",412);
        }
    }
}
