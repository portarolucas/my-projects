<?php

require_once '../src/vendor/autoload.php';

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;
use Autoriko\Controllers\PostController;
use Autoriko\Controllers\GetController;
use Autoriko\Controllers\PutController;
use Autoriko\Controllers\PatchController;
use Autoriko\Controllers\DeleteController;
use Autoriko\Controllers\ResetPasswordController;
use Autoriko\Middlewares\CheckJSONRequest;

use Autoriko\Utils\Writer;

$settings       = require_once '../config/settings.php';
$dependencies   = require_once '../config/dependencies.php';
$return_message = require_once '../config/return_message.php';
$errors         = require_once '../config/errors.php';

$config = parse_ini_file($settings['settings']['dbfile']);
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$c = new \Slim\Container(array_merge($settings, $dependencies, $return_message, $errors));

// Activating routes in a subfolder
$c['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

//$c = new \Slim\Container(array_merge($settings, $dependencies, $errors)); REMETTRE AVEC LES ERREURS POUR LA RELEASE
$app = new \Slim\App($c);

/* Désactivation du CORS (Désactiver quand l'application sera sur le même serveur que la FrontOffice) */
$app->add(Autoriko\Middlewares\Cors::class . ':addCors');
/* -------------------- */

$app->options('/{routes:.+}', function(Request $rq, Response $rs, array $args) {
    return $rs;
});

//Ajouter le container ($c) de l'$app dans le constructeur de GetController et PostController --->>>>> S'ajoute automatiquement dans le constructeur = plus besoin
/*$container[GetController::class] = function ($c) {
    return new GetController($c);
};
$container[PostController::class] = function ($c) {
    return new PostController($c);
};
$container[PutController::class] = function ($c) {
    return new PutController($c);
};*/

$app->group('', function() use ($app) {

  $app->group('', function() use ($app) {
    //POST : Déconnexion d'un utilisateur
    $app->post('/disconnect[/]', PostController::class . ':disconnect')->setName('disconnect');

    //GET :  Récuperer l'utilisateur connecté (via son UUID dans le token)
    $app->get('/account[/]', GetController::class . ':getAccount')->setName('getAccount');

    //GET : Récuperer les conversations de l'utilisateur connecté (via son UUID dans le token)
    $app->get('/account/conversations[/]', GetController::class . ':getAccountConversations')->setName('getAccountConversations');

    //POST : Mettre en vu les conversations (via les uuid conversations passé dans le body) de l'utilisateur connecté
    $app->post('/account/conversations[/]', PostController::class . ':postAccountReadConversation')->setName('postAccountReadConversation');

    //GET : Récuperer une conversation via son UUID
    $app->get('/conversations/{uuid}[/]', GetController::class . ':getConversation')->setName('getConversation');

    //GET : Récuperer les messages d'une conversation via son UUID
    $app->get('/conversations/{uuid}/messages[/]', GetController::class . ':getConversationMessages')->setName('getConversationMessages');

    //POST : Poster un message dans une conversation via son UUID
    $app->post('/conversations/{uuid}/messages[/]', PostController::class . ':postConversationMessage')->add(CheckJSONRequest::class . ':checkJSON');

    //GET : Récuperer les alertes de l'utilisateur connecté (via son UUID dans le token)
    $app->get('/account/alertes[/]', GetController::class . ':getAccountAlertes')->setName('getAccountAlertes');

    //POST : Mettre en vu les alertes (via les id alertes passé dans le body) de l'utilisateur connecté
    $app->post('/account/alertes[/]', PostController::class . ':postAccountReadAlerte')->setName('postAccountReadAlerte');

    //GET : Récuperer les participations aux enchères de l'utilisateur connecté (via son UUID dans le token)
    $app->get('/account/ventes[/]', GetController::class . ':getAccountVentes');

    //Supprimer le compte de l'utilisateur connecté (soft delete) (via son UUID dans le token)
    $app->delete('/account[/]', DeleteController::class . ':deleteAccount');

    //PATCH : Modifier son profil
    $app->patch('/account[/]', PatchController::class . ':patchModifyProfil')->setName('patchModifyProfil')->add(CheckJSONRequest::class . ':checkJSON');

    //GET :  Récuperer les infos primordiales d'une enchère via son UUID
    $app->get('/ventesSoft/{uuid}[/]', GetController::class . ':getVenteSoft')->setName('getVenteSoft');

    //POST : Faire une offre => Si on est connecté, qu'on  accès à la vente et que le prix actuel du client et le même quand base de
    //données : alors on poura valider la nouvelle offre
    $app->post('/ventes/offre[/]', PostController::class . ':postOffre')->setName('postOffre');

    //POST : Inscription d'un utilisateur a une offre
    $app->post('/ventes/offre/inscription[/]', PostController::class . ':postInscriptionOffre')->setName('postInscriptionOffre');

  })->add(Autoriko\Middlewares\Auth::class . ':check_auth');

  //POST : Connexion utilisateur
  $app->post('/signin[/]', PostController::class . ':signin')->setName('signin')->add(CheckJSONRequest::class . ':checkJSON');

  //POST : Inscription d'un utilisateur
  $app->post('/signup[/]', PostController::class . ':signupSoft')->setName('signupSoft')->add(CheckJSONRequest::class . ':checkJSON');

  //POST :  Url confirmation adresse mail
  $app->post('/account/confirm/mail/{uuid}/{token}[/]', PostController::class . ':postConfirmMail')->setName('postConfirmMail');

  //POST : Inscription d'un utilisateur
  $app->post('/contact[/]', PostController::class . ':contactForm')->setName('contactForm')->add(CheckJSONRequest::class . ':checkJSON');

  //GET :  Récuperer un utilisateur via son UUID
  $app->get('/users/{uuid}[/]', GetController::class . ':getUser')->setName('getUser');

  //GET :  Récuperer tous les utilisateurs
  $app->get('/users[/]', GetController::class . ':getUsers');

  //GET : Récupérer un administrateur via son UUID
  $app->get('/admins/{uuid}[/]', GetController::class . ':getAdmin')->setName('getAdmin');

  //GET : Récupérer tous les administrateurs
  $app->get('/admins[/]', GetController::class . ':getAdmins');

  //GET :  Récuperer toutes les enchères
  $app->get('/ventes[/]', GetController::class . ':getVentes')->setName('getVentes');

  //GET :  Récuperer une enchère via son UUID
  $app->get('/ventes/{uuid}[/]', GetController::class . ':getVente')->setName('getVente');

  //GET : Récuperer les informations du site
  $app->get('/site/informations[/]', GetController::class . ':getSiteInformations');

  //GET : Récuperer les Q/R (FAQ)
  $app->get('/site/faqs[/]', GetController::class . ':getSiteFaqs');

  //GET : Récuperer les marques
  $app->get('/site/brands[/]', GetController::class . ':getSiteBrands');

  //PUT : Changement de mot de passe :
  // - en étant connecté
  // - en étant déconnecté : oublie de mot de passe : envoyer une demande de changement de mot de passe par mail
  $app->put('/account/password[/]', PutController::class . ':putChangePassword')->setName('putChangePassword')->add(CheckJSONRequest::class . ':checkJSON');
  $app->post('/account/password/reset/{uuid}/{token}[/]', ResetPasswordController::class . ':resetPassword')->setName('resetPassword')->add(CheckJSONRequest::class . ':checkJSON');

})->add(Autoriko\Middlewares\GlobalHeaders::class . ':addAndCheckJsonHeaders');

//GET :  Page exemple Front Office - confirmation du page mail
$app->get('/page/account/confirm/mail/{uuid}/{token}[/]', GetController::class . ':getPageConfirmMail')->setName('getPageConfirmMail');

//GET :  Page exemple Front Office - réinitialisation mot de passe perdu
$app->get('/page/account/password/reset/{uuid}/{token}[/]', GetController::class . ':getPageResetPassword')->setName('getPageResetPassword');

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

$app->run();
