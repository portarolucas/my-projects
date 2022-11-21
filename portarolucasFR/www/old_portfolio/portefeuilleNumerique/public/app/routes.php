<?php

// Creating routes
// Psr-7 Request and Response interfaces
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use classes\DAOPortefeuille;
use controllers\UserController;

$app->get('/', 'UserController:connect')->setName('home');
$app->get('/home_panel', 'UserController:home_panel')->setName('home_panel');
$app->get('/inscription', 'UserController:inscription')->setName('inscription');
$app->get('/showService', 'UserController:voirService')->setName('showService');
$app->get('/showStats', 'UserController:voirStatistique')->setName('showStats');//SHOW STATISTIQUE

$app->post('/login', 'UserController:login')->setName('validLogin');
$app->post('/disconnect', 'UserController:disconnect')->setName('disconnectBtn');
$app->post('/validInscription', 'UserController:validInscription')->setName('validInscription');
$app->post('/shareAccount', 'UserController:partagerCompte')->setName('shareAccount');

$app->post('/shareService', 'UserController:partagerService')->setName('shareService');
$app->post('/addCompte', 'UserController:ajouterCompte')->setName('addCompte');
$app->post('/addService', 'UserController:ajouterService')->setName('addService');
$app->post('/delCompte', 'UserController:supprimerCompte')->setName('delCompte');
$app->post('/delService', 'UserController:supprimerService')->setName('delService');
$app->post('/updateCompte', 'UserController:modifierCompte')->setName('updateCompte');
$app->post('/updateService', 'UserController:modifierService')->setName('updateService');
/*$app->get('/AjouterCompte', 'UserController:ajouter_compte')->setName('ajouter_compte');
$app->get('/AjouterService', 'UserController:ajouter_service')->setName('ajouter_service');
$app->get('/EffacerCompte', 'UserController:effacer_compte')->setName('effacer_compte');
$app->get('/EffacerService', 'UserController:effacer_service')->setName('ajouter_service');
$app->get('/modifierCompte', 'UserController:modifier_compte')->setName('modifier_compte');
$app->get('/modifierService', 'UserController:modifier_service')->setName('modifier_service');
$app->get('/VoirCompte', 'UserController:voir_compte')->setName('voir_compte');
$app->get('/VoirService', 'UserController:voir_service')->setName('voir_service');
$app->get('/RechercherCompte', 'UserController:rechercher_compte')->setName('voir_compte');
$app->get('/RechercherService', 'UserController:rechercher_service')->setName('rechercher_service');
$app->get('/PartagerCompte', 'UserController:partager_compte')->setName('partager_compte');
$app->get('/PartagerService', 'UserController:partager_service')->setName('partager_service');*/

?>
