<?php

return [
  'return_message' => [
    'internal_server_error' => [
      'message' => "Une erreur interne a été rencontré, votre action n'a pu être aboutie.",
      'code' => 500
    ],
    'missing_argument' => [
      'message' => "Un ou plusieurs arguments sont manquant, votre action n'a pu être aboutie.",
      'code' => 400
    ],
    'missing_or_incorrect_argument' => [
      'message' => "Un ou plusieurs arguments sont manquant et/ou incorrect, votre action n'a pu être aboutie.",
      'code' => 400
    ],
    'unknown_authenticated_user' => [
      'message' => "Un problème est survenu, votre action n'a pu aboutir car votre compte n'existe pas ou plus, veuillez vous reconnecter. Si le problème persiste veuillez contacter un administrateur.",
      'code' => 401
    ],
    'signin_bad_password' => [
      'message' => "L'adresse e-mail ou le mot de passe que vous avez entré n'est pas valide.",
      'code' => 401
    ],
    'signin_bad_email' => [
      'message' => "L'adresse e-mail ou le mot de passe que vous avez entré n'est pas valide.",
      'code' => 401
    ],
    'signin_email_not_verified' => [
      'message' => "L'adresse e-mail du compte n'a pas été confirmé.",
      'code' => 401
    ],
    'email_already_taken' => [
      'message' => "L'adresse e-mail saisie est déjà utilisé.",
      'code' => 400
    ],
    'email_bad_format' => [
      'message' => "L'adresse e-mail entré n'est pas valide, veuillez réessayer.",
      'code' => 400
    ],
    'password_bad_format' => [
      'message' => "Le mot de passe entré n'est pas valide. Il doit contenir au minimum 5 caractères veuillez réessayer.",
      'code' => 400
    ],
    'unknown_resource' => [
      'message' => "Votre action n'a pu aboutir car la ressource affecté n'existe pas ou plus",
      'code' => 404
    ],
    'unknown_account' => [
      'message' => "Votre action n'a pu aboutir car le compte affecté n'existe pas ou plus.",
      'code' => 404
    ],
    'forbidden_resource' => [
      'message' => "Vous n'avez pas le droit d'accèder, modifier, ou supprimer cette ressource.",
      'code' => 403
    ],
    'forbidden_resource_update' => [
      'message' => "Vous n'avez pas le droit de modifier cette ressource",
      'code' => 403
    ],
    'authentication_required' => [
      'message' => "Vous devez être connecté pour exécuter cette action.",
      'code' => 401
    ],
    'link_not_available' => [
      'message' => "Votre action ne peut aboutir car le lien que vous utilisez n'est plus disponible.",
      'code' => 403
    ],
    'unknown_account_email' => [
      'message' => "L'adresse e-mail fourni n'appartient à aucun compte.",
      'code' => 400
    ],
    'bad_body_request_required_json' => [
      'message' => "Votre demande n'a pu aboutir, la requête n'est pas correcte ou son corps est inccorect.",
      'code' => 415
    ],
    'bad_header_request_required_json_content' => [
      'message' => "Votre demande n'a pu aboutir, la requête n'est pas correcte.",
      'code' => 415
    ],
    'bad_token' => [
      'message' => "Votre jeton d'accès est invalide.",
      'code' => 401
    ],
    'token_jwt_expired' => [
      'message' => "Votre jeton n'est plus valable.",
      'code' => 401
    ],
    'token_jwt_signature_invalid' => [
      'message' => "Votre jeton n'est plus valable.",
      'code' => 401
    ],
    'token_jwt_before_valid' => [
      'message' => "Votre jeton n'est plus valable.",
      'code' => 401
    ],
    'token_jwt_unexpected_value' => [
      'message' => "Votre jeton n'est plus valable.",
      'code' => 401
    ],
    'token_jwt_error_additional_check_authentication' => [
      'message' => "Veuillez vous reconnecter."
    ],
    'token_jwt_error_additional_confirm_email' => [
      'message' => "Veuillez regénérer un lien de confirmation afin de valider votre adresse e-mail."
    ],
    'token_jwt_error_additional_reset_forgotten_password' => [
      'message' => "Veuillez refaire une demande de mot de passe oublié."
    ],
    'token_missing_or_expired' => [
      'message' => "Votre jeton est manquant ou plus valable.",
      'code' => 401
    ],
    'bad_account_data_country' => [
      'message' => "Le pays entré n'est pas autorisé.",
      'code' => 401
    ],
    'bad_account_data_phone_number' => [
      'message' => "Numéro de téléphone inccorect, votre numéro de téléphone ne peut pas dépasser les 20 caractères.",
      'code' => 401
    ],
    'bad_account_data_date_of_birth' => [
      'message' => "Votre date de naissance n'est pas valide, vous devez être majeur.",
      'code' => 401
    ],
    'bad_account_data_entreprise_siren' => [
      'message' => "SIREN invalide (doit contenir que des chiffres).",
      'code' => 401
    ],
    'you_are_disconnected_please_connect' => [
      'message' => "Vous êtes déconnecté, veuillez vous reconnecter.",
      'code' => 401
    ],
    'you_are_now_disconnected' => [
      'message' => "Vous êtes maintenant déconnecté.",
      'code' => 401
    ],
  ]
];
