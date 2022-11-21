<?php

namespace Autoriko\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

use Slim\Http\Response as Response;
use Autoriko\Controllers\AuthController;
use Autoriko\Utils\Cookie;
use Autoriko\Utils\Token;
use Autoriko\Utils\Writer;
use Autoriko\Models\TokenListeNoir;
use Autoriko\Models\Information_API;

class Auth{
  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function check_auth($request, $response, $next) : Response{
    if(!isset($request->getHeader('X-XSRF-TOKEN')[0]))//TODO : A supprimer
      return Writer::json_error($response, $this->c['return_message']['bad_token']['code'], 'Header X-XSRF-TOKEN manquant');//TODO : A supprimer
    if(Cookie::getCookieValue($request, 'token_jwt') == null)//TODO : A supprimer
      return Writer::json_error($response, $this->c['return_message']['bad_token']['code'], 'Cookie token_jwt manquant');//TODO : A supprimer
    if(isset($request->getHeader('X-XSRF-TOKEN')[0]) && (Cookie::getCookieValue($request, 'token_jwt') != null)){
      $header_xsrf = $request->getHeader('X-XSRF-TOKEN')[0];
      $cookie_jwt = Cookie::getCookieValue($request, 'token_jwt');

      $token_jwt_string = sscanf($cookie_jwt, "Bearer %s")[0];
      $information_api = Information_API::select()->first();
      $jwt_checker = Token::check_jwt($response, $this->c, $information_api->secret, $token_jwt_string, "check-authentication");
      if(isset($jwt_checker->data)){
        if($jwt_checker->data->xsrf == $header_xsrf){
          if(TokenListeNoir::where('session_token_xsrf', $header_xsrf)->exists() == false){
            $request = $request->withAttribute('user_uuid', $jwt_checker->data->uuid);
            $response = $next($request, $response);
            return $response;
          }else{
            AuthController::disable_cookie();//TODO : A editer > supprimer les titre 'TokenListeNoir:' et 'X-XSRF-TOKEN ivalid:'
            return Writer::json_error($response, $this->c['return_message']['you_are_disconnected_please_connect']['code'], 'TokenListeNoir : ' . $this->c['return_message']['you_are_disconnected_please_connect']['message']);
          }
        }
        else{//TODO : A editer > supprimer les titre 'TokenListeNoir:' et 'X-XSRF-TOKEN ivalid:'
          //X-XSRF-TOKEN invalid
          return Writer::json_error($response, $this->c['return_message']['bad_token']['code'], 'X-XSRF-TOKEN invalid : ' . $this->c['return_message']['bad_token']['message'] . $this->c['return_message']['token_jwt_error_additional_check_authentication']['message']);
        }
      }else if (get_class($jwt_checker) == Response::class){
        return $jwt_checker;
      }else{
        $this->c['logger.error']->error("Error : Erreur inconnue - Fichier 'Auth.php' (Middlewares) - Ligne 52" . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['token_missing_or_expired']['code'], $this->c['return_message']['token_missing_or_expired']['message']);
    }
  }
}
