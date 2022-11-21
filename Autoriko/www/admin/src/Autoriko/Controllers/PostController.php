<?php
namespace Autoriko\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Autoriko\Controllers\Auth\AuthController;
use Autoriko\Models\Achat;
use Autoriko\Models\Administrateur;
use Autoriko\Models\Alerte;
use Autoriko\Models\Categorie;
use Autoriko\Models\Categorie_photo;
use Autoriko\Models\Contact_page;
use Autoriko\Models\Conversation;
use Autoriko\Models\Vente;
use Autoriko\Models\Encherissement;
use Autoriko\Models\Faq;
use Autoriko\Models\Information_site;
use Autoriko\Models\Utilisateur;
use Autoriko\Models\Guide;
use Autoriko\Models\Guide_page;
use Autoriko\Models\Mention_legale;
use Autoriko\Models\Mention_legale_page;
use Autoriko\Models\Marque;
use Autoriko\Models\Photo_voiture;
use Autoriko\Models\Video_voiture;
use Autoriko\Models\Option;
use Autoriko\Models\Representation_voiture;
use Autoriko\Models\Voiture;

use Autoriko\Utils\Token;
use Autoriko\Utils\FileChecker;


class PostController extends Controller{

    public function login(Request $request, Response $response) {
        $mail = htmlspecialchars(trim($request->getParam('email_address')));
        $mdp = htmlspecialchars(trim($request->getParam('password')));

        if(empty($mail) || empty($mdp)) {
            $this->flash('Un ou plusieurs champs sont vide(s) !', 'error');
        } else {
            if(!AuthController::login($mail, $mdp)) {
                $this->flash('Adresse email ou mot de passe incorrect !', 'error');
            } else {
                return $this->redirect($response, 'home');
            }
        }
        return $this->redirect($response, 'login');
    }

    public function profile(Request $request, Response $response) {
        $currentPassword = htmlspecialchars(trim($request->getParam('currentPassword')));
        $newPassword = htmlspecialchars(trim($request->getParam('newPassword')));

        if(empty($currentPassword) || empty($newPassword)) {
            $this->flash("Un ou plusieurs champs sont vides !", 'error');
        } else {
            $db_password = Admin::select('mdp')->where('id_admin', $_SESSION['id_admin'])->first();

            if(AuthController::verifyPassword($currentPassword, $db_password->password)) {
                $hashedPassword = AuthController::hashPassword($newPassword);
                Admin::where('id_admin', $_SESSION['id_admin'])->update(['mdp' => $hashedPassword]);
                $this->flash("Le mot de passe a bien été sauvegardé !");
            } else {
                $this->flash("Mot de passe actuel incorrect !", 'error');
            }
        }
        return $this->redirect($response, 'profile');
    }


    //MODIFICATION UPDATE
    //MODIFICATION UPDATE
    //MODIFICATION UPDATE
    //MODIFICATION UPDATE

    public function adminUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_admin');
        $nom = htmlspecialchars(trim($request->getParam('nom')));
        $mail = htmlspecialchars(trim($request->getParam('mail')));
        $verifUuid = htmlspecialchars(trim($request->getParam('newUuid')));
        $exist = Administrateur::where('id_admin', '=', $id)->count();



        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(!$exist) {
                return "L'utilisateur que vous essayez de modifier n'existe pas !";
            } else {
                if($verifUuid == 1)  {
                    Administrateur::where('id_admin', '=', $id)->update(['nom' => $nom, 'mail' => $mail]);
                } else {
                    Administrateur::where('id_admin', '=', $id)->update(['nom' => $nom, 'mail' => $mail]);
                }
                return "success";

            }
        }

    }

    public function particulierUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_utilisateur');
        $mail = htmlspecialchars(trim($request->getParam('mail')));
        $pays = htmlspecialchars(trim($request->getParam('pays')));
        $code_postal = htmlspecialchars(trim($request->getParam('code_postal')));
        $ville = htmlspecialchars(trim($request->getParam('ville')));
        $adresse = htmlspecialchars(trim($request->getParam('adresse')));
        $comp_adresse = htmlspecialchars(trim($request->getParam('comp_adresse')));
        $telephone_fixe = htmlspecialchars(trim($request->getParam('telephone_fixe')));
        $telephone_mobile = htmlspecialchars(trim($request->getParam('telephone_mobile')));
        $verifUuid = htmlspecialchars(trim($request->getParam('newUuid')));

        $exist = Utilisateur::where('id_utilisateur', '=', $id)->count();

        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(!$exist) {
                return "Le particulier que vous essayez de modifier n'existe pas !";
            } else {
                if($verifUuid == 1)  {
                    Utilisateur::where('id_utilisateur', '=', $id)->update(['mail' => $mail, 'pays' => $pays, 'code_postal' => $code_postal, 'ville' => $ville, 'adresse' => $adresse, 'comp_adresse' => $comp_adresse, 'telephone_fixe' => $telephone_fixe, 'telephone_mobile' => $telephone_mobile]);
                } else {
                    Utilisateur::where('id_utilisateur', '=', $id)->update(['mail' => $mail, 'pays' => $pays, 'code_postal' => $code_postal, 'ville' => $ville, 'adresse' => $adresse, 'comp_adresse' => $comp_adresse, 'telephone_fixe' => $telephone_fixe, 'telephone_mobile' => $telephone_mobile]);

                }
                return "success";

            }
        }

    }

    public function entrepriseUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_utilisateur');
        $mail = htmlspecialchars(trim($request->getParam('mail')));
        $pays = htmlspecialchars(trim($request->getParam('pays')));
        $code_postal = htmlspecialchars(trim($request->getParam('code_postal')));
        $ville = htmlspecialchars(trim($request->getParam('ville')));
        $adresse = htmlspecialchars(trim($request->getParam('adresse')));
        $comp_adresse = htmlspecialchars(trim($request->getParam('comp_adresse')));
        $telephone_fixe = htmlspecialchars(trim($request->getParam('telephone_fixe')));
        $telephone_mobile = htmlspecialchars(trim($request->getParam('telephone_mobile')));
        $verifUuid = htmlspecialchars(trim($request->getParam('newUuid')));

        $exist = Utilisateur::where('id_utilisateur', '=', $id)->count();

        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(!$exist) {
                return "L'entreprise que vous essayez de modifier n'existe pas !";
            } else {
                if($verifUuid == 1)  {
                    Utilisateur::where('id_utilisateur', '=', $id)->update(['mail' => $mail, 'pays' => $pays, 'code_postal' => $code_postal, 'ville' => $ville, 'adresse' => $adresse, 'comp_adresse' => $comp_adresse, 'telephone_fixe' => $telephone_fixe, 'telephone_mobile' => $telephone_mobile]);
                } else {
                    Utilisateur::where('id_utilisateur', '=', $id)->update(['mail' => $mail, 'pays' => $pays, 'code_postal' => $code_postal, 'ville' => $ville, 'adresse' => $adresse, 'comp_adresse' => $comp_adresse, 'telephone_fixe' => $telephone_fixe, 'telephone_mobile' => $telephone_mobile]);

                }
                return "success";

            }
        }

    }

    public function faqUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_faq');
        $question = htmlspecialchars(trim($request->getParam('question')));
        $reponse = htmlspecialchars(trim($request->getParam('reponse')));
        $introduction = htmlspecialchars(trim($request->getParam('introduction')));

        $exist = Faq::where('id_faq', '=', $id)->count();

        if(!$exist) {
            return "Le FAQ que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Faq::where('id_faq', '=', $id)->update(['question' => $question, 'reponse' => $reponse, 'introduction' => $introduction]);
            } else {
                Faq::where('id_faq', '=', $id)->update(['question' => $question, 'reponse' => $reponse, 'introduction' => $introduction]);


            }
            return "success";

        }

    }

    public function conversationUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_conversation');
        $titre = htmlspecialchars(trim($request->getParam('titre')));
        $verifUuid = htmlspecialchars(trim($request->getParam('newUuid')));

        $exist = Conversation::where('id_conversation', '=', $id)->count();

        if(!$exist) {
            return "La conversation que vous essayez de modifier n'existe pas !";
        } else {
            if($verifUuid == 1)  {
                Conversation::where('id_conversation', '=', $id)->update(['titre' => $titre]);
            } else {
                Conversation::where('id_conversation', '=', $id)->update(['titre' => $titre]);
            }
            return "success";

        }

    }

    public function venteUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_vente');
        $titre = htmlspecialchars(trim($request->getParam('titre')));
        $description = htmlspecialchars(trim($request->getParam('description')));
        $date = "06/13/2019 5:35 PM";
        $sec = strtotime($request->getParam('date_debut'));
        $newdate = date ("Y/m/d H:i", $sec);
        $newdate = $newdate . ":00";
        $date_debut = $newdate;
        $sec2 = strtotime($request->getParam('date_fin'));
        $newdate2 = date ("Y/m/d H:i", $sec2);
        $newdate2 = $newdate2 . ":00";
        $date_fin = $newdate2;
        $id_voiture = $request->getParam('id_voiture');
        $verifUuid = htmlspecialchars(trim($request->getParam('newUuid')));

        $exist = Vente::where('id_vente', '=', $id)->count();

        if(!$exist) {
            return "L'enchère que vous essayez de modifier n'existe pas !";
        } else {
            if($verifUuid == 1)  {
                Vente::where('id_vente', '=', $id)->update(['titre' => $titre, 'description' => $description, 'date_debut' => $date_debut, 'date_fin' => $date_fin, 'id_voiture' => $id_voiture]);
            } else {
                Vente::where('id_vente', '=', $id)->update(['titre' => $titre, 'description' => $description, 'date_debut' => $date_debut, 'date_fin' => $date_fin, 'id_voiture' => $id_voiture]);
            }
            return "success";

        }

    }

    public function mentionPageUpdate(Request $request, Response $response) {
        $titre_page = htmlspecialchars(trim($request->getParam('titre_page')));
        $text = htmlspecialchars(trim($request->getParam('text')));
        try{
            $mention_page = Mention_legale_page::select()->first();
            $mention_page->titre_page = $titre_page;
            $mention_page->text = $text;
            $mention_page->save();
            return "success";
        }catch(\Exception $e){
            return "Une erreur a été rencontré, il est impossible de modifier la page mention. {$e}";
        }
    }

    public function guidePageUpdate(Request $request, Response $response) {
        $titre_page = htmlspecialchars(trim($request->getParam('titre_page')));
        $text = htmlspecialchars(trim($request->getParam('text')));
        try{
            $guide_page = Guide_page::select()->first();
            $guide_page->titre_page = $titre_page;
            $guide_page->text = $text;
            $guide_page->save();
            return "success";
        }catch(\Exception $e){
            return "Une erreur a été rencontré, il est impossible de modifier la page guide. {$e}";
        }
    }

    public function informationSiteUpdate(Request $request, Response $response) {
        $nom = htmlspecialchars(trim($request->getParam('nom')));
        $prix_entrer_vente = htmlspecialchars(trim($request->getParam('prix_entrer_vente')));
        $mail = htmlspecialchars(trim($request->getParam('mail')));
        $numero_tel = htmlspecialchars(trim($request->getParam('numero_tel')));
        $horaire_hotline = htmlspecialchars(trim($request->getParam('horaire_hotline')));
        $code_postale_agence = htmlspecialchars(trim($request->getParam('code_postale_agence')));
        $ville_agence = htmlspecialchars(trim($request->getParam('ville_agence')));
        $adresse_agence = htmlspecialchars(trim($request->getParam('adresse_agence')));
        $comp_adresse_agence = htmlspecialchars(trim($request->getParam('comp_adresse_agence')));
        $lien_youtube = htmlspecialchars(trim($request->getParam('lien_youtube')));
        $lien_instagram = htmlspecialchars(trim($request->getParam('lien_instagram')));
        $lien_facebook = htmlspecialchars(trim($request->getParam('lien_facebook')));
        $lien_twitter = htmlspecialchars(trim($request->getParam('lien_twitter')));

        try{
            $information_site = Information_site::select()->first();
            $information_site->nom = $nom;
            $information_site->prix_entrer_vente = $prix_entrer_vente;
            $information_site->mail = $mail;
            $information_site->numero_tel = $numero_tel;
            $information_site->horaire_hotline = $horaire_hotline;
            $information_site->code_postale_agence = $code_postale_agence;
            $information_site->ville_agence = $ville_agence;
            $information_site->adresse_agence = $adresse_agence;
            $information_site->comp_adresse_agence = $comp_adresse_agence;
            $information_site->lien_youtube = $lien_youtube;
            $information_site->lien_instagram = $lien_instagram;
            $information_site->lien_facebook = $lien_facebook;
            $information_site->lien_twitter = $lien_twitter;
            $information_site->save();
            return "success";
        }catch(\Exception $e){
            return "Une erreur a été rencontré, il est impossible de modifier la page guide. {$e}";
        }


    }

    public function marqueUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_marque');
        $nom = htmlspecialchars(trim($request->getParam('nom')));
        $lien = htmlspecialchars(trim($request->getParam('lien')));
        $exist = Marque::where('id_marque', '=', $id)->count();

        if(!$exist) {
            return "La marque que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Marque::where('id_marque', '=', $id)->update(['nom' => $nom, 'lien' => $lien]);
            } else {
                Marque::where('id_marque', '=', $id)->update(['nom' => $nom, 'lien' => $lien]);
            }
            return "success";
        }
    }

    public function categorieUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_categorie');
        $libelle = htmlspecialchars(trim($request->getParam('libelle')));
        $exist = Categorie::where('id_categorie', '=', $id)->count();

        if(!$exist) {
            return "La categorie que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Categorie::where('id_categorie', '=', $id)->update(['libelle' => $libelle]);
            } else {
                Categorie::where('id_categorie', '=', $id)->update(['libelle' => $libelle]);

            }
            return "success";
        }
    }

    public function categoriePhotoUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_categorie_photo');
        $libelle = htmlspecialchars(trim($request->getParam('libelle')));
        $exist = Categorie_photo::where('id_categorie_photo', '=', $id)->count();

        if(!$exist) {
            return "La categorie de photo que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Categorie_photo::where('id_categorie_photo', '=', $id)->update(['libelle' => $libelle]);
            } else {
                Categorie_photo::where('id_categorie_photo', '=', $id)->update(['libelle' => $libelle]);

            }
            return "success";
        }
    }

    public function optionUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_option');
        $libelle = htmlspecialchars(trim($request->getParam('libelle')));
        $exist = Option::where('id_option', '=', $id)->count();

        if(!$exist) {
            return "La option que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Option::where('id_option', '=', $id)->update(['libelle' => $libelle]);
            } else {
                Option::where('id_option', '=', $id)->update(['libelle' => $libelle]);

            }
            return "success";
        }
    }

    public function representationUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_representation');
        $lien = htmlspecialchars(trim($request->getParam('lien')));
        $exist = Representation_voiture::where('id_representation', '=', $id)->count();

        if(!$exist) {
            return "La representation que vous essayez de modifier n'existe pas !";
        } else {
            if($id == 1)  {
                Representation_voiture::where('id_representation', '=', $id)->update(['lien' => $lien]);
            } else {
                Representation_voiture::where('id_representation', '=', $id)->update(['lien' => $lien]);

            }
            return "success";
        }
    }

    public function voitureUpdate(Request $request, Response $response) {
        $id = $request->getParam('id_voiture');
        $id_marque = $request->getParam('id_marque');
        $id_categorie = $request->getParam('id_categorie');
        $modele = htmlspecialchars(trim($request->getParam('modele')));
        $description = htmlspecialchars(trim($request->getParam('description')));
        $prix_argus = htmlspecialchars(trim($request->getParam('prix_argus')));
        $couleur = htmlspecialchars(trim($request->getParam('couleur')));
        $kilometrage = htmlspecialchars(trim($request->getParam('kilometrage')));
        $puissance = htmlspecialchars(trim($request->getParam('puissance')));
        $energie = htmlspecialchars(trim($request->getParam('energie')));
        $annee = htmlspecialchars(trim($request->getParam('annee')));
        $transmission = htmlspecialchars(trim($request->getParam('transmission')));
        $date = "06/13/2019 5:35 PM";
        $sec = strtotime($request->getParam('mise_en_circulation'));
        $newdate = date ("Y/m/d H:i", $sec);
        $newdate = $newdate . ":00";
        $mise_en_circulation = $newdate;
        $numero_identification = htmlspecialchars(trim($request->getParam('numero_identification')));
        $co2 = htmlspecialchars(trim($request->getParam('co2')));
        $nombre_de_cle = htmlspecialchars(trim($request->getParam('nombre_de_cle')));
        $nombre_siege = htmlspecialchars(trim($request->getParam('nombre_siege')));
        $nombre_porte = htmlspecialchars(trim($request->getParam('nombre_porte')));
        $bruit_moteur = htmlspecialchars(trim($request->getParam('bruit_moteur')));
        $nombre_proprietaire = htmlspecialchars(trim($request->getParam('nombre_proprietaire')));
        $moteur = htmlspecialchars(trim($request->getParam('moteur')));
        $description_interieur = htmlspecialchars(trim($request->getParam('description_interieur')));
        $exist = Voiture::where('id_voiture', '=', $id)->count();




            if(!$exist) {
                return "La voiture que vous essayez de modifier n'existe pas !";
            } else {
                if($id == 1)  {
                    Voiture::where('id_voiture', '=', $id)->update(['modele' => $modele, 'description' => $description, 'prix_argus' => $prix_argus, 'couleur' => $couleur, 'kilometrage' => $kilometrage,
                     'puissance' => $puissance, 'energie' => $energie, 'annee' => $annee, 'transmission' => $transmission, 'mise_en_circulation' => $mise_en_circulation, 'numero_identification' => $numero_identification, 'co2' => $co2,
                     'nombre_de_cle' => $nombre_de_cle, 'nombre_siege' => $nombre_siege, 'nombre_porte' => $nombre_porte, 'bruit_moteur' => $bruit_moteur, 'nombre_proprietaire' => $nombre_proprietaire,
                     'moteur' => $moteur, 'description_interieur' => $description_interieur, 'id_marque' => $id_marque, 'id_categorie' => $id_categorie]);
                } else {
                    Voiture::where('id_voiture', '=', $id)->update(['modele' => $modele, 'description' => $description, 'prix_argus' => $prix_argus, 'couleur' => $couleur, 'kilometrage' => $kilometrage,
                     'puissance' => $puissance, 'energie' => $energie, 'annee' => $annee, 'transmission' => $transmission, 'mise_en_circulation' => $mise_en_circulation, 'numero_identification' => $numero_identification, 'co2' => $co2,
                     'nombre_de_cle' => $nombre_de_cle, 'nombre_siege' => $nombre_siege, 'nombre_porte' => $nombre_porte, 'bruit_moteur' => $bruit_moteur, 'nombre_proprietaire' => $nombre_proprietaire,
                     'moteur' => $moteur, 'description_interieur' => $description_interieur, 'id_marque' => $id_marque, 'id_categorie' => $id_categorie]);
                }
                return "success";

            }
        }



    //FIN MODIFICATION UPDATE
    //FIN MODIFICATION UPDATE
    //FIN MODIFICATION UPDATE
    //FIN MODIFICATION UPDATE

    //SUPPRESSION DELETE
    //SUPPRESSION DELETE
    //SUPPRESSION DELETE
    //SUPPRESSION DELETE


    public function conversationDelete(Request $request, Response $response) {
        $id = $request->getParam('id_conversation');
        $exist = Conversation::where('id_conversation', '=', $id)->count();

        if(!$exist) {
            return "La conversation que vous essayez de supprimer n'existe pas !";
        } else {
            Conversation::where('id_conversation', $id)->delete();
            return "success";
        }
    }

    public function venteDelete(Request $request, Response $response) {
        $id = $request->getParam('id_vente');
        $exist = Vente::where('id_vente', '=', $id)->count();

        if(!$exist) {
            return "L'enchère que vous essayez de supprimer n'existe pas !";
        } else {
            Vente::where('id_vente', $id)->delete();
            return "success";
        }
    }

    public function adminDelete(Request $request, Response $response) {
        $id = $request->getParam('id_admin');
        $exist = Administrateur::where('id_admin', '=', $id)->count();

        if(!$exist) {
            return "L'adminstrateur que vous essayez de supprimer n'existe pas !";
        } else {
            Administrateur::where('id_admin', $id)->delete();
            return "success";
        }
    }

    public function faqDelete(Request $request, Response $response) {
        $id = $request->getParam('id_faq');
        $exist = Faq::where('id_faq', '=', $id)->count();

        if(!$exist) {
            return "L'Faq que vous essayez de supprimer n'existe pas !";
        } else {
            Faq::where('id_faq', $id)->delete();
            return "success";
        }
    }

    public function entrepriseDelete(Request $request, Response $response) {
        $id = $request->getParam('id_utilisateur');
        $exist = Utilisateur::where('id_utilisateur', '=', $id)->count();

        if(!$exist) {
            return "L'entreprise que vous essayez de supprimer n'existe pas !";
        } else {
            Utilisateur::where('id_utilisateur', $id)->delete();
            return "success";
        }
    }

    public function particulierDelete(Request $request, Response $response) {
        $id = $request->getParam('id_utilisateur');
        $exist = Utilisateur::where('id_utilisateur', '=', $id)->count();

         if(!$exist) {
            return "Le particulier que vous essayez de supprimer n'existe pas !";
           } else {
               Utilisateur::where('id_utilisateur', $id)->delete();
               return "success";
           }

    }

    public function marqueDelete(Request $request, Response $response) {
        $id = $request->getParam('id_marque');
        $exist = Marque::where('id_marque', '=', $id)->count();

        if(!$exist) {
            return "La marque que vous essayez de supprimer n'existe pas !";
        } else {
            Marque::where('id_marque', $id)->delete();
            return "success";
        }
    }

    public function categorieDelete(Request $request, Response $response) {
        $id = $request->getParam('id_categorie');
        $exist = Categorie::where('id_categorie', '=', $id)->count();

        if(!$exist) {
            return "La categorie que vous essayez de supprimer n'existe pas !";
        } else {
            Categorie::where('id_categorie', $id)->delete();
            return "success";
        }
    }

    public function categoriePhotoDelete(Request $request, Response $response) {
        $id = $request->getParam('id_categorie_photo');
        $exist = Categorie_photo::where('id_categorie_photo', '=', $id)->count();

        if(!$exist) {
            return "La categorie que vous essayez de supprimer n'existe pas !";
        } else {
            Categorie_photo::where('id_categorie_photo', $id)->delete();
            return "success";
        }
    }

    public function optionDelete(Request $request, Response $response) {
        $id = $request->getParam('id_option');
        $exist = Option::where('id_option', '=', $id)->count();

        if(!$exist) {
            return "L'option que vous essayez de supprimer n'existe pas !";
        } else {
            Option::where('id_option', $id)->delete();
            return "success";
        }
    }

    public function representationDelete(Request $request, Response $response) {
        $id = $request->getParam('id_representation');
        $exist = Representation_voiture::where('id_representation', '=', $id)->count();

        if(!$exist) {
            return "La representation que vous essayez de supprimer n'existe pas !";
        } else {
            Representation_voiture::where('id_representation', $id)->delete();
            return "success";
        }
    }

    public function voitureDelete(Request $request, Response $response) {
        $id = $request->getParam('id_voiture');
        $exist = Voiture::where('id_voiture', '=', $id)->count();

        if(!$exist) {
            return "La voiture que vous essayez de supprimer n'existe pas !";
        } else {
            Vente::where('id_voiture', $id)->delete();
            return "success";
        }
    }


    //FIN SUPPRESSION DELETE
    //FIN SUPPRESSION DELETE
    //FIN SUPPRESSION DELETE
    //FIN SUPPRESSION DELETE

    //CREATION CREATE
    //CREATION CREATE
    //CREATION CREATE
    //CREATION CREATE

    public function createAdmin(Request $request, Response $response) {
        $uuid_vente = htmlspecialchars(trim($request->getParam('uuid_vente')));
        $nom_admin = htmlspecialchars(trim($request->getParam('nom_admin')));
        $mail_admin = htmlspecialchars(trim($request->getParam('mail_admin')));
        $password_admin = htmlspecialchars(trim($request->getParam('mdp_admin')));
        $super_admin =htmlspecialchars(trim($request->getParam('super_admin')));
        $uuid = Token::generate_uuid(Administrateur::class);

        if(!filter_var($mail_admin, FILTER_VALIDATE_EMAIL)) {
            $this->flash('Cette adresse email est invalide !', 'error');
        } else {
            if(empty($nom_admin || $mail_admin || $password_admin)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                $exist = Administrateur::where('mail', '=', $mail_admin)->count();
                if($exist) {
                    $this->flash('Cette adresse e-mail est déjà utilisée !', 'error');
                } else {
                    $password_hash = AuthController::hashPassword($password_admin);
                    Administrateur::insert(['uuid' => $uuid, 'nom' => $nom_admin, 'mail' => $mail_admin, 'mdp' => $password_hash, 'super_admin' => $super_admin]);
                    $this->flash("L'utilisateur a été créé avec succès !");
                }
            }
        }
        return $this->redirect($response, 'createAdmin');
    }

    public function createVente(Request $request, Response $response) {
        $id_voiture = $request->getParam('id_voiture');
        $id_vignette = $request->getParam('id_vignette');
        $uuid_vente = htmlspecialchars(trim($request->getParam('uuid_vente')));
        $titre_vente = htmlspecialchars(trim($request->getParam('titre_vente')));

        $sec = strtotime($request->getParam('date_debut'));
        $newdate = date ("Y/m/d H:i", $sec);
        $newdate = $newdate . ":00";
        $date_debut = $newdate;

        $sec2 = strtotime($request->getParam('date_fin'));
        $newdate2 = date ("Y/m/d H:i", $sec2);
        $newdate2 = $newdate2 . ":00";
        $date_fin = $newdate2;

        $id_admin = $_SESSION['id_admin'];
        $prix_vente = (null != $request->getParam('prix_vente')) ? htmlspecialchars(trim($request->getParam('prix_vente'))) : null;

        if(empty($titre_vente) || null == $request->getParam('prix_vente') || empty($date_debut) || empty($date_fin) || empty($id_voiture) || empty($id_vignette)) {
          $this->flash('Veuillez renseigner tous les champs !', 'error');
        } else {
          $uuid = Token::generate_uuid(Administrateur::class);

          $vente = new Vente();
          $vente->id_admin = $id_admin;
          $vente->uuid = $uuid;
          $vente->titre = $titre_vente;
          $vente->prix = $prix_vente;
          $vente->date_debut = $date_debut;
          $vente->date_fin = $date_fin;
          $vente->id_voiture = $id_voiture;
          $vente->photo_thumbnail = $id_vignette;
          $vente->save();

          $voiture = Voiture::find($id_voiture);
          $voiture->id_vente = $vente->id_vente;
          $voiture->save();
          $this->flash("L'enchère a été créé avec succès !");
        }
        return $this->redirect($response, 'createVente');
    }

    public function createFaq(Request $request, Response $response) {
        $question_faq = htmlspecialchars(trim($request->getParam('question_faq')));
        $reponse_faq = htmlspecialchars(trim($request->getParam('reponse_faq')));
        $introduction_faq = htmlspecialchars(trim($request->getParam('introduction_faq')));
        $id_admin = $_SESSION['id_admin'];

            if(empty($question_faq || $reponse_faq || $introduction_faq)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                    Faq::insert(['id_admin' => $id_admin, 'question' => $question_faq, 'reponse' => $reponse_faq, 'introduction' => $introduction_faq]);
                    $this->flash("L'Faq a été créé avec succès !");
                }

            return $this->redirect($response, 'createFaq');
    }

    public function createMarque(Request $request, Response $response) {
        $nom = htmlspecialchars(trim($request->getParam('nom')));
        $lien = htmlspecialchars(trim($request->getParam('lien')));

            if(empty($nom) || empty($lien)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                    Marque::insert(['nom' => $nom, 'lien' => $lien]);
                    $this->flash("La marque a été créé avec succès !");
                }

            return $this->redirect($response, 'createMarque');
    }

    public function createCategorie(Request $request, Response $response) {
        $libelle = htmlspecialchars(trim($request->getParam('libelle')));

            if(empty($libelle)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                    Categorie::insert(['libelle' => $libelle]);
                    $this->flash("La categorie a été créé avec succès !");
                }

            return $this->redirect($response, 'createCategorie');
    }

    public function createOption(Request $request, Response $response) {
        $libelle = htmlspecialchars(trim($request->getParam('libelle')));

            if(empty($libelle)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                    Option::insert(['libelle' => $libelle]);
                    $this->flash("La option a été créé avec succès !");
                }

            return $this->redirect($response, 'createOption');
    }

    public function createRepresentation(Request $request, Response $response) {
        $lien = htmlspecialchars(trim($request->getParam('lien')));

            if(empty($lien)) {
                $this->flash('Veuillez renseigner tous les champs !', 'error');
            } else {
                    Representation_voiture::insert(['lien' => $lien]);
                    $this->flash("La representation a été créé avec succès !");
                }

            return $this->redirect($response, 'createRepresentation');
    }


    public function createVoiture(Request $request, Response $response) {
        $id_marque = $request->getParam('id_marque');
        $id_categorie = $request->getParam('id_categorie');

        $modele = htmlspecialchars(trim($request->getParam('modele')));
        $description = htmlspecialchars(trim($request->getParam('description')));
        $prix_argus = htmlspecialchars(trim($request->getParam('prix_argus')));
        $couleur = htmlspecialchars(trim($request->getParam('couleur')));
        $kilometrage = htmlspecialchars(trim($request->getParam('kilometrage')));
        $puissance = htmlspecialchars(trim($request->getParam('puissance')));
        $energie = htmlspecialchars(trim($request->getParam('energie')));
        $annee = htmlspecialchars(trim($request->getParam('annee')));
        $transmission = htmlspecialchars(trim($request->getParam('transmission')));
        $date = "06/13/2019 5:35 PM";
        $sec = strtotime($request->getParam('mise_en_circulation'));
        $newdate = date ("Y/m/d H:i", $sec);
        $newdate = $newdate . ":00";
        $mise_en_circulation = $newdate;
        $numero_identification = htmlspecialchars(trim($request->getParam('numero_identification')));
        $co2 = htmlspecialchars(trim($request->getParam('co2')));
        $nombre_de_cle = htmlspecialchars(trim($request->getParam('nombre_de_cle')));
        $nombre_siege = htmlspecialchars(trim($request->getParam('nombre_siege')));
        $nombre_porte = htmlspecialchars(trim($request->getParam('nombre_porte')));
        $bruit_moteur = htmlspecialchars(trim($request->getParam('bruit_moteur')));
        $video_voiture = htmlspecialchars(trim($request->getParam('video_voiture')));
        $nombre_proprietaire = htmlspecialchars(trim($request->getParam('nombre_proprietaire')));
        $moteur = htmlspecialchars(trim($request->getParam('moteur')));
        $description_interieur = htmlspecialchars(trim($request->getParam('description_interieur')));
        // $titre = htmlspecialchars(trim($request->getParam('titre')));
        // $description_photo = htmlspecialchars(trim($request->getParam('description_photo')));
        // $lien = htmlspecialchars(trim($request->getParam('lien')));



        if(empty($modele || $description || $prix_argus || $couleur || $kilometrage || $puissance || $energie || $annee ||
        $transmission || $mise_en_circulation || $numero_identification || $co2 || $nombre_de_cle || $nombre_siege
        || $nombre_porte || $nombre_proprietaire || $moteur || $description_interieur || $id_marque || $id_categorie)) {
            $this->flash('Veuillez renseigner tous les champs !', 'error');
        }
        else {
          $target_dir = "../../shared_pic/";
          //$target_dir = "/var/www/public/uploads/";

          if($_FILES["bruit_moteur"]["size"] == 0 || $_FILES["bruit_moteur"]["name"] == '')
            $_FILES["bruit_moteur"] = null;
          if($_FILES["video_voiture"]["size"] == 0 || $_FILES["video_voiture"]["name"] == '')
            $_FILES["video_voiture"] = null;

          if($_FILES["bruit_moteur"] != null){
            $file_bruit_moteur = $_FILES["bruit_moteur"];
            $extension_bruit_moteur_file = pathinfo($file_bruit_moteur['name'], PATHINFO_EXTENSION);
            if($extension_bruit_moteur_file != null && $extension_bruit_moteur_file != '')
              $uniqName_bruit_moteur = Token::generate_random_name(Voiture::class, 'bruit_moteur') . '.' . $extension_bruit_moteur_file;
            else
              $uniqName_bruit_moteur = Token::generate_random_name(Voiture::class, 'bruit_moteur');

            $target_file_bruit_moteur = $target_dir . 'bruits_moteur/' . $uniqName_bruit_moteur;

            $bruit_moteur_checker = FileChecker::checkFile($file_bruit_moteur, $target_file_bruit_moteur, ["audio/mpeg", "audio/ogg", "audio/midi", "audio/webm", "audio/wav"], 500000);
          }else{
            $bruit_moteur_checker = true;
            $uniqName_bruit_moteur = null;
          }

          if($_FILES["video_voiture"] != null){
            $file_video_voiture = $_FILES["video_voiture"];
            $extension_video_voiture_file = pathinfo($file_video_voiture['name'], PATHINFO_EXTENSION);
            if($extension_video_voiture_file != null && $extension_video_voiture_file != '')
              $uniqName_video_voiture = Token::generate_random_name(Voiture::class, 'video') . '.' . $extension_video_voiture_file;
            else
              $uniqName_video_voiture = Token::generate_random_name(Voiture::class, 'video');

            $target_file_video_voiture = $target_dir . 'videos/' . $uniqName_video_voiture;

            $video_voiture_checker = FileChecker::checkFile($file_bruit_moteur, $target_file_video_voiture, ["video/webm", "video/ogg", "video/mp4", "video/x-m4v"], 1000000);
          }else{
            $video_voiture_checker = true;
            $uniqName_video_voiture = null;
          }

          //Garder que les fichiers correctes + reformulation le tableau (seul le nom du fichier et vérifier)
          $file_photos_voiture = $_FILES["photo_voiture"];
          $count_array_photos = sizeof($file_photos_voiture['name']);
          $array_valid_photos = [];
          for ($i = 0; $i < $count_array_photos; $i++) {
            if(($file_photos_voiture['error'][$i] == 0) && ($file_photos_voiture['name'][$i] != '' && $file_photos_voiture['name'][$i] != null)){
              $extension = pathinfo($file_photos_voiture['name'][$i], PATHINFO_EXTENSION);
              if($extension != null && $extension != '')
                $uniqName = Token::generate_random_name(Photo_voiture::class, 'lien') . '.' . $extension;
              else
                $uniqName = Token::generate_random_name(Photo_voiture::class, 'lien');
              $photo_target_file = $target_dir . 'photos/' . $uniqName;
              $arr = [
                'name' => $file_photos_voiture['name'][$i],
                'type' => $file_photos_voiture['type'][$i],
                'tmp_name' => $file_photos_voiture['tmp_name'][$i],
                'error' => $file_photos_voiture['error'][$i],
                'size' => $file_photos_voiture['size'][$i],
                'uniq_name' => $uniqName,
                'target_file' => $photo_target_file
              ];
              array_push($array_valid_photos, $arr);
            }
          }

          //Vérification des images
          //Type authorisées: format MIME
          $errorPhotosFile = false;
          foreach ($array_valid_photos as $photo_file) {
            if(!FileChecker::checkFile($photo_file, $photo_file['name'], ["image/png", "image/jpeg", "image/svg+xml"], 1000000)){
              $errorPhotosFile = true;
              $this->flash("Une image n'est pas correcte (pas dans le bon format ou invalide) !");
              return $this->redirect($response, 'createVoiture');
            }
          }

          if($bruit_moteur_checker && $video_voiture_checker && !$errorPhotosFile){
            $fileNotUploadCount = 0;

            $new_voiture = new Voiture();
            $new_voiture->modele = $modele;
            $new_voiture->description = $description;
            $new_voiture->prix_argus = $prix_argus;
            $new_voiture->couleur = $couleur;
            $new_voiture->kilometrage = $kilometrage;
            $new_voiture->puissance = $puissance;
            $new_voiture->energie = $energie;
            $new_voiture->annee = $annee;
            $new_voiture->transmission = $transmission;
            $new_voiture->mise_en_circulation = $mise_en_circulation;
            $new_voiture->numero_identification = $numero_identification;
            $new_voiture->co2 = $co2;
            $new_voiture->description = $description;
            $new_voiture->nombre_de_cle = $nombre_de_cle;
            $new_voiture->nombre_siege = $nombre_siege;
            $new_voiture->nombre_porte = $nombre_porte;
            $new_voiture->bruit_moteur = $uniqName_bruit_moteur;
            $new_voiture->video = $uniqName_video_voiture;
            $new_voiture->moteur = $moteur;
            $new_voiture->nombre_proprietaire = $nombre_proprietaire;
            $new_voiture->description_interieur = $description_interieur;
            $new_voiture->id_marque = $id_marque;
            $new_voiture->id_categorie = $id_categorie;
            $new_voiture->save();

            foreach ($array_valid_photos as $photo_file) {
              if(move_uploaded_file($photo_file["tmp_name"], $photo_file["target_file"])) {
                $file_name = $photo_file["name"];
                $file_size = $photo_file["size"];

                //GET TITLE
                $titleParam = 'title_' . pathinfo($file_name, PATHINFO_FILENAME) . '_SIZE_' . $file_size;
                $title = $request->getParam($titleParam);
                //GET DESC
                $descParam = 'desc_' . pathinfo($file_name, PATHINFO_FILENAME) . '_SIZE_' . $file_size;
                $desc = $request->getParam($descParam);
                //GET CAT PHOTO
                $catPhotoParam = 'catPhoto_' . pathinfo($file_name, PATHINFO_FILENAME) . '_SIZE_' . $file_size;
                $catPhoto = $request->getParam($catPhotoParam);

                $new_photo = new Photo_voiture();
                $new_photo->titre = $title;
                $new_photo->description = $desc;
                $new_photo->lien = $photo_file["uniq_name"];
                $new_photo->id_voiture = $new_voiture->id_voiture;
                $new_photo->id_categorie_photo = $catPhoto;
                $new_photo->save();
              }else{
                $fileNotUploadCount++;
              }
            }
            if($_FILES["bruit_moteur"] != null && !move_uploaded_file($_FILES["bruit_moteur"]["tmp_name"], $target_file_bruit_moteur)) {
              $fileNotUploadCount++;
            }

            if($_FILES["video_voiture"] != null && !move_uploaded_file($_FILES["video_voiture"]["tmp_name"], $target_file_video_voiture)) {
              $fileNotUploadCount++;
            }

            if($fileNotUploadCount === 0)
              $this->flash("La voiture a été créée avec succès !");
            else
              $this->flash("Le véhicule a été sauvegardé , cepandant un ou plusieurs fichiers n'ont pu être sauvegardé.");
          }else{
            $this->flash('Veuillez entrer un/des fichiers valide !', 'error');
          }
        }
        return $this->redirect($response, 'createVoiture');
    }

        public function createCategoriePhoto(Request $request, Response $response) {
            $libelle = htmlspecialchars(trim($request->getParam('libelle')));

                if(empty($libelle)) {
                    $this->flash('Veuillez renseigner tous les champs !', 'error');
                } else {
                        Categorie_photo::insert(['libelle' => $libelle]);
                        $this->flash("La categorie a été créé avec succès !");
                    }

                return $this->redirect($response, 'createCategoriePhoto');
        }




    //FIN CREATION CREATE
    //FIN CREATION CREATE
    //FIN CREATION CREATE
    //FIN CREATION CREATE

}
