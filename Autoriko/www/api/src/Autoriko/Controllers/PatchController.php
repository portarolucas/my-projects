<?php
namespace Autoriko\Controllers;

use Autoriko\Utils\Writer;
use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Autoriko\Models\Utilisateur;
use Autoriko\Models\Information_API;
use Autoriko\Controllers\AuthController;
use Autoriko\Controllers\ResetPasswordController;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatchController{

  private $c;

  var $client_to_db;
  var $authorized_country;

  public function __construct($c){
    $this->c = $c;
    $this->client_to_db = $c['settings']['api_settings']['client_to_db'];
    $this->authorized_country = $c['settings']['api_settings']['authorized_country'];
  }

  public function patchModifyProfil(Request $request, Response $response){
    try{
      $uuid = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      $authenticated_type = $authenticated->type;
      $data = $request->getParsedBody();
      foreach ($data as $key => $value) {
        if(isset($this->client_to_db['utilisateur'][$key]) || ($authenticated_type == 0 && isset($this->client_to_db['particulier'][$key])) || ($authenticated_type == 1 && isset($this->client_to_db['entreprise'][$key]))){
          if($key == 'email'){
            $mail = filter_var($value, FILTER_SANITIZE_EMAIL);
            $mail_checker = filter_var($mail, FILTER_VALIDATE_EMAIL);
            if($mail_checker)
              $authenticated[$this->client_to_db['utilisateur'][$key]] = $mail;
            else
              return Writer::json_error($response, $this->c['return_message']['email_bad_format']['code'], $this->c['return_message']['email_bad_format']['message']);
          }else if($key == 'country'){
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            $value = strtolower($value);
            if(isset($this->authorized_country[$value])){
              $authenticated[$this->client_to_db['utilisateur'][$key]] = $value;
            }else{
              return Writer::json_error($response, $this->c['return_message']['bad_account_data_country']['code'], $this->c['return_message']['bad_account_data_country']['message']);
            }
          }else if($key == 'phone_home' && $key == 'cellphone'){
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            if(strlen($value) <= 20)
              $authenticated[$this->client_to_db['utilisateur'][$key]] = $value;
            else
              return Writer::json_error($response, $this->c['return_message']['bad_account_data_phone_number']['code'], $this->c['return_message']['bad_account_data_phone_number']['message']);
          }else if($key == 'date_of_birth'){
            $verifyDate = \Autoriko\Utils\DateTool::checkDate($value);
            if($verifyDate)
              $authenticated->particulier[$this->client_to_db['particulier'][$key]] = $value;
            else
              return Writer::json_error($response, $this->c['return_message']['bad_account_data_date_of_birth']['code'], $this->c['return_message']['bad_account_data_date_of_birth']['message']);
          }else if($key == 'siren'){
            $siren_checker = filter_var($value, FILTER_VALIDATE_INT);
            if($siren_checker)
              $authenticated->entreprise[$this->client_to_db['entreprise'][$key]] = $value;
            else
              return Writer::json_error($response, $this->c['return_message']['bad_account_data_entreprise_siren']['code'], $this->c['return_message']['bad_account_data_entreprise_siren']['message']);
          }
          else{
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            if(isset($this->client_to_db['utilisateur'][$key]))
              $authenticated[$this->client_to_db['utilisateur'][$key]] = $value;
            else if($authenticated_type == 0)
              $authenticated->particulier[$this->client_to_db['particulier'][$key]] = $value;
            else if($authenticated_type == 1)
              $authenticated->entreprise[$this->client_to_db['entreprise'][$key]] = $value;
          }
        }else{
          //Le champ n'existe pas -> il serra ignoré
        }
      }
      try{
        if($authenticated_type == 0)
          $authenticated->particulier->save();
        else if($authenticated_type == 1)
          $authenticated->entreprise->save();
        $authenticated->save();
        $array_return = [
          "code" => 204,
          "message_status" => "Votre compte a bien été modifié."
        ];
        return Writer::json_output($response, 204, $array_return);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }
}
