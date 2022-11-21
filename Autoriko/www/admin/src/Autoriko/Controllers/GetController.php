<?php
namespace Autoriko\Controllers;

use Autoriko\Controllers\Auth\AuthController;
use Autoriko\Models\Utilisateur;
use Autoriko\Models\Administrateur;
use Autoriko\Models\Categorie;
use Autoriko\Models\Categorie_photo;
use Autoriko\Models\Conversation;
use Autoriko\Models\Vente;
use Autoriko\Models\Entreprise;
use Autoriko\Models\Faq;
use Autoriko\Models\Mention_legale;
use Autoriko\Models\Mention_legale_page;
use Autoriko\Models\Guide;
use Autoriko\Models\Guide_page;
use Autoriko\Models\Information_site;
use Autoriko\Models\Particulier;
use Autoriko\Models\Marque;
use Autoriko\Models\Photo_voiture;
use Autoriko\Models\Video_voiture;
use Autoriko\Models\Option;
use Autoriko\Models\Representation_voiture;
use Autoriko\Models\Voiture;
use Slim\Http\Request;
use Slim\Http\Response;

class GetController extends Controller {

    public function home(Request $request, Response $response) {
        $this->render($response, 'Pages/Home.twig');
    }

    public function login(Request $request, Response $response) {
        $this->render($response, 'Pages/Login.twig');
    }

    public function logout(Request $request, Response $response) {
        AuthController::logout();
        return $this->redirect($response, 'login');
    }

    //CREATE
    public function createAdmin(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateAdmin.twig');
    }

    public function createVente(Request $request, Response $response) {
      $voitures = Voiture::whereNull('id_vente')->with('photo_voiture.categorie_photo')->with('marque')->get();
      $this->render($response, 'Pages/CreateVente.twig', ['voitures' => $voitures]);
    }

    public function createFaq(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateFaq.twig');
    }

    public function createMention(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateMention.twig');
    }

    public function createGuide(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateGuide.twig');
    }

    public function createMarque(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateMarque.twig');
    }

    public function createCategorie(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateCategorie.twig');
    }

    public function createOption(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateOption.twig');
    }

    public function createRepresentation(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateRepresentation.twig');
    }

    public function createVoiture(Request $request, Response $response) {
        $marques = Marque::select()->get();
        $categories = Categorie::select()->get();
        $categories_photos = Categorie_photo::select()->get();

        $this->render($response, 'Pages/CreateVoiture.twig', ['marques' => $marques, 'categories' => $categories, 'categories_photos' => $categories_photos] );
    }

    public function createCategoriePhoto(Request $request, Response $response) {
        $this->render($response, 'Pages/CreateCategoriePhoto.twig');
    }

    public function admins(Request $request, Response $response) {
        $admins = Administrateur::where('id_admin', '!=', $_SESSION['id_admin'])->get();
        $this->render($response, 'Pages/Admins.twig', ['admins' => $admins]);
    }

    public function ventes(Request $request, Response $response) {
        $ventes = Vente::select()->get();
        $voitures = Voiture::select()->get();
        $this->render($response, 'Pages/Ventes.twig', ['ventes' => $ventes, 'voitures' => $voitures]);
    }

    public function conversations(Request $request, Response $response) {
        $conversations = Conversation::select()->get();
        $this->render($response, 'Pages/Conversations.twig', ['conversations' => $conversations]);
    }

    public function faqs(Request $request, Response $response) {
        $faqs = Faq::select()->get();
        $this->render($response, 'Pages/Faqs.twig', ['faqs' => $faqs]);
    }

    public function entreprises(Request $request, Response $response) {
        $utilisateurs = Utilisateur::where('type', '=', '1')->with('Entreprise')->get();
        $this->render($response, 'Pages/Entreprises.twig', ['utilisateurs' => $utilisateurs]);
    }

    public function particuliers(Request $request, Response $response) {
        $utilisateurs = Utilisateur::where('type', '=', '0')->with('Particulier')->get();
        $this->render($response, 'Pages/Particuliers.twig', ['utilisateurs' => $utilisateurs]);
    }

    public function mentions(Request $request, Response $response) {
        $mentions = Mention_legale::select()->get();
        $this->render($response, 'Pages/Mentions_legales.twig', ['mentions' => $mentions]);
    }

    public function mentionpage(Request $request, Response $response) {
        $mentionpage = Mention_legale_page::first();
        $this->render($response, 'Pages/Mention_page.twig', ['mentionpage' => $mentionpage]);
    }

    public function guides(Request $request, Response $response) {
        $guides = Guide::select()->get();
        $this->render($response, 'Pages/Guides.twig', ['guides' => $guides]);
    }

    public function guidepage(Request $request, Response $response) {
        $guidepage = Guide_page::first();
        $this->render($response, 'Pages/Guide_page.twig', ['guidepage' => $guidepage]);
    }

    public function informationsite(Request $request, Response $response) {
        $informationsite = Information_site::first();
        $this->render($response, 'Pages/Information_site.twig', ['informationsite' => $informationsite]);
    }

    public function marques(Request $request, Response $response) {
        $marques = Marque::select()->get();
        $this->render($response, 'Pages/Marques.twig', ['marques' => $marques]);
    }

    public function categories(Request $request, Response $response) {
        $categories = Categorie::select()->get();
        $this->render($response, 'Pages/Categories.twig', ['categories' => $categories]);
    }

    public function options(Request $request, Response $response) {
        $options = Option::select()->get();
        $this->render($response, 'Pages/Options.twig', ['options' => $options]);
    }

    public function representations(Request $request, Response $response) {
        $representations = Representation_voiture::select()->get();
        $this->render($response, 'Pages/Representations.twig', ['representations' => $representations]);
    }

    public function voitures(Request $request, Response $response) {
        $voitures = Voiture::select()->get();
        $marques = Marque::select()->get();
        $categories = Categorie::select()->get();

        $this->render($response, 'Pages/Voitures.twig', ['voitures' => $voitures, 'marques' => $marques, 'categories' => $categories]);
    }

    public function categoriephotos(Request $request, Response $response) {
        $categoriephotos = Categorie_photo::select()->get();
        $this->render($response, 'Pages/Categoriephotos.twig', ['categoriephotos' => $categoriephotos]);
    }
}
