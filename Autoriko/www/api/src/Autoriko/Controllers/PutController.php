<?php
namespace Autoriko\Controllers;

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Autoriko\Models\Utilisateur;
use Autoriko\Models\Information_API;
use Autoriko\Models\LienDisponible;
use Autoriko\Controllers\AuthController;
use Autoriko\Controllers\ResetPasswordController;

use Autoriko\Utils\Writer;
use Autoriko\Utils\Mail;

class PutController{

  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function putChangePassword(Request $request, Response $response){
    $uuid_utilisateur = $request->getAttribute('user_uuid');
    if($uuid_utilisateur){
      //utilisateur (normalement) authentifié qui veut changer son mdp
      try{
        $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();

      }
      catch(ModelNotFoundException $e){
        $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
        return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      //utilisateur non authentifié qui a perdu son mot de passe
      $data = $request->getParsedBody();
      if(isset($data['email'])){
        $data_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $mail_checker = filter_var($data_email, FILTER_VALIDATE_EMAIL);
        if($mail_checker){
          try{
            $user = Utilisateur::where('mail', $data_email)->firstOrFail();
            $information_api = Information_API::select()->first();
            $hour_limit_reset_password = $information_api->heure_limite_reset_mdp;

            $link_available = new LienDisponible();
            $link_available->save();
            $link_available_id = $link_available->id_lien;

            //CRÉER UN TOKEN POUR MODIFIER SON MOT DE PASSE VALABLE PENDANT X TEMPS - PUIS GÉNÉRER UN LIEN
            //le lien est valide pour une seule utilisation
            //Génerer un ID dans le payload pour chaque lien : et on vérifie dans la database (lien_liste_noir) s'il a déjà été utilisé
            $token = ResetPasswordController::generate_token($user, $information_api, ['link_id' => $link_available_id]);
            $link = $this->c->get('router')->pathFor('getPageResetPassword', ["uuid" => $user->uuid, "token" => $token]);

            //*** SEND MAIL
            $from = ["mail" => "confirm-mail@autorikoo.fr", "name" => "Autoriko"];
            $to = [
              $user->mail => $user->nom . ' ' . $user->prenom
            ];
            $mail = new Mail($response, $this->c, $from, $to);

            $mail->makeResetPasswordMail($link, $hour_limit_reset_password);
            if($mail->send_mail()){
              $array_return = [
                'code' => '202',
                "message_status" => "Un lien pour changer votre mot de passe vous a été envoyé sur votre adresse mail."
              ];
              $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
              return Writer::json_output($response, 202, $array_return);
            }
          }
          catch(ModelNotFoundException $e){
            return Writer::json_error($response, $this->c['return_message']['unknown_account_email']['code'], $this->c['return_message']['unknown_account_email']['message']);
          }
          catch(\Exception $e){
            $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
            return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
          }
        }else{
          return Writer::json_error($response, $this->c['return_message']['email_bad_format']['code'], $this->c['return_message']['email_bad_format']['message']);
        }
      }else{
        return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
      }
    }
  }

}
