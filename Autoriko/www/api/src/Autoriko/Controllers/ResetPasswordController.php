<?php
namespace Autoriko\Controllers;

use Autoriko\Utils\Writer;
use Autoriko\Utils\Token;
use Autoriko\Utils\Password;
use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Autoriko\Controllers\AuthController;

use Autoriko\Models\Utilisateur;
use Autoriko\Models\LienDisponible;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

class ResetPasswordController {
  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public static function generate_token($user, $information_api, $data = null){
    $user_created_at = $user->created_at;
    $user_email = $user->mail;
    $user_password = $user->mdp;
    $user_uuid = $user->uuid;

    $jwt_body = [
      'uuid' => $user_uuid,
      'email' => $user_email
    ];
    if($data != null){
      $jwt_body = array_merge($jwt_body, $data);
    }

    //secret = mot de passe haché (de la BDD) + un tiret + la date en timestamp de la création du compte
    $secret = $user_password . '-' . strtotime($user_created_at);

    //heure limite avant l'indisponibilité du lien de changement de mot de passe qui sera généré
    $hour_limit_reset_password = $information_api->heure_limite_reset_mdp;

    $token_jwt = Token::generate_jwt($secret, $hour_limit_reset_password, $jwt_body);
    return $token_jwt;
  }

  public function resetPassword(Request $request, Response $response, $args){
    $user_uuid = $args['uuid'];
    $token = $args['token'];

    $data = $request->getParsedBody();
    if(!isset($data['password'])){
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }else{
      $password = $data['password'];
    }

    if($user_uuid && $token){
      try{
        $user = Utilisateur::where('uuid', $user_uuid)->firstOrFail();

        $user_created_at = $user->created_at;
        $user_email = $user->mail;
        $user_password = $user->mdp;
        $user_uuid = $user->uuid;

        $secret = $user_password . '-' . strtotime($user_created_at);
        $jwt_checker = Token::check_jwt($response, $this->c, $secret, $token, "reset-forgotten-password");
        if(isset($jwt_checker->data)){
          try{
            $link_available = LienDisponible::where('id_lien', $jwt_checker->data->link_id)->firstOrFail();
            if(($jwt_checker->data->uuid == $user_uuid) && ($jwt_checker->data->email == $user_email)){
              if(Password::check_valid_password($password)){
                $password = Password::hashPassword($password);
                $user->mdp = $password;
                $user->save();
                $array_return = [
                  "code" => 204,
                  "message_status" => "Le mot de passe a bien été modifié."
                ];
                return Writer::json_output($response, 204, $array_return);
              }else{
                return Writer::json_error($response, $this->c['return_message']['password_bad_format']['code'], $this->c['return_message']['password_bad_format']['message']);
              }
            }else{
              return Writer::json_error($response, $this->c['return_message']['bad_token']['code'], $this->c['return_message']['bad_token']['message']);
            }
          }catch(ModelNotFoundException $e){
            return Writer::json_error($response, $this->c['return_message']['link_not_available']['code'], $this->c['return_message']['link_not_available']['message']);
          }
          catch(\Exception $e){
            $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
            return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
          }
        }else if (get_class($jwt_checker) == Response::class){
          return $jwt_checker;
        }else{
          $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
          return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
        }
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_account']['code'], $this->c['return_message']['unknown_account']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }
}
