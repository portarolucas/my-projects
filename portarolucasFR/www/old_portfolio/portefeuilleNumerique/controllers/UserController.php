<?php

namespace controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use classes\DAOPortefeuille;

class UserController
{


    public function __construct($container)
    {
        $this->container = $container;
    }

    public function connect(Request $request, Response $response, $args)
    {
        include 'verif_btnconnected.php';

        if(isset($_GET["error"]))
        {
            $this->container->view->getEnvironment()->addGlobal('message', "Échec d'authentification");
        }

        if(isset($_SESSION["connected"]) && $_SESSION["connected"])
        {
            //return $this->container->view->render($response, 'login.html'); //POUR TEST A DELETE
            return $response->withRedirect('./home_panel');// redirection page d'accueil
        }
        else
        {
            return $this->container->view->render($response, 'login.html'); //page d'inscription/connexion
        }
    }
    
    public function login(Request $request, Response $response, $args)
    {
        include 'verif_btnconnected.php';

        $data = $request->getParsedBody();
        $donnees = [];
        $donnees['user'] = filter_var($data['user'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['mdp'], FILTER_SANITIZE_STRING);
        $DAOPortefeuille = new DAOPortefeuille($this->container->db);
        $leUserInfo = $DAOPortefeuille->seConnecter($donnees['user'], $donnees['motDePasse']);

        if($leUserInfo)
        {
            $_SESSION["connected"] = true;
            $_SESSION["isAdmin"] = $leUserInfo["isAdmin"];
            $_SESSION["userID"] = $leUserInfo["id"];
            $_SESSION['username'] = $leUserInfo["username"];
            return $response->withRedirect('./home_panel'); // redirection page d'accueil
        }
        else
        {
            unset($_SESSION["connected"]);//pas besoin
            unset($_SESSION["userID"]);//pas besoin
            unset($_SESSION['username']);
            return $response->withRedirect('./?error=invalidCredentials');
        }
    }

    public function disconnect(Request $request, Response $response, $args)
    {
        unset($_SESSION["connected"]);
        unset($_SESSION["userID"]);
        unset($_SESSION['username']);
        return $response->withRedirect('./');
    }

    public function home_panel(Request $request, Response $response, $args)
    {
        include 'verif_btnconnected.php';

        if(isset($_SESSION["connected"]) && $_SESSION["connected"] == true)
        {
            $leUserID = $_SESSION["userID"];
            $DAOPortefeuille = new DAOPortefeuille($this->container->db);
            if(isset($_GET['added']))
                $this->container->view->getEnvironment()->addGlobal('added', $_GET['added']);
            $lesComptes = $DAOPortefeuille->getLesComptesByID($leUserID);
            $lesServices = $DAOPortefeuille->getLesServices();
            $lesCategories = $DAOPortefeuille->getLesCategories();

            if($_SESSION["isAdmin"])
                $this->container->view->getEnvironment()->addGlobal('isAdmin', true);
            $this->container->view->getEnvironment()->addGlobal('lesComptes', $lesComptes);
            $this->container->view->getEnvironment()->addGlobal('lesServices', $lesServices);
            $this->container->view->getEnvironment()->addGlobal('lesCategories', $lesCategories);
            return $this->container->view->render($response, 'accueil.html'); //page accueil
        }
        else
        {
            return $response->withRedirect('./');
        }
    }
    
    public function voirStatistique(Request $request, Response $response, $args)
    {
        include 'verif_btnconnected.php';

        if(isset($_SESSION["connected"]) && $_SESSION["connected"] == true)
        {
            $DAOPortefeuille = new DAOPortefeuille($this->container->db);
            $lesStats = $DAOPortefeuille->getLesStatistiques();

            $this->container->view->getEnvironment()->addGlobal('lesStats', $lesStats);
            return $this->container->view->render($response, 'statistique.html'); //page accueil
        }
        else
        {
            return $response->withRedirect('./');
        }
    }
    public function inscription(Request $request, Response $response, $args)
    {
        if(isset($_SESSION["connected"]) && $_SESSION["connected"] == true)
        {
            return $response->withRedirect('./'); //page accueil
        }
        else
        {
            return $this->container->view->render($response, 'inscription.html'); 
        }           //page inscription
    }
    public function validInscription(Request $request, Response $response, $args)
    {

        $data = $request->getParsedBody();
        $donnees = [];
        $donnees['username'] = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $donnees['mail'] = filter_var($data['mail'], FILTER_SANITIZE_STRING);
        $donnees['mdp'] = filter_var($data['mdp'], FILTER_SANITIZE_STRING);
        $donnees['confirmmdp'] = filter_var($data['confirmmdp'], FILTER_SANITIZE_STRING);
        $DAOPortefeuille = new DAOPortefeuille($this->container->db);
        $leUserInfo = $DAOPortefeuille->seInscrire($donnees);

        if($leUserInfo == 'Votre compte a bien été enregistré.')
        {
            $alertMessage['code'] = 'alert-success';
            $alertMessage['message'] = 'Succès: Votre compte a bien été créé.';
            $this->container->view->getEnvironment()->addGlobal('alertMessage', $alertMessage);
            return $this->container->view->render($response, 'inscription.html');
        }
        else if($leUserInfo == 'Erreur: Le nom d\'utilisateur est déjà utilisé.')
        {
            $alertMessage['code'] = 'alert-danger';
            $alertMessage['message'] = 'Erreur: Le nom d\'utilisateur saisie est déjà utilisé.';
            $this->container->view->getEnvironment()->addGlobal('alertMessage', $alertMessage);
            return $this->container->view->render($response, 'inscription.html');
        }
        else if($leUserInfo == 'Erreur: L\'adresse mail est déjà utilisé.')
        {
            $alertMessage['code'] = 'alert-danger';
            $alertMessage['message'] = 'Erreur: L\'adresse mail saisie est déjà utilisée.';
            $this->container->view->getEnvironment()->addGlobal('alertMessage', $alertMessage);
            return $this->container->view->render($response, 'inscription.html');
        }
        else if($leUserInfo == 'Erreur: Le mot de passe et le mot de passe de confirmation ne correspondent pas.')
        {
            $alertMessage['code'] = 'alert-danger';
            $alertMessage['message'] = 'Erreur: Le mot de passe et le mot de passe de confirmation ne correspondent pas.';
            $this->container->view->getEnvironment()->addGlobal('alertMessage', $alertMessage);
            return $this->container->view->render($response, 'inscription.html');
        }
    }
    public function partagerCompte(Request $request, Response $response, $args)
    {
        //effacement du compte sélectionné
        $bdd                          = new Bdd($this->container->db);
        $data                         = $request->getParsedBody();
        $donnees = [];
        $donnees['id_compte'] = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom'] = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service'] = filter_var($data['id_service'], FILTER_SANITIZE_STRING);
        $donnees['id_compte'] = $_SESSION["id_compte"];

        $compte = new Compte($donnees);
        $bdd->DeleteCompte($compte);
        return $response->withRedirect('./accueil');

    }
    
    public function getCompte(Request $request, Response $response, $args)
    {
        //reçoit les données du compte sélectionné
        
    }
    
    public function getService(Request $request, Response $response, $args)
    {
        //reçoit les données du service sélectionné
        
    }
    
    
    public function ajouterCompte(Request $request, Response $response, $args)
    {
        $bdd = new Bdd($this->container->db);
        $data = $request->getParsedBody();
        $donnees = [];
        $donnees['id_compte'] = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom'] = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service'] = filter_var($data['id_service'], FILTER_SANITIZE_STRING);
        $donnees['id_compte'] = $_SESSION["id_compte"];

        $compte = new Compte($donnees);
        $bdd->AjouterCompte($compte);
        return $response->withRedirect('./accueil');

    }
    
    public function ajouterService(Request $request, Response $response, $args)
    {
        $bdd = new Bdd($this->container->db);
        $data = $request->getParsedBody();
        $donnees = [];
        $donnees['id_compte'] = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom'] = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service'] = filter_var($data['id_service'], FILTER_SANITIZE_STRING);
        $donnees['id_compte'] = $_SESSION["id_compte"];

        $service = null;//<-------------
        $bdd->AjouterService($service);
        return $response->withRedirect('./accueil');
    }

    public function effacerCompte(Request $request, Response $response, $args)
    {
        //effacement du compte sélectionné
        $bdd                          = new Bdd($this->container->db);
        $data                         = $request->getParsedBody();
        $donnees = [];
        $donnees['id_compte'] = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom'] = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service'] = filter_var($data['id_service'], FILTER_SANITIZE_STRING);
        $donnees['id_compte'] = $_SESSION["id_compte"];

        $compte = new Compte($donnees);
        $bdd->DeleteCompte($compte);
        return $response->withRedirect('./accueil');

    }


    public function effacerService(Request $request, Response $response, $args)
    {
        //effacement du service
        $bdd = new Bdd($this->container->db);
        $data = $request->getParsedBody();
        $donnees = [];
        $donnees['id_compte'] = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date'] = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom'] = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login'] = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse'] = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service'] = filter_var($data['id_service'], FILTER_SANITIZE_STRING);
        $donnees['id_compte'] = $_SESSION["id_compte"];

        $service = null;//<-------------
        $bdd->DeleteService($service);
        return $response->withRedirect('./accueil');

    }

    public function UpdateCompte(Request $request, Response $response, $args)
    {
        //mise à jour du compte
        $bdd                          = new Bdd($this->container->db);
        $data                         = $request->getParsedBody();
        $donnees                      = [];
        $donnees['id_compte']         = filter_var($data['id_compte'], FILTER_SANITIZE_STRING);
        $donnees['date']              = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['nom']               = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['login']             = filter_var($data['login'], FILTER_SANITIZE_STRING);
        $donnees['motDePasse']        = filter_var($data['motDePasse'], FILTER_SANITIZE_STRING);
        $donnees['dateChangementMdp'] = filter_var($data['dateChangementMdp'], FILTER_SANITIZE_STRING);
        $donnees['id_service']        = filter_var($data['id_service'], FILTER_SANITIZE_STRING);

        $compte = new Compte($donnees);
        $bdd->UppdateCompte($compte);
        return $response->withRedirect('./accueil');
    }

    public function UpdateService(Request $request, Response $response, $args)
    {
        //mise à jour du service
        $bdd                          = new Bdd($this->container->db);
        $data                         = $request->getParsedBody();
        $donnees                      = [];
        $donnees['nom']             = filter_var($data['nom'], FILTER_SANITIZE_STRING);
        $donnees['date']             = filter_var($data['date'], FILTER_SANITIZE_STRING);
        $donnees['url']             = filter_var($data['url'], FILTER_SANITIZE_STRING);
        $donnees['port']             = filter_var($data['port'], FILTER_SANITIZE_STRING);

        $service = null;//<-------------
        $bdd->UppdateService($service);
        return $response->withRedirect('./accueil');
    }
    
}
    

?>