<?php
require_once '../src/vendor/autoload.php';

use Autoriko\Controllers\GetController;
use Autoriko\Controllers\PostController;
use Autoriko\Middlewares\AuthMiddleware;
use Autoriko\Middlewares\GuestMiddleware;


session_start();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require '../src/Autoriko/container.php';
require '../src/Autoriko/database.php';

$container = $app->getContainer();

// Activating routes in a subfolder
$container['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

// Middlewares
$app->add(new \Autoriko\Middlewares\FlashMiddleware($container->view->getEnvironment()));

// Routes : utilisateur non connecté
$app->group('', function() {
    // Route : Page de connexion (GET)
    $this->get('/login', GetController::class . ':login')->setName('login');

    // Route : Page de connexion (POST)
    $this->post('/login', PostController::class . ':login');
})->add(new GuestMiddleware($container));

$app->group('', function() {
    // Route : Page d'accueil (GET)
    $this->get('/', GetController::class . ':home')->setName('home');

    // Route : Page de profil (GET)
    $this->get('/profile', GetController::class . ':profile')->setName('profile');

    // Route : Page de profil (POST)
    $this->post('/profile', PostController::class . ':profile');

    // Route : Page de déconnexion (GET)
    $this->get('/logout', GetController::class . ':logout')->setName('logout');


    // Route : Page de création d'un admin (GET)
    $this->get('/create/admin', GetController::class . ':createAdmin')->setName('createAdmin');

    // Route : Page de création d'un admin (POST)
    $this->post('/create/admin', PostController::class . ':createAdmin');

    // Route : Page de gestion des admins (GET)
    $this->get('/admins', GetController::class . ':admins')->setName('admins');

    // Route : Suppression d'un admin (POST)
    $this->post('/admin/delete', PostController::class . ':adminDelete')->setName('adminDelete');

    // Route : Modification d'un admin (POST)
    $this->post('/admin/update', PostController::class . ':adminUpdate')->setName('adminUpdate');


    // Route : Page de gestion des ventes (GET)
    $this->get('/ventes', GetController::class . ':ventes')->setName('ventes');

    // Route : Page de création d'un vente (GET)
    $this->get('/create/vente', GetController::class . ':createVente')->setName('createVente');

    // Route : Page de création d'un vente (POST)
    $this->post('/create/vente', PostController::class . ':createVente');

    // Route : Suppression d'un enchère (POST)
    $this->post('/vente/delete', PostController::class . ':venteDelete')->setName('venteDelete');

    // Route : Modification d'un enchère (POST)
    $this->post('/vente/update', PostController::class . ':venteUpdate')->setName('venteUpdate');


    // Route : Page de gestion des conversation (GET)
    $this->get('/conversations', GetController::class . ':conversations')->setName('conversations');

    // Route : Suppression d'une conversation (POST)
    $this->post('/conversation/delete', PostController::class . ':conversationDelete')->setName('conversationDelete');

    // Route : Modification d'un conversation (POST)
    $this->post('/conversation/update', PostController::class . ':conversationUpdate')->setName('conversationUpdate');


     // Route : Page de création d'une faq (GET)
    $this->get('/create/faq', GetController::class . ':createFaq')->setName('createFaq');

    // Route : Page de création d'un faq (POST)
    $this->post('/create/faq', PostController::class . ':createFaq');

    // Route : Page de gestion des faqs (GET)
    $this->get('/faqs', GetController::class . ':faqs')->setName('faqs');

    // Route : Suppression d'un faq (POST)
    $this->post('/faq/delete', PostController::class . ':faqDelete')->setName('faqDelete');

    // Route : Modification d'un faq (POST)
    $this->post('/faq/update', PostController::class . ':faqUpdate')->setName('faqUpdate');


    // Route : Page de gestion des entreprises (GET)
    $this->get('/entreprises', GetController::class . ':entreprises')->setName('entreprises');

     // Route : Suppression d'une entreprises (POST)
     $this->post('/entreprise/delete', PostController::class . ':entrepriseDelete')->setName('entrepriseDelete');

     // Route : Modification d'un entreprise (POST)
    $this->post('/entreprise/update', PostController::class . ':entrepriseUpdate')->setName('entrepriseUpdate');


    // Route : Page de gestion des particuliers (GET)
    $this->get('/particuliers', GetController::class . ':particuliers')->setName('particuliers');

    // Route : Suppression d'un particulier (POST)
    $this->post('/particulier/delete', PostController::class . ':particulierDelete')->setName('particulierDelete');

    // Route : Modification d'un particulier (POST)
    $this->post('/particulier/update', PostController::class . ':particulierUpdate')->setName('particulierUpdate');



    // // Route : Page de gestion des mentions (GET)
    // $this->get('/mentions', GetController::class . ':mentions')->setName('mentions');

    // // Route : Suppression d'une mention (POST)
    // $this->post('/mention/delete', PostController::class . ':mentionDelete')->setName('mentionDelete');

    // // Route : Modification d'une mention (POST)
    // $this->post('/mention/update', PostController::class . ':mentionUpdate')->setName('mentionUpdate');

    // // Route : Page de création d'une mention (GET)
    // $this->get('/create/mention', GetController::class . ':createMention')->setName('createMention');

    // // Route : Page de création d'une mention (Post)
    // $this->post('/create/mention', PostController::class . ':createMention');

    // Route : Page de gestion des mentions (GET)
    $this->get('/mentionpage', GetController::class . ':mentionpage')->setName('mentionpage');

    // Route : Modification d'une mention (POST)
    $this->post('/mentionpage/update', PostController::class . ':mentionPageUpdate')->setName('mentionPageUpdate');



    // // Route : Page de gestion des guides (GET)
    // $this->get('/guides', GetController::class . ':guides')->setName('guides');

    // // Route : Suppression d'un guide (POST)
    // $this->post('/guide/delete', PostController::class . ':guideDelete')->setName('guideDelete');

    // // Route : Modification d'un guide (POST)
    // $this->post('/guide/update', PostController::class . ':guideUpdate')->setName('guideUpdate');

    //  // Route : Page de création d'un guide (GET)
    //  $this->get('/create/guide', GetController::class . ':createGuide')->setName('createGuide');

    //  // Route : Page de création d'un guide (Post)
    //  $this->post('/create/guide', PostController::class . ':createGuide');


     // Route : Page de gestion des guides (GET)
     $this->get('/guidepage', GetController::class . ':guidepage')->setName('guidepage');

     // Route : Modification d'un guide (POST)
     $this->post('/guidepage/update', PostController::class . ':guidePageUpdate')->setName('guidePageUpdate');


    // Route : Page de gestion des informations du site (GET)
    $this->get('/informationsite', GetController::class . ':informationsite')->setName('informationsite');

     // Route : Modification d'une information du site (POST)
     $this->post('/informationsite/update', PostController::class . ':informationSiteUpdate')->setName('informationSiteUpdate');


    // Route : Page de création d'une marque (GET)
    $this->get('/create/marque', GetController::class . ':createMarque')->setName('createMarque');

    // Route : Page de création d'une marque (POST)
    $this->post('/create/marque', PostController::class . ':createMarque');

    // Route : Page de gestion des marques (GET)
    $this->get('/marques', GetController::class . ':marques')->setName('marques');

    // Route : Suppression d'une marque (POST)
    $this->post('/marque/delete', PostController::class . ':marqueDelete')->setName('marqueDelete');

    // Route : Modification d'une marque (POST)
    $this->post('/marque/update', PostController::class . ':marqueUpdate')->setName('marqueUpdate');


    // Route : Page de création d'une categorie (GET)
    $this->get('/create/categorie', GetController::class . ':createCategorie')->setName('createCategorie');

    // Route : Page de création d'une categorie (POST)
    $this->post('/create/categorie', PostController::class . ':createCategorie');

    // Route : Page de gestion des categories (GET)
    $this->get('/categories', GetController::class . ':categories')->setName('categories');

    // Route : Suppression d'une categorie (POST)
    $this->post('/categorie/delete', PostController::class . ':categorieDelete')->setName('categorieDelete');

    // Route : Modification d'une categorie (POST)
    $this->post('/categorie/update', PostController::class . ':categorieUpdate')->setName('categorieUpdate');



    // Route : Page de création d'une option (GET)
    $this->get('/create/option', GetController::class . ':createOption')->setName('createOption');

    // Route : Page de création d'une option (POST)
    $this->post('/create/option', PostController::class . ':createOption');

    // Route : Page de gestion des options (GET)
    $this->get('/options', GetController::class . ':options')->setName('options');

    // Route : Suppression d'une option (POST)
    $this->post('/option/delete', PostController::class . ':optionDelete')->setName('optionDelete');

    // Route : Modification d'une option (POST)
    $this->post('/option/update', PostController::class . ':optionUpdate')->setName('optionUpdate');



    // Route : Page de création d'une representation (GET)
    $this->get('/create/representation', GetController::class . ':createRepresentation')->setName('createRepresentation');

    // Route : Page de création d'une representation (POST)
    $this->post('/create/representation', PostController::class . ':createRepresentation');

    // Route : Page de gestion des representations (GET)
    $this->get('/representations', GetController::class . ':representations')->setName('representations');

    // Route : Suppression d'une representation (POST)
    $this->post('/representation/delete', PostController::class . ':representationDelete')->setName('representationDelete');

    // Route : Modification d'une representation (POST)
    $this->post('/representation/update', PostController::class . ':representationUpdate')->setName('representationUpdate');


// Route : Page de création d'une voiture (GET)
    $this->get('/create/voiture', GetController::class . ':createVoiture')->setName('createVoiture');

    // Route : Page de création d'une voiture (POST)
    $this->post('/create/voiture', PostController::class . ':createVoiture');

    // Route : Page de gestion des voiture (GET)
    $this->get('/voitures', GetController::class . ':voitures')->setName('voitures');

    // Route : Suppression d'une voiture (POST)
    $this->post('/voiture/delete', PostController::class . ':voitureDelete')->setName('voitureDelete');

    // Route : Modification d'une voiture (POST)
    $this->post('/voiture/update', PostController::class . ':voitureUpdate')->setName('voitureUpdate');



// Route : Page de création d'une categorie de photo (GET)
    $this->get('/create/categoriephoto', GetController::class . ':createCategoriePhoto')->setName('createCategoriePhoto');

    // Route : Page de création d'une representation (POST)
    $this->post('/create/categoriephoto', PostController::class . ':createCategoriePhoto');

    // Route : Page de gestion des representations (GET)
    $this->get('/categoriephotos', GetController::class . ':categoriephotos')->setName('categoriephotos');

    // Route : Suppression d'une representation (POST)
    $this->post('/categoriephoto/delete', PostController::class . ':categoriePhotoDelete')->setName('categoriePhotoDelete');

    // Route : Modification d'une representation (POST)
    $this->post('/categoriephoto/update', PostController::class . ':categoriePhotoUpdate')->setName('categoriePhotoUpdate');

})->add(new AuthMiddleware($container));

$app->run();
