<?php

namespace Autoriko\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Autoriko\Models\TokenListeNoir;

use Autoriko\Utils\Writer;

class Token
{

  public static function generate_jwt($secret, $hour_limit, $data){
    $expire = time() + ($hour_limit * 3600);
    $token_jwt = JWT::encode( [
      'iss'=>'http://api.enchereauto',
      //'aud'=>'http://frontend.enchereauto',//TODO mettre le nom du site récepteur
      'iat'=>time(), 'exp'=>$expire,//3600 = 1h || avec 100 = 1m40
      'data' => $data
    ], $secret, 'HS512' );
    return $token_jwt;
  }

  public static function check_jwt(Response $response, $c, $secret, $token_jwt_string, $called_for = null){
    if($called_for == "check-authentication"){
      $additional_info = ' ' . $c['return_message']['token_jwt_error_additional_check_authentication']['message'];
    }else if($called_for == "confirm-mail"){
      $additional_info = ' ' . $c['return_message']['token_jwt_error_additional_confirm_email']['message'];
    }else if($called_for == "reset-forgotten-password"){
      $additional_info = ' ' . $c['return_message']['token_jwt_error_additional_reset_forgotten_password']['message'];
    }
    else{
      $additional_info = '';
    }

    try {
      $token_jwt = JWT::decode($token_jwt_string, $secret, ['HS512']);
      return $token_jwt;
    }catch (ExpiredException $e){
      return Writer::json_error($response, $c['return_message']['token_jwt_expired']['code'], $c['return_message']['token_jwt_expired']['message'] . $additional_info);
    } catch (SignatureInvalidException $e){
      return Writer::json_error($response, $c['return_message']['token_jwt_signature_invalid']['code'], $c['return_message']['token_jwt_signature_invalid']['message'] . $additional_info);
    } catch (BeforeValidException $e){
      return Writer::json_error($response, $c['return_message']['token_jwt_before_valid']['code'], $c['return_message']['token_jwt_before_valid']['message'] . $additional_info);
    } catch (\UnexpectedValueException $e){
      return Writer::json_error($response, $c['return_message']['token_jwt_unexpected_value']['code'], $c['return_message']['token_jwt_unexpected_value']['message'] . $additional_info);
    } catch (\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $c['return_message']['internal_server_error']['code'], $c['return_message']['internal_server_error']['message']);
    }
  }

  public static function generate_xsrf(){
    $token_xsrf = random_bytes(64);
    $token_xsrf = bin2hex($token_xsrf);

    //Vérifier que le token xsrf généré n'a pas déjà existé et est donc sur liste noir -> si c'est le cas le supprimer de la liste noir
    if(TokenListeNoir::where('session_token_xsrf', $token_xsrf)->exists()){
      TokenListeNoir::where('session_token_xsrf', $token_xsrf)->delete();
    }

    return $token_xsrf;
  }

  public static function generate_uuid($model){
    $uuid = random_bytes(16);
    $uuid = bin2hex($uuid);
    if($model::where('uuid', $uuid)->exists()){
      return self::generate_uuid($model);
    }else{
      return $uuid;
    }
  }
}
