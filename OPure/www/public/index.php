<?php
require_once '../src/vendor/autoload.php';

use App\Controllers\PagesGetController;
use App\Controllers\PagesPostController;

session_start();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require '../src/container.php';

$container = $app->getContainer();

// Middlewares
$app->add(new \App\Middlewares\FlashMiddleware($container->view->getEnvironment()));

// Routes
$app->group('', function() {
    // Route : Page d'accueil (GET)
    $this->get('/', PagesGetController::class . ':accueil')->setName('accueil');

    // Route : Page d'accueil (GET)
    $this->get('/blog', PagesGetController::class . ':blog')->setName('blog');

    // Route : Page d'accueil (GET)
    $this->get('/blog/filtre-opure', PagesGetController::class . ':filtreopure')->setName('filtreopure');

    // Route : Page d'accueil (GET)
    $this->get('/contact', PagesGetController::class . ':contact')->setName('contact');

    // Route : Page de profil (GET)
    $this->get('/profile', PagesGetController::class . ':profile')->setName('profile');

    // Route : Suppression d'un event (POST)
    $this->post('/event/delete', PagesPostController::class . ':eventDelete')->setName('eventDelete');


});

$app->run();
