<?php
namespace Autoriko\Controllers;

use Autoriko\Utils\Writer;
use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Autoriko\Models\Achat;
use Autoriko\Models\Administrateur;
use Autoriko\Models\Alerte;
use Autoriko\Models\Conversation;
use Autoriko\Models\Vente;
use Autoriko\Models\Offre;
use Autoriko\Models\Entreprise;
use Autoriko\Models\Faq;
use Autoriko\Models\Marque;
use Autoriko\Models\Message;
use Autoriko\Models\Particulier;
use Autoriko\Models\Photo;
use Autoriko\Models\Representant;
use Autoriko\Models\Utilisateur;
use Autoriko\Models\Video;
use Autoriko\Models\Information_site;
use Autoriko\Models\Participation;

class GetController{

  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function getUsers(Request $request, Response $response, $args){

    //récupération des utilisateurs dans la base de données
    $users = Utilisateur::select()->get();

    //création du tableau de retour avec en "count" le nombre d'items (utilisateurs) retourné par la requête
    $array_return = [
      'type'  => 'collection',
      'count' => sizeof($users),
      'users' => []
    ];

    //boucle sur tous les utilisateurs retournés en les ajoutant un par un dans le tableau de retour
    foreach ($users as $user) {
      $table_push = [
        'user' => [
          'uuid' => $user->uuid,
          'firstname' => $user->prenom,
          'lastname' => $user->nom
        ],
        'links' => [
          'self' => [
            'href' => $this->c->get('router')->pathFor('getUser', ["uuid" => $user->uuid])
          ]
        ]
      ];
      if($user->type === 1){
        $entreprise = Entreprise::find($user->id_utilisateur);
        $table_push['user']["entreprise"] = [
          "name_entreprise" => $entreprise->raison_sociale
        ];
      }
      array_push($array_return['users'], $table_push);
    }

    return Writer::json_output($response, 200, $array_return);
  }

  public function getUser(Request $request, Response $response, $args){
    $uuid = $args['uuid'];
    $user = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->first();
    $array_return = [
      'type' => 'ressource',
      'user' => [
        'uuid' => $user->uuid,
        'firstname' => $user->prenom,
        'lastname' => $user->nom,
        'email' => $user->mail
      ],
      'links' => [
        'self' => [
          'href' => $this->c->get('router')->pathFor('getUser', ["uuid" => $user->uuid])
        ]
      ]
    ];
    if($user->type === 1){
      $entreprise = Entreprise::find($user->id_utilisateur);
      $array_return["user"]["entreprise"] = [
        "name_entreprise" => $entreprise->raison_sociale
      ];
    }
    return Writer::json_output($response, 200, $array_return);
  }

  public function getAccount(Request $request, Response $response, $args){
    try{
      $uuid = $request->getAttribute('user_uuid');
      $user = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      $array_return = [
        'type' => 'ressource',
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
          "name_entreprise" => $entreprise->raison_sociale,
          "siren" => $entreprise->siren,
          "number_tva" => $entreprise->numero_tva,
          "kabis" => $entreprise->url_photocopie_kabis
        ];
      }
      return Writer::json_output($response, 200, $array_return);
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }

  public function getAdmins(Request $request, Response $response, $args){
    $admins = Administrateur::select()->get();
    $array_return = [
      'type' => 'collection',
      'count' => sizeof($admins),
      'admins' => []
    ];
    foreach ($admins as $admin) {
      array_push($array_return['admins'], [
        'admin' => [
          'uuid' => $admin->uuid,
          'name' => $admin->nom,
          'email' => $admin->mail
        ],
        'links' => [
          'self' => [
            'href' => $this->c->get('router')->pathFor('getAdmin', ["uuid" => $admin->uuid])
          ]
        ]
      ]);
    }
    return Writer::json_output($response, 200, $array_return);
  }

  public function getAdmin(Request $request, Response $response, $args){
    $uuid = $args['uuid'];
    $admin = Administrateur::where('uuid', 'like', '%' . $uuid . '%')->first();

    $array_return = [
      'type' => 'ressource',
      'admin' => [
        'uuid' => $admin->uuid,
        'name' => $admin->nom,
        'email' => $admin->mail
      ],
      'links' => [
        'self' => [
          'href' => $this->c->get('router')->pathFor('getAdmin', ["uuid" => $admin->uuid])
        ]
      ]
    ];
    return Writer::json_output($response, 200, $array_return);
  }

  public function getAccountVentes(Request $request, Response $response, $args){
    try{
      $uuid = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      $category = (isset($request->getQueryParams()['category']) && filter_var($request->getQueryParams()['category'], FILTER_VALIDATE_INT)) ? $request->getQueryParams()['category'] : null;
      $transmission = (isset($request->getQueryParams()['transmission'])) ? filter_var($request->getQueryParams()['transmission'], FILTER_SANITIZE_STRING) : null;
      $energy = (isset($request->getQueryParams()['energy'])) ? filter_var($request->getQueryParams()['energy'], FILTER_SANITIZE_STRING) : null;

      $ventes = $authenticated->participation_vente();

      if($category != null){
        $ventes = $ventes->whereHas('car', function ($query) use($category) {
          $query->where('id_categorie', '=', $category);
        });
      }
      if(strtolower($transmission) == "manuelle" || strtolower($transmission) == "automatique"){
        $ventes = $ventes->whereHas('car', function ($query) use($transmission) {
          $query->where('transmission', 'like', '%' . $transmission . '%');
        });
      }
      if(strtolower($energy) == "electrique" || strtolower($energy) == "essence" || strtolower($energy) == "diesel"){
        $ventes = $ventes->whereHas('car', function ($query) use($energy) {
          $query->where('energie', 'like', '%' . $energy . '%');
        });
      }

      $ventes = $ventes->get();

      $array_return = [
        'type' => 'collection',
        'count' => sizeof($ventes),
        'ventes' => []
      ];
      foreach ($ventes as $vente) {
        $link_thumbnail_from_db = $vente->photo_thumbnail()->first()->lien;
        if($link_thumbnail_from_db != null && $link_thumbnail_from_db != ""){
          $link_thumbnail = "/shared_pic/photos/";
          $link_thumbnail = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_thumbnail . $link_thumbnail_from_db;
        }
        else
          $link_thumbnail = null;
        if(isset($request->getQueryParams()['withCar'])){
          $car = $vente->car()->first();
          if($car){
            $array_car = [
              'model' => $car->modele,
              'description' => $car->description,
              'interior_description' => $car->description_interieur,
              'argus_price' => $car->prix_argus,
              'color' => $car->couleur,
              'mileage' => $car->kilometrage,
              'power' => $car->puissance,
              'energy' => $car->energie,
              'year' => $car->annee,
              'transmission' => $car->transmission,
              'date_of_first_delivery' => $car->mise_en_circulation,
              'identification_number' => $car->numero_identification,
              'co2' => $car->co2,
              'number_of_key' => $car->nombre_de_cle,
              'number_of_seat' => $car->nombre_siege,
              'number_of_door' => $car->nombre_porte,
              'engine_sound' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/bruits_moteur/" . $car->bruit_moteur,
              'owner_number' => $car->nombre_proprietaire,
              'motor' => $car->moteur,
              'video' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/videos/" . $car->video
            ];
            $car_brand = $car->brand()->first();
            if($car_brand){
              $link_logo_from_db = $car_brand->lien;
              $link_logo = "/shared_pic/marque/";
              $link_logo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_logo . $link_logo_from_db;
              $array_brand['brand'] = [
                'id' => $car_brand->id_marque,
                'name' => $car_brand->nom,
                'logo' => $link_logo
              ];
              $array_car = array_merge($array_car, $array_brand);
              //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
            }
            $car_category = $car->category()->first();
            if($car_category){
              $array_category['category'] = [
                'id' => $car_category->id_categorie,
                'name' => $car_category->libelle
              ];
              $array_car = array_merge($array_car, $array_category);
              //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
            }
          }
        }

        $array_vente = [
          'vente' => [
            'uuid' => $vente->uuid,
            'title' => $vente->titre,
            'link_thumbnail' => $link_thumbnail,
            'price' => $vente->prix,
            'start_date' => $vente->date_debut,
            'end_date' => $vente->date_fin,
            'sold' => (($vente->id_achat) ? true : false)
          ],
          'links' => [
            'self' => [
              'href' => $this->c->get('router')->pathFor('getVente', ["uuid" => $vente->uuid])
            ]
          ]
        ];
        if(isset($car))
          $array_vente['vente']['car'] = $array_car;
        array_push($array_return['ventes'], $array_vente);
      }
      return Writer::json_output($response, 200, $array_return);
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }

  public function getVentes(Request $request, Response $response, $args){
    //TODO VERIFIER LES VALEURS REçU POUR LES FILTRES ETC... vérifier pour size, page, category que c'est bien un nombre par exemple
    //TODO faire un catch car quand il y a une erreur elle n'est pas récupéré pour l'instant
    $size = (isset($request->getQueryParams()['size']) && filter_var($request->getQueryParams()['size'], FILTER_VALIDATE_INT)) ? $request->getQueryParams()['size'] : 10;
    $page = (isset($request->getQueryParams()['page']) && filter_var($request->getQueryParams()['page'], FILTER_VALIDATE_INT)) ? $request->getQueryParams()['page'] : 1;
    $category = (isset($request->getQueryParams()['category']) && filter_var($request->getQueryParams()['category'], FILTER_VALIDATE_INT)) ? $request->getQueryParams()['category'] : null;
    $transmission = (isset($request->getQueryParams()['transmission'])) ? filter_var($request->getQueryParams()['transmission'], FILTER_SANITIZE_STRING) : null;
    $energy = (isset($request->getQueryParams()['energy'])) ? filter_var($request->getQueryParams()['energy'], FILTER_SANITIZE_STRING) : null;

    $offset = $size * ($page - 1);

    $now = date("Y-m-d H:i:s");

    if(isset($request->getQueryParams()['forthcoming']) && $request->getQueryParams()['forthcoming'] == true){
      $ventes = Vente::select()->where('enable', '1')->where('date_debut', '>', $now);
      $count_ventes = Vente::where('enable', '1')->where('date_debut', '>', $now);
    }
    else{
      $ventes = Vente::select()->where('enable', '1')->where('date_debut', '<=', $now)->where(function ($query) use($now) {
        $query->where('date_fin', '>', $now)
              ->orWhereNull('date_fin');
      });
      $count_ventes = Vente::where('enable', '1')->where('date_debut', '<=', $now)->where('date_fin', '>', $now);
    }

    if($category != null){
      $ventes = $ventes->whereHas('car', function ($query) use($category) {
        $query->where('id_categorie', '=', $category);
      });
    }
    if(strtolower($transmission) == "manuelle" || strtolower($transmission) == "automatique"){
      $ventes = $ventes->whereHas('car', function ($query) use($transmission) {
        $query->where('transmission', 'like', '%' . $transmission . '%');
      });
    }
    if(strtolower($energy) == "electrique" || strtolower($energy) == "essence" || strtolower($energy) == "diesel"){
      $ventes = $ventes->whereHas('car', function ($query) use($energy) {
        $query->where('energie', 'like', '%' . $energy . '%');
      });
    }

    $ventes = $ventes->offset($offset)->limit($size)->get();
    $count_ventes = $count_ventes->count();

    $prev_page = ($page - 1 > 0) ? $page - 1 : $page;
    $last_page = ceil($count_ventes / $size);

    $next_page = ($page != $last_page) ? $page + 1 : $page;

    $array_return = [
      'type' => 'collection',
      'count' => sizeof($ventes),
      'ventes' => [],
      'links' => [
        'prev' => [
          'href' => $this->c->get('router')->pathFor('getVentes') . "?page={$prev_page}&size={$size}"
        ],
        'next' => [
          'href' => $this->c->get('router')->pathFor('getVentes') . "?page={$next_page}&size={$size}"
        ],
        'first' => [
          'href' => $this->c->get('router')->pathFor('getVentes') . "?page=1&size={$size}"
        ],
        'last' => [
          'href' => $this->c->get('router')->pathFor('getVentes') . "?page={$last_page}&size={$size}"
        ]
      ]
    ];
    foreach ($ventes as $vente) {
      $link_thumbnail_from_db = $vente->photo_thumbnail()->first()->lien;
      if($link_thumbnail_from_db != null && $link_thumbnail_from_db != ""){
        $link_thumbnail = "/shared_pic/photos/";
        $link_thumbnail = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_thumbnail . $link_thumbnail_from_db;
      }
      else
        $link_thumbnail = null;
      if(isset($request->getQueryParams()['withCar'])){
        $car = $vente->car()->first();
        if($car){
          $array_car = [
            'model' => $car->modele,
            'description' => $car->description,
            'interior_description' => $car->description_interieur,
            'argus_price' => $car->prix_argus,
            'color' => $car->couleur,
            'mileage' => $car->kilometrage,
            'power' => $car->puissance,
            'energy' => $car->energie,
            'year' => $car->annee,
            'transmission' => $car->transmission,
            'date_of_first_delivery' => $car->mise_en_circulation,
            'identification_number' => $car->numero_identification,
            'co2' => $car->co2,
            'number_of_key' => $car->nombre_de_cle,
            'number_of_seat' => $car->nombre_siege,
            'number_of_door' => $car->nombre_porte,
            'engine_sound' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/bruits_moteur/" . $car->bruit_moteur,
            'owner_number' => $car->nombre_proprietaire,
            'motor' => $car->moteur,
            'video' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/videos/" . $car->video
          ];
          $car_brand = $car->brand()->first();
          if($car_brand){
            $link_logo_from_db = $car_brand->lien;
            $link_logo = "/shared_pic/marque/";
            $link_logo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_logo . $link_logo_from_db;
            $array_brand['brand'] = [
              'id' => $car_brand->id_marque,
              'name' => $car_brand->nom,
              'logo' => $link_logo
            ];
            $array_car = array_merge($array_car, $array_brand);
            //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
          }
          $car_category = $car->category()->first();
          if($car_category){
            $array_category['category'] = [
              'id' => $car_category->id_categorie,
              'name' => $car_category->libelle
            ];
            $array_car = array_merge($array_car, $array_category);
            //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
          }
        }
      }

      $array_vente = [
        'vente' => [
          'uuid' => $vente->uuid,
          'title' => $vente->titre,
          'link_thumbnail' => $link_thumbnail,
          'price' => $vente->prix,
          'start_date' => $vente->date_debut,
          'end_date' => $vente->date_fin,
          'sold' => (($vente->id_achat) ? true : false)
        ],
        'links' => [
          'self' => [
            'href' => $this->c->get('router')->pathFor('getVente', ["uuid" => $vente->uuid])
          ]
        ]
      ];
      if(isset($car))
        $array_vente['vente']['car'] = $array_car;
      array_push($array_return['ventes'], $array_vente);
    }
    return Writer::json_output($response, 200, $array_return);
  }

  public function getVente(Request $request, Response $response, $args){
    //TODO FAIRE EN SORTE QUE SEUL UN UTILISATEUR CONNECTE AI ACCES A CES INFORMATIONS
    if(isset($args['uuid']))//TODO faire cette vérification partout dans le code
      $uuid = $args['uuid'] = filter_var($args['uuid'], FILTER_SANITIZE_STRING);
    else
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);

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

    $link_thumbnail_from_db = $vente->photo_thumbnail()->first()->lien;
    if($link_thumbnail_from_db != null && $link_thumbnail_from_db != ""){
      $link_thumbnail = "/shared_pic/photos/";
      $link_thumbnail = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_thumbnail . $link_thumbnail_from_db;
    }
    else
      $link_thumbnail = null;

    try{
      $uuid_user = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid_user . '%')->firstOrFail();
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }

    $participate = false;
    $last_offre_send = false;

    if($authenticated->participation_vente->contains($vente->id_vente)){
      //L'UTILSATEUR CONNECTÉ PARTICIPE A LA VENTE
      $participate = true;
      $offre = Offre::where('id_vente', '=', $vente->id_vente)->where('id_utilisateur', '=', $authenticated->id_utilisateur)->first();
      if($offre){
        $last_offre_send = $offre->montant;
      }
    }

    $array_return = [
      'type' => 'ressource',
      'vente' => [
        'uuid' => $vente->uuid,
        'title' => $vente->titre,
        'link_thumbnail' => $link_thumbnail,
        'price' => $vente->prix,
        'start_date' => $vente->date_debut,
        'end_date' => $vente->date_fin,
        'sold' => (($vente->id_achat) ? true : false),
        'enable' => ($vente->enable == 1) ? true : false,
        'number_offre' => $vente->nombre_offre,
        'user_participate' => $participate,
        'user_last_offre' => $last_offre_send,
        'car' => [
          'brand' => [],
          'category' => [],
          'gallery' => []
        ]
      ],
      'links' => [
        'self' => [
          'href' => $this->c->get('router')->pathFor('getVente', ["uuid" => $vente->uuid])
        ]
      ]
    ];
    if($vente->car()->first()){
      $car = $vente->car()->first();

      $array_return['vente']['car'] = [
          'model' => $car->modele,
          'description' => $car->description,
          'interior_description' => $car->description_interieur,
          'argus_price' => $car->prix_argus,
          'color' => $car->couleur,
          'mileage' => $car->kilometrage,
          'power' => $car->puissance,
          'energy' => $car->energie,
          'year' => $car->annee,
          'transmission' => $car->transmission,
          'date_of_first_delivery' => $car->mise_en_circulation,
          'identification_number' => $car->numero_identification,
          'co2' => $car->co2,
          'number_of_key' => $car->nombre_de_cle,
          'number_of_seat' => $car->nombre_siege,
          'number_of_door' => $car->nombre_porte,
          'engine_sound' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/bruits_moteur/" . $car->bruit_moteur,
          'owner_number' => $car->nombre_proprietaire,
          'motor' => $car->moteur,
          'video' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/videos/" . $car->video
      ];
      $car_brand = $car->brand()->first();
      if($car_brand){
        $link_logo_from_db = $car_brand->lien;
        $link_logo = "/shared_pic/marque/";
        $link_logo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_logo . $link_logo_from_db;
        $array_brand['brand'] = [
          'id' => $car_brand->id_marque,
          'name' => $car_brand->nom,
          'logo' => $link_logo
        ];
        $array_return['vente']['car'] = array_merge($array_return['vente']['car'], $array_brand);
        //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
      }

      $car_category = $car->category()->first();
      if($car_category){
        $array_category['category'] = [
          'id' => $car_category->id_categorie,
          'name' => $car_category->libelle
        ];
        $array_return['vente']['car'] = array_merge($array_return['vente']['car'], $array_category);
        //TODO vérifier que dans tous les GET on utilise bien le merge comme utilisé juste au dessus, car avant ça fonctionnait pas !
      }

      $photos = $car->photos()->get();


      if($photos){
        $array_gallery['gallery'] = [];
        $link_photo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/shared_pic/photos/";

        foreach ($photos as $photo) {
          $category = $photo->categorie_photo()->first();

          $key = array_search($category->id_categorie_photo, array_column($array_gallery['gallery'], 'id'));

          if(false === $key){
            $newCat = [
              'id' => $category->id_categorie_photo,
              'name' => $category->libelle,
              'photos' => []
            ];
            array_push($array_gallery['gallery'], $newCat);
            $key = array_key_last($array_gallery['gallery']);
          }
          $array_photo['photo'] = [
            'id' => $photo->id_photo,
            'title' => $photo->titre,
            'description' => $photo->description,
            'link' => $link_photo . $photo->lien
          ];
          array_push($array_gallery['gallery'][$key]['photos'], $array_photo);
        }
        $array_return['vente']['car'] = array_merge($array_return['vente']['car'], $array_gallery);
      }

    }

    return Writer::json_output($response, 200, $array_return);
  }

  public function getVenteSoft(Request $request, Response $response, $args){
    //TODO FAIRE EN SORTE QUE SEUL UN UTILISATEUR CONNECTE AI ACCES A CES INFORMATIONS
    if(isset($args['uuid']))//TODO faire cette vérification partout dans le code
      $uuid = $args['uuid'] = filter_var($args['uuid'], FILTER_SANITIZE_STRING);
    else
      return Writer::json_error($response, $this->c['return_message']['missing_argument']['code'], $this->c['return_message']['missing_argument']['message']);

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

    try{
      $uuid_user = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid_user . '%')->firstOrFail();
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }

    $participate = false;
    $last_offre_send = false;

    if($authenticated->participation_vente->contains($vente->id_vente)){
      //L'UTILSATEUR CONNECTÉ PARTICIPE A LA VENTE
      $participate = true;
      $offre = Offre::where('id_vente', '=', $vente->id_vente)->where('id_utilisateur', '=', $authenticated->id_utilisateur)->first();
      if($offre){
        $last_offre_send = $offre->montant;
      }
    }

    $array_return = [
      'price' => $vente->prix,
      'enable' => ($vente->enable == 1) ? true : false,
      'number_offre' => $vente->nombre_offre,
      'user_participate' => $participate,
      'user_last_offre' => $last_offre_send
    ];

    return Writer::json_output($response, 200, $array_return);
  }

  public function getSiteInformations(Request $request, Response $response, $args){
    $informations = Information_site::select()->first();

    $array_return = [
      'type' => 'ressource',
      'informations' => [
        'name' => $informations->nom,
        'price_enter_vente' => $informations->prix_entrer_vente,
        'email' => $informations->mail,
        'phone_number' => $informations->numero_tel,
        'schedule_hotline' => $informations->horaire_hotline,
        'zip_agency' => $informations->code_postale_agence,
        'city_agency' => $informations->ville_agence,
        'adress_agency' => $informations->adresse_agence,
        'comp_adress_agency' => $informations->comp_adresse_agence,
        'youtube_link' => $informations->lien_youtube,
        'instagram_link' => $informations->lien_instagram,
        'facebook_link' => $informations->lien_facebook,
        'twitter_link' => $informations->lien_twitter
      ]
    ];
    return Writer::json_output($response, 200, $array_return);
  }

  public function getAccountConversations(Request $request, Response $response, $args){
    try{
      $size = (isset($request->getQueryParams()['size'])) ? $request->getQueryParams()['size'] : 5;
      $page = (isset($request->getQueryParams()['page'])) ? $request->getQueryParams()['page'] : 1;
      $order = (isset($request->getQueryParams()['order'])) ? $request->getQueryParams()['page'] : 'DESC';
      $offset = $size * ($page - 1);

      $uuid = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      $conversations = $authenticated->conversations()->orderBy('id_conversation', $order)->offset($offset)->limit($size)->get();

      $count_conversations = $authenticated->conversations()->count();

      $none_read = $authenticated->conversations()->where('conversation_vu', '0')->count();

      $prev_page = ($page - 1 > 0) ? $page - 1 : $page;
      $last_page = ceil($count_conversations / $size);

      $next_page = ($page != $last_page) ? $page + 1 : $page;

      $array_return = [
        'type' => 'collection',
        'count' => sizeof($conversations),
        'none_read_number' => $none_read,
        'last_page_number' => $last_page,
        'conversations' => [],
        'links' => [
          'self' => [
            'href' => $this->c->get('router')->pathFor('getAccountConversations')
          ],
          'prev' => [
            'href' => $this->c->get('router')->pathFor('getAccountConversations') . "?page={$prev_page}&size={$size}"
          ],
          'next' => [
            'href' => $this->c->get('router')->pathFor('getAccountConversations') . "?page={$next_page}&size={$size}"
          ],
          'first' => [
            'href' => $this->c->get('router')->pathFor('getAccountConversations') . "?page=1&size={$size}"
          ],
          'last' => [
            'href' => $this->c->get('router')->pathFor('getAccountConversations') . "?page={$last_page}&size={$size}"
          ]
        ]
      ];
      foreach($conversations as $conversation){
        array_push($array_return['conversations'], [
          'conversation' => [
            'uuid' => $conversation->uuid,
            'title' => $conversation->titre,
            'admin_uuid' => $conversation->uuid,
            'created_at' => $conversation->created_at,
            'updated_at' => $conversation->updated_at,
            'conversation_read' => $conversation->conversation_vu
          ],
          'links' => [
            'self' => [
              'href' => $this->c->get('router')->pathFor('getConversation', ["uuid" => $conversation->uuid])
            ]
          ]
        ]);
      }
      return Writer::json_output($response, 200, $array_return);
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }

  public function getConversation(Request $request, Response $response, $args){
    try{
      $uuid = $args['uuid'];
      $conversation = Conversation::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();
      $admin = Administrateur::find($conversation->id_admin);
      try{
        $uuid_authenticated = $request->getAttribute('user_uuid');
        $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid_authenticated . '%')->firstOrFail();
        if($conversation->id_utilisateur == $authenticated->id_utilisateur){
          $array_return = [
            'type' => 'ressource',
            'conversation' => [
              'uuid' => $conversation->uuid,
              'title' => $conversation->titre,
              'admin_info' => [
                'uuid' => $admin->uuid,
                'name' => $admin->nom
              ],
              'user_info' => [
                'uuid' => $authenticated->uuid,
                'name' => $authenticated->nom . ' ' . $authenticated->prenom
              ]
            ],
            'links' => [
              'self' => [
                'href' => $this->c->get('router')->pathFor('getConversation', ["uuid" => $uuid])
              ],
              'messages' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid])
              ]
            ]
          ];
          return Writer::json_output($response, 200, $array_return);
        }else{
          $response->withHeader('Location', $this->c->get('router')->pathFor('getAccountConversations'));
          return Writer::json_error($response, $this->c['return_message']['forbidden_resource']['code'], $this->c['return_message']['forbidden_resource']['message']);
        }
      }
      catch(ModelNotFoundException $e){
        $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
        return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
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

  public function getConversationMessages(Request $request, Response $response, $args){
    $uuid = $args['uuid'];
    try{
      $conversation = Conversation::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();

      try{
        $uuid_utilisateur = $request->getAttribute('user_uuid');

        $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid_utilisateur . '%')->firstOrFail();

        if($conversation->id_utilisateur == $authenticated->id_utilisateur){
          $size = (isset($request->getQueryParams()['size'])) ? $request->getQueryParams()['size'] : 10;
          $page = (isset($request->getQueryParams()['page'])) ? $request->getQueryParams()['page'] : 1;
          $order = (isset($request->getQueryParams()['order'])) ? $request->getQueryParams()['page'] : 'DESC';
          $offset = $size * ($page - 1);

          $messages = $conversation->messages()->orderBy('id_message', $order)->offset($offset)->limit($size)->get();
          $count_messages = $conversation->messages()->count();

          $prev_page = ($page - 1 > 0) ? $page - 1 : $page;
          $last_page = ceil($count_messages / $size);

          $next_page = ($page != $last_page) ? $page + 1 : $page;

          $array_return = [
            'type' => 'collection',
            'count' => sizeof($messages),
            'messages' => [],
            'links' => [
              'self' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid])
              ],
              'conversation' => [
                'href' => $this->c->get('router')->pathFor('getConversation', ["uuid" => $uuid])
              ],
              'prev' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid]) . "?page={$prev_page}&size={$size}"
              ],
              'next' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid]) . "?page={$next_page}&size={$size}"
              ],
              'first' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid]) . "?page=1&size={$size}"
              ],
              'last' => [
                'href' => $this->c->get('router')->pathFor('getConversationMessages', ["uuid" => $uuid]) . "?page={$last_page}&size={$size}"
              ]
            ],
          ];
          foreach($messages as $message){
            if($message->id_utilisateur != null){
              $user = Utilisateur::find($message->id_utilisateur);
              $auteur_isAdmin = false;
              $auteur_name = $user->nom . ' ' . $user->prenom;
            }else{
              $admin = Administrateur::find($message->id_admin);
              $auteur_isAdmin = true;
              $auteur_name = $admin->nom;
            }
            array_push($array_return['messages'], [
              'message' => [
                'id' => $message->id_message,
                'message' => $message->message,
                'type' => $message->type,
                'created_at' => $message->created_at,
                'user_name' => $auteur_name,
                'user_isAdmin' => $auteur_isAdmin
              ]
            ]);
          }
          return Writer::json_output($response, 200, $array_return);
        }else{
          $response->withHeader('Location', $this->c->get('router')->pathFor('getAccountConversations'));
          return Writer::json_error($response, $this->c['return_message']['forbidden_resource']['code'], $this->c['return_message']['forbidden_resource']['message']);
        }
      }
      catch(ModelNotFoundException $e){
        $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
        return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
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

  public function getAccountAlertes(Request $request, Response $response, $args){
    try{
      $uuid = $request->getAttribute('user_uuid');
      $authenticated = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->firstOrFail();

      $size = (isset($request->getQueryParams()['size'])) ? $request->getQueryParams()['size'] : 5;
      $page = (isset($request->getQueryParams()['page'])) ? $request->getQueryParams()['page'] : 1;
      $order = (isset($request->getQueryParams()['order'])) ? $request->getQueryParams()['page'] : 'DESC';
      $offset = $size * ($page - 1);

      $alertes = $authenticated->alertes()->orderBy('id_alerte', 'desc')->offset($offset)->limit($size)->get();

      $count_alertes = $authenticated->alertes()->count();

      $none_read = $authenticated->alertes()->where('alerte_vu', '0')->count();

      $prev_page = ($page - 1 > 0) ? $page - 1 : $page;
      $last_page = ceil($count_alertes / $size);

      $next_page = ($page != $last_page) ? $page + 1 : $page;

      $array_return = [
        'type' => 'collection',
        'count' => sizeof($alertes),
        'none_read_number' => $none_read,
        'last_page_number' => $last_page,
        'alertes' => [],
        'links' => [
          'self' => [
            'href' => $this->c->get('router')->pathFor('getAccountAlertes')
          ],
          'prev' => [
            'href' => $this->c->get('router')->pathFor('getAccountAlertes') . "?page={$prev_page}&size={$size}"
          ],
          'next' => [
            'href' => $this->c->get('router')->pathFor('getAccountAlertes') . "?page={$next_page}&size={$size}"
          ],
          'first' => [
            'href' => $this->c->get('router')->pathFor('getAccountAlertes') . "?page=1&size={$size}"
          ],
          'last' => [
            'href' => $this->c->get('router')->pathFor('getAccountAlertes') . "?page={$last_page}&size={$size}"
          ]
        ]
      ];
      foreach($alertes as $alerte){
        if(empty($alerte->lien) == false){
          $link_alerte = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $alerte->lien;
        }else{
          $link_alerte = '';
        }

        array_push($array_return['alertes'], [
          'alerte' => [
            'id' => $alerte->id_alerte,
            'message' => $alerte->message,
            'created_at' => $alerte->created_at,
            'link' => $link_alerte,
            'alert_read' => $alerte->pivot->alerte_vu
          ]
        ]);
      }
      return Writer::json_output($response, 200, $array_return);
    }
    catch(ModelNotFoundException $e){
      $response->withHeader('Location', $this->c->get('router')->pathFor('signin'));
      return Writer::json_error($response, $this->c['return_message']['authentication_required']['code'], $this->c['return_message']['authentication_required']['message']);
    }
    catch(\Exception $e){
      $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
      return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
    }
  }

  public function getSiteFaqs(Request $request, Response $response, $args){
    $faqs = Faq::select()->get();
    $array_return = [
      'type' => 'collection',
      'count' => sizeof($faqs),
      'faqs' => []
    ];
    foreach($faqs as $faq){
      array_push($array_return['faqs'], [
        'faq' => [
          'id' => $faq->id_faq,
          'question' => $faq->question,
          'reponse' => $faq->reponse,
          'introduction' => $faq->introduction
        ]
      ]);
    }
    return Writer::json_output($response, 200, $array_return);
  }

  //Récupérer les marques (brands)
  public function getSiteBrands(Request $request, Response $response, $args){
    $size = (isset($request->getQueryParams()['size'])) ? $request->getQueryParams()['size'] : 8;
    $brands = Marque::limit($size)->get();
    $array_return = [
      'type' => 'collection',
      'count' => sizeof($brands),
      'brands' => []
    ];
    foreach($brands as $brand){
      $link_logo = "/shared_pic/marque/";
      $link_logo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $link_logo . $brand->lien;
      array_push($array_return['brands'], [
        'brand' => [
          'id' => $brand->id_marque,
          'name' => $brand->nom,
          'logo' => $link_logo
        ]
      ]);
    }
    return Writer::json_output($response, 200, $array_return);
  }

  public function getPageConfirmMail(Request $request, Response $response, $args){
    $server_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    $link = $this->c->get('router')->pathFor('postConfirmMail', ["uuid" => $args['uuid'], "token" => $args['token']]);
    $link = $server_url . $link;
    echo <<<EOT
    <html>
    <head>
    <title>Confirmation de votre adresse mail</title>
    <meta charset="utf8"/>
    </head>
    <body>
    <h1>Confirmer votre e-mail en cliquent sur le bouton ci-dessous :</h1>
    <button onclick="confirmMail()">Confirmer mon e-mail</button>
    </body>

    <script>
    function confirmMail(){
      let uuid = window.location.pathname.split("/")[5];
      let token = window.location.pathname.split("/")[6];

      if(uuid != null && token != null){
        if (window.fetch) {
          let myHeaders = new Headers({
            "Accept": "application/json"
          });

          let myInit = { method: 'POST',
          headers: myHeaders};

          let myRequest = new Request("{$link}",myInit);

          fetch(myRequest,myInit)
          .then(function(response) {
            let contentType = response.headers.get("content-type");
            if(response.ok){
              if(contentType && contentType.indexOf("application/json") !== -1) {
                return response.json().then(function(json) {
                  if(json.message)
                    alert(json.message)
                  else
                    alert("Tout s'est bien passé monsieur " + json.user.lastname + " " + json.user.firstname + ". Vous allez être redirigé vers la page d'accueil.");
                  window.location.href = "{$server_url}/signin";
                });
              } else {
                alert("Oops, nous n'avons pas du JSON!");
              }
            }else{
              if(contentType && contentType.indexOf("application/json") !== -1) {
                return response.json().then(function(json) {
                  alert("Erreur : " + json.error + " - " + json.message);
                });
              } else {
                alert("Il y a eu un problème avec la requête.");
              }
            }
          });
        } else {
          alert('Vous devez mettre à jour votre navigateur.');
        }
      }
      else{
        alert("Envois impossible, l'url de votre demande n'est pas correcte.");
      }
    }
      </script>
      </html>
EOT;
  }

  public function getPageResetPassword(Request $request, Response $response, $args){
    $server_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    $link = $this->c->get('router')->pathFor('resetPassword', ["uuid" => $args['uuid'], "token" => $args['token']]);
    $link = $server_url . $link;
    echo <<<EOT
      <html>
      <head>
      <title>Réinitialisation mot de passe</title>
      <meta charset="utf8"/>
      </head>
      <body>
      <h1>Veuillez entrer un nouveau mot de passe :</h1>
      <input type="password" id="password" placeholder="Nouveau mot de passe"/>
      <input type="password" id="confirm_password" placeholder="Confirmation mot de passe"/>
      <button onclick="resetPassword()">Changer mon mot de passe</button>
      </body>

      <script>
      function checkPassword(password, confirmPassword){
        if(password.length >= 5){
          if(password == confirmPassword){
            return true;
          }else{
            alert("Les mots de passe ne correspondent pas.");
          }
        }else{
          alert("Votre mot de passe doit contenir au minimum 5 caractères.");
          return false;
        }
      }
      function resetPassword(){
        let uuid = window.location.pathname.split("/")[5];
        let token = window.location.pathname.split("/")[6];

        if(uuid != null && token != null){
          let password = document.querySelectorAll('#password')[0].value;
          let confirmPassword = document.querySelectorAll('#confirm_password')[0].value;

          if(checkPassword(password, confirmPassword)){
            if (window.fetch){
              let payload = {
                'password': password
              };
              let json = JSON.stringify(payload);

              let myHeaders = new Headers({
                "Content-Type": "application/json",
                "Accept": "application/json"
              });

              let myInit = { method: 'POST',
              headers: myHeaders,
              body: json};

              let myRequest = new Request("{$link}",myInit);

              fetch(myRequest,myInit)
              .then(function(response) {
                let contentType = response.headers.get("content-type");
                if(response.status === 204){
                  alert("Tout s'est bien passé (204). Vous allez être redirigé vers la page de connexion.");
                  window.location.href = "{$server_url}/signin";
                }else if(response.ok){
                  if(contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json().then(function(json) {
                      if(json.message)
                        alert(json.message)
                      else
                        alert("Tout s'est bien passé. Vous allez être redirigé vers la page de connexion.");
                      window.location.href = "{$server_url}/signin";
                    });
                  } else {
                    alert("Tout s'est bien passé. Vous allez être redirigé vers la page d'accueil.");
                  }
                }else{
                  if(contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json().then(function(json) {
                      alert("Erreur : " + json.error + " - " + json.message);
                    });
                  } else {
                    alert("Il y a eu un problème avec la requête.");
                  }
                }
              });
            }
            else {
              alert('Vous devez mettre à jour votre navigateur.');
            }
          }
        }
        else{
          alert("Envois impossible, l'url de votre demande n'est pas correcte.");
        }
      }
      </script>
      </html>
EOT;
    }
  }
