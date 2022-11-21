<?php
namespace Autoriko\Controllers;

use Autoriko\Utils\Writer;
use Autoriko\Utils\Cookie;
use Autoriko\Utils\Token;
use Autoriko\Utils\Password;
use Autoriko\Utils\Mail;
use Autoriko\Utils\ContactForm;
use Autoriko\Controllers\AuthController;
use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Capsule\Manager as DB;

use Autoriko\Models\Achat;
use Autoriko\Models\Admin;
use Autoriko\Models\Alerte;
use Autoriko\Models\Conversation;
use Autoriko\Models\Vente;
use Autoriko\Models\Offre;
use Autoriko\Models\Encherissement;
use Autoriko\Models\Entreprise;
use Autoriko\Models\Faq;
use Autoriko\Models\Message;
use Autoriko\Models\Particulier;
use Autoriko\Models\Photo;
use Autoriko\Models\Representant;
use Autoriko\Models\Utilisateur;
use Autoriko\Models\Video;
use Autoriko\Models\Information_API;
use Autoriko\Models\TokenListeNoir;
use Autoriko\Models\LienDisponible;
use Autoriko\Models\RecevoirAlerte;
use Autoriko\Models\ParticipationVente;

class PostController{

  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function signin(Request $request, Response $response) {
    $data = $request->getParsedBody();

    if(isset($data['email']) && isset($data['password'])){
      $mail = $data['email'];
      $password = $data['password'];
      $mail_checker = filter_var($mail, FILTER_VALIDATE_EMAIL);
      if($mail_checker){
        try{
          $user = Utilisateur::where('mail', $mail)->firstOrFail();
          if($user->etat_confirmation_mail == 1){
            if(Password::verifyPassword($password, $user->mdp)) {
              return AuthController::generate_connection($response, $user);
            }
            else {
              return Writer::json_error($response, $this->c['return_message']['signin_bad_password']['code'], $this->c['return_message']['signin_bad_password']['message']);
            }
          }else{
            return Writer::json_error($response, $this->c['return_message']['signin_email_not_verified']['code'], $this->c['return_message']['signin_email_not_verified']['message']);
          }
        }
        catch(ModelNotFoundException $e){
          return Writer::json_error($response, $this->c['return_message']['signin_bad_email']['code'], $this->c['return_message']['signin_bad_email']['message']);
        }
        catch(\Exception $e){
          $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
          return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
        }
      }
      else{
        return Writer::json_error($response, $this->c['return_message']['email_bad_format']['code'], $this->c['return_message']['email_bad_format']['message']);
      }
    }
    else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function signupSoft(Request $request, Response $response) {
    $data = $request->getParsedBody();

    if(isset($data['type']) && isset($data['firstname']) && isset($data['lastname']) && isset($data['email']) && isset($data['password'])){
      $data_type = filter_var($data['type'], FILTER_VALIDATE_INT);

      if(($data_type == 1 && isset($data['name_entreprise'])) || $data_type == 0){
        $data_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $mail_checker = filter_var($data_email, FILTER_VALIDATE_EMAIL);
        if($mail_checker){

          $mail_already_taken = Utilisateur::where('mail', $data_email)->exists();
          if(!$mail_already_taken){
            $data_firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
            $data_lastname = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
            if($data_type == 1)
              $data_name_entreprise = filter_var($data['name_entreprise'], FILTER_SANITIZE_STRING);

            if(\Autoriko\Utils\Password::check_valid_password($data['password']) === false){
              return Writer::json_error($response, $this->c['return_message']['password_bad_format']['code'], $this->c['return_message']['password_bad_format']['message']);
            }else{
              $data_password = Password::hashPassword($data['password']);
            }

            $user = new Utilisateur();
            $user->prenom = $data_firstname;
            $user->nom = $data_lastname;
            $user->mail = $data_email;
            $user->mdp = $data_password;
            $user->type = $data_type;
            $user->uuid = Token::generate_uuid(Utilisateur::class);

            try{
              $user->save();
              try{
                if($data_type == 0){
                  $particulier = new Particulier();
                  $particulier->id_utilisateur = $user->id_utilisateur;
                  $particulier->save();
                }else if($data_type == 1){
                  $entreprise = new Entreprise();
                  $entreprise->raison_sociale = $data_name_entreprise;
                  $entreprise->id_utilisateur = $user->id_utilisateur;
                  $entreprise->save();
                }
                //*** Génération Token JWT et lien de confirmation (confirmation inscription)
                $information_api = Information_API::select()->first();
                $hour_limit_confirm_mail = $information_api->heure_limite_confirmation_mail;

                $link_available = new LienDisponible();
                $link_available->save();
                $link_available_id = $link_available->id_lien;

                $token = Token::generate_jwt($user->uuid, $hour_limit_confirm_mail, ['uuid' => $user->uuid, 'link_id' => $link_available_id]);
                $link = $this->c->get('router')->pathFor('getPageConfirmMail', ["uuid" => $user->uuid, "token" => $token]);

                //*** SEND MAIL
                $from = ["mail" => "confirm-mail@autoriko.fr", "name" => "Autoriko"];
                $to = [
                  $user->mail => $user->nom . ' ' . $user->prenom
                ];
                $mail = new Mail($response, $this->c, $from, $to);
                $mail->makeConfirmMail($link, $hour_limit_confirm_mail);
                if($mail->send_mail()){
                  $array_return = [
                    'code' => '201',
                    'type' => 'ressource',
                    "message_status" => "Le compte a bien été créé, veuillez cliquer sur le lien de confirmation qui vous a été envoyé par mail afin de valider votre inscription.",
                    'user' => [
                      'firstname' => $user->prenom,
                      'lastname' => $user->nom,
                      'email' => $user->mail
                    ]
                  ];
                  //$response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
                  return Writer::json_output($response, 201, $array_return);
                }
                else{
                  return Writer::json_error($response, 400, "Erreur: le mail de confirmation n'a pu être envoyé. Veuillez réessayer, si le problèm persiste veuillez contacter un administrateur.");
                }
              }
              catch(\Exception $e){
                $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
                return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
              }
            }
            catch(\Exception $e){
              $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
              return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
            }
          }else{
            return Writer::json_error($response, $this->c['return_message']['email_already_taken']['code'], $this->c['return_message']['email_already_taken']['message']);
          }

        }
        else{
          return Writer::json_error($response, $this->c['return_message']['email_bad_format']['code'], $this->c['return_message']['email_bad_format']['message']);
        }
      }else{
        return Writer::json_error($response, $this->c['return_message']['missing_or_incorrect_argument']['code'], $this->c['return_message']['missing_or_incorrect_argument']['message']);
      }
    }
    else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function postConfirmMail(Request $request, Response $response, $args){
    $token_url = $args['token'];
    $uuid_url = $args['uuid'];
    $jwt_checker = Token::check_jwt($response, $this->c, $uuid_url, $token_url, "confirm-mail");
    if(isset($jwt_checker->data)){
      try{
        $link_available = LienDisponible::where('id_lien', $jwt_checker->data->link_id)->firstOrFail();
        try{
          $user = Utilisateur::where('uuid', $uuid_url)->first();
          $user->etat_confirmation_mail = 1;
          $user->save();
          $link_available->delete();

          return AuthController::generate_connection($response, $user);
        }catch(ModelNotFoundException $e){
          return Writer::json_error($response, $this->c['return_message']['unknown_account']['code'], $this->c['return_message']['unknown_account']['message']);
        }
        catch(\Exception $e){
          $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
          return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
        }
      }catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['link_not_available']['code'], $this->c['return_message']['link_not_available']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }
    else if (get_class($jwt_checker) == Response::class){
      return $jwt_checker;
    }else{
      $this->c['logger.error']->error("-\n\r" . "Unknown Error : File PostController.php - Line : 191\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }

  public function disconnect(Request $request, Response $response){
    $uuid = $request->getAttribute('user_uuid');
    $token_xsrf = AuthController::get_token_xsrf($request);

    $blacklist = new TokenListeNoir();
    $blacklist->session_token_xsrf = $token_xsrf;
    $blacklist->save();

    AuthController::disable_cookie();

    $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));

    $array_return = [
      "code" => "200",
      "message_status" => "Vous avez bien été déconnecté."
    ];

    return Writer::json_output($response, 200, $array_return);
  }

  public function postConversationMessage(Request $request, Response $response, $args){
    $data = $request->getParsedBody();
    if(isset($data['message'])){
      $data_message = filter_var($data['message'], FILTER_SANITIZE_STRING);
      $type = 0;

      try{
        $uuid_conversation = $args['uuid'];
        $conversation = Conversation::where('uuid', 'like', '%' . $uuid_conversation . '%')->firstOrFail();
        $id_conversation = $conversation->id_conversation;
        try{
          $uuid_utilisateur = $request->getAttribute('user_uuid');
          $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();
          $id_utilisateur = $user->id_utilisateur;
          $user_isAdmin = false;
          $user_name = $user->nom . ' ' . $user->prenom;

          if($conversation->id_utilisateur == $user->id_utilisateur){
            $message = new Message();
            $message->message = $data_message;
            $message->type = $type;
            $message->id_conversation = $id_conversation;
            $message->id_utilisateur = $id_utilisateur;
            $message->save();
            if($message->id_message){
              $array_return = [
                "code" => "201",
                "type" => "ressource",
                "message_status" => "Votre message a bien été envoyé.",
                "message" => [
                  'id' => $message->id_message,
                  'message' => $message->message,
                  'type' => $message->type,
                  'created_at' => $message->created_at,
                  'user_name' => $user_name,
                  'user_isAdmin' => $user_isAdmin
                ]
              ];
              return Writer::json_output($response, 201, $array_return);
            }else{
              return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
            }
          }else{
            return Writer::json_error($response, $this->c['return_message']['forbidden_resource']['code'], $this->c['return_message']['forbidden_resource']['message']);
          }
        }
        catch(ModelNotFoundException $e){
          return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
        }
        catch(\Exception $e){
          $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
          return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
        }
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_resource']['code'], $this->c['return_message']['unknown_resource']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function contactForm(Request $request, Response $response, $args){
    $data = $request->getParsedBody();

    if(isset($data['email']) && isset($data['message'])){

      $data_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
      $mail_checker = filter_var($data_email, FILTER_VALIDATE_EMAIL);
      if($mail_checker){
        $data_message = filter_var($data['message'], FILTER_SANITIZE_STRING);
        if(isset($data['phone_number'])){
          $data_phone_number = filter_var($data['phone_number'], FILTER_SANITIZE_STRING);
        }else{
          $data_phone_number = null;
        }
        if(isset($data['firstname'])){
          $data_firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
        }else{
          $data_firstname = null;
        }
        if(isset($data['lastname'])){
          $data_lastname = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
        }else{
          $data_lastname = null;
        }

        try{
          //*** SEND MAIL
          $from = ["mail" => $data_email, "name" => $data_lastname . ' ' . $data_firstname];
          $to = [
            'autoriko@contact.fr' => 'Contact Autoriko'
          ];
          $mail = new Mail($response, $this->c, $from, $to);
          $mail->makeContactFormMail($data_message, $data_lastname, $data_firstname, $data_phone_number);
          if($mail->send_mail()){
            $array_return = [
              'code' => '201',
              'type' => 'ressource',
              "message_status" => "Le formulaire de contact a bien été validé et transmis à notre équipe. Autoriko vous répondra au plus vite sur votre adresse mail saisie dans le formulaire."
            ];
            //$response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
            return Writer::json_output($response, 201, $array_return);
          }
          else{
            return Writer::json_error($response, 400, "Erreur: le formulaire de contact n'a pas pu être envoyé. Veuillez réessayer, si le problèm persiste veuillez contacter un administrateur.");
          }
        }
        catch(\Exception $e){
          $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
          return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
        }
      }
      else{
        return Writer::json_error($response, $this->c['return_message']['email_bad_format']['code'], $this->c['return_message']['email_bad_format']['message']);
      }
    }
    else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function postAccountReadAlerte(Request $request, Response $response, $args){
    $data = $request->getParsedBody();
    if(isset($data['alertes']) && is_array($data['alertes'])){
      try{
        $alerts = $data['alertes'];
        $uuid_utilisateur = $request->getAttribute('user_uuid');
        $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();
        foreach ($alerts as $alert_id) {
          if(filter_var($alert_id, FILTER_VALIDATE_INT)){
            RecevoirAlerte::where('id_alerte', '=', $alert_id)->where('id_utilisateur', '=', $user->id_utilisateur)->update(['alerte_vu' => 1]);
          }
        }
        $array_return = [
          'code' => '200'
        ];
        return Writer::json_output($response, 200, $array_return);
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function postAccountReadConversation(Request $request, Response $response, $args){
    $data = $request->getParsedBody();
    if(isset($data['conversations']) && is_array($data['conversations'])){
      try{
        $conversations = $data['conversations'];
        $uuid_utilisateur = $request->getAttribute('user_uuid');
        $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();
        foreach ($conversations as $conversation_uuid) {
          $uuid = filter_var($conversation_uuid, FILTER_SANITIZE_STRING);
          $conversation = Conversation::where('uuid', 'like', '%' . $uuid . '%')->first();
          if($conversation){
            $conversation->conversation_vu = 1;
            $conversation->save();
          }
        }
        $array_return = [
          'code' => '200'
        ];
        return Writer::json_output($response, 200, $array_return);
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function postInscriptionOffre(Request $request, Response $response, $args){
    //TODO vérifier que l'utilisateur n'est pas déjà inscrit
    if(isset($data['uuid'])){
      try{
        $uuid_utilisateur = $request->getAttribute('user_uuid');
        $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
      try{
        $vente = Vente::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
        $participation = new ParticipationVente();
        $participation->id_vente = $vente->id_vente;
        $participation->id_utilisateur = $user->id_utilisateur;
        $participation->save();

        $array_return = [
          'code' => '200'
        ];
        return Writer::json_output($response, 200, $array_return);
      }
      catch(ModelNotFoundException $e){
        $response->withHeader('Location', $this->c->get('router')->pathFor('getAccountConversations'));
        return Writer::json_error($response, $this->c['return_message']['unknown_resource']['code'], $this->c['return_message']['unknown_resource']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }
    else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }

  public function postOffre(Request $request, Response $response, $args){
    $data = $request->getParsedBody();
    if(isset($data['uuid']) && isset($data['price']) && isset($data['actualPrice'])){
      $uuid = $data['uuid'] = filter_var($data['uuid'], FILTER_SANITIZE_STRING);
      $price = $data['price'] = filter_var($data['price'], FILTER_SANITIZE_NUMBER_INT);
      $actualPrice = $data['actualPrice'] = filter_var($data['actualPrice'], FILTER_SANITIZE_NUMBER_INT);
      try{
        $uuid_utilisateur = $request->getAttribute('user_uuid');
        $user = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();
      }
      catch(ModelNotFoundException $e){
        return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }

      try{
        $vente = Vente::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      }
      catch(ModelNotFoundException $e){
        $response->withHeader('Location', $this->c->get('router')->pathFor('getAccountConversations'));
        return Writer::json_error($response, $this->c['return_message']['unknown_resource']['code'], $this->c['return_message']['unknown_resource']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }

      if($price == 50 || $price == 100 || $price == 250 || $price == 500 || $price == 1000){
        if($actualPrice == $vente->prix){
          if($user->participation_vente->contains($vente->id_vente)){
            $offre = Offre::where('id_vente', '=', $vente->id_vente)->where('id_utilisateur', '=', $user->id_utilisateur)->first();
            if($offre){
              $offre->montant = $price + $actualPrice;
              $offre->save();
            }else{
              $offre = new Offre();
              $offre->montant = $price + $actualPrice;
              $offre->id_vente = $vente->id_vente;
              $offre->id_utilisateur = $user->id_utilisateur;
              $offre->save();
            }
            $vente->prix = $price + $actualPrice;
            $vente->nombre_offre = $vente->nombre_offre + 1;
            $vente->save();

            $alert = new Alerte();
            $alert->message = "Un utilisateur a ajouté {$price}€ à la vente <b>TEST-TEST</b> a commencé !<br>Faites une offre.";
            $alert->lien = 'https://www.youtube.com/';
            $alert->save();

            DB::insert('
              INSERT INTO recevoir_alerte(`id_utilisateur`, `id_alerte`, `alerte_vu`)
              SELECT participation.id_utilisateur, ?, 0
              FROM participation
              WHERE id_vente = ?
              AND id_utilisateur != ?
            ', [$alert->id_alerte, $vente->id_vente, $user->id_utilisateur]);

            $array_return = [
              'code' => '200'
            ];
            return Writer::json_output($response, 200, $array_return);
          }else{
            return Writer::json_error($response, $this->c['return_message']['forbidden_resource']['code'], "Vous n'avez pas le droit de participer à l'offre.");
          }
        }else{
          return Writer::json_error($response, $this->c['return_message']['missing_or_incorrect_argument']['code'], 'Le prix n\'est plus le même.');
        }
      }else{
        return Writer::json_error($response, $this->c['return_message']['missing_or_incorrect_argument']['code'], 'Offre inccorect.');
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);
    }
  }
}
