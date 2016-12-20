<?php
namespace Intelligent\UserBundle\Services;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\RedirectResponse;

 /**
 * When the user is not authenticated at all (i.e. when the security context has no token yet), 
 * the firewall's entry point will be called to start() the authentication process. 
 */

class LoginEntryPoint implements AuthenticationEntryPointInterface{

     protected $router;

    public function __construct($router){
        $this->router = $router;

    }
     /*
     * This method receives the current Request object and the exception by which the exception 
     * listener was triggered. 
     * 
     * The method should return a Response object
     */

    public function start(Request $request, AuthenticationException $authException = null){
        if($request->getRequestUri() == $this->router->generate('intelligent_api_v1')){
            $response = new Response(json_encode(array(
                "head" => array(
                    'status'=>"error"
                ),
                "body" => array(
                    "error_message" => "User not allowed to access api without login"
                )
            )), 401);
            $response->headers->set("Content-Type", "application/json");
            return $response;
        }
        else
            return new RedirectResponse ($this->router->generate('login'));
    }
}