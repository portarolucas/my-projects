<?php
namespace Autoriko\Controllers;

use Firebase\JWT\JWT;
use Autoriko\Utils\Token;
use Autoriko\Utils\Cookie;
use Autoriko\Utils\Writer;

use Autoriko\Models\Particulier;
use Autoriko\Models\Entreprise;
use Autoriko\Models\Information_API;

class AuthController {

  public static function generate_token($user, $information_api){
    $user_uuid = $user->uuid;
    $secret = $information_api->secret;
    $hour_limit_session = $information_api->heure_limite_session;

    $token_xsrf = Token::generate_xsrf();
    $token_jwt = Token::generate_jwt($secret, $hour_limit_session, [
      'uuid' => $user_uuid,
      'xsrf' => $token_xsrf
    ]);
    return ['token_jwt' => $token_jwt, 'token_xsrf' => $token_xsrf];
  }

  public static function generate_connection($response, $user){
    $information_api = Information_API::select()->first();
    $hour_limit_session = $information_api->heure_limite_session;
    $hour_limit_refresh = $information_api->heure_limite_refresh;

    $tokens = self::generate_token($user, $information_api);
    $token_xsrf = $tokens['token_xsrf'];
    $token_jwt = $tokens['token_jwt'];

    Cookie::addCookie('token_jwt', 'Bearer ' . $token_jwt, $hour_limit_session);

    $array_return = [
      'type' => 'ressource',
      'token_xsrf' => $token_xsrf,
      'user' => [
        'uuid' => $user->uuid,
        'firstname' => $user->prenom,
        'lastname' => $user->nom,
        'email' => $user->mail,
        'country' => $user->pays,
        'zip' => $user->code_postal,
        'city' => $user->ville,
        'address' => $user->adresse,
        'address_additional' => $user->comp_adresse,
        'phone_home' => $user->telephone_fixe,
        'cellphone' => $user->telephone_mobile,
        'type' => $user->type,
        'state_confirm_mail' => $user->etat_confirmation_mail,
        'state_validate_account' => $user->etat_validation_compte
      ]
    ];
    if($user->type === 0){
      $particulier = Particulier::find($user->id_utilisateur);
      $array_return["user"] = array_merge($array_return["user"], [
        "date_of_birth" => $particulier->date_naissance,
        "url_identity_document" => $particulier->url_photocopie_piece_id
      ]);
    }else if($user->type === 1){
      $entreprise = Entreprise::find($user->id_utilisateur);
      $array_return["user"]["entreprise"] = [
        "name" => $entreprise->raison_sociale,
        "siren" => $entreprise->siren,
        "number_tva" => $entreprise->numero_tva,
        "kabis" => $entreprise->url_photocopie_kabis
      ];
    }

    return Writer::json_output($response, 200, $array_return);
  }

  public static function get_token_xsrf($request){
    return $request->getHeader('X-XSRF-TOKEN')[0];
  }

  public static function disable_cookie(){
    Cookie::deleteCookie('token_jwt');
  }
}
