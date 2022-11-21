<?php
error_reporting(E_ALL);//TODO METTRE A FALSE POUR LA RELEASE

return [
     'settings' => [
          'displayErrorDetails'=>true,//TODO METTRE A FALSE POUR LA RELEASE
          'dbfile'=> __DIR__ . '/db.ini',
          'cors' => [
               "methods" => ["GET", "POST", "PUT", "OPTIONS", "DELETE"],
               "headers.allow" => ['Content-Type', 'Authorization', 'X-commande-token'],
               "headers.expose"=>[],
               "max.age"=> 60*60,
               "credentials"=> true
          ],
          'debug.log'=> "../logs/debug.log",
          'debug.level' => \Monolog\Logger::DEBUG,
          'debug.name' =>'debug.log',
          'error.log'=>  "../logs/warn.log",
          'error.level' => \Monolog\Logger::WARNING,
          'error.name' =>'error.log',
          'frontoffice' => 'http://autoriko.fr:12080',
          'api_settings' => [
            'client_to_db' => [
              "utilisateur" => [
                "email" => "mail",
                "country" => "pays",
                "zip" => "code_postal",
                "city" => "ville",
                "address" => "adresse",
                "address_additional" => "comp_adresse",
                "phone_home" => "telephone_fixe",
                "cellphone" => "telephone_mobile"
              ],
              "particulier" => [
                "date_of_birth" => "date_naissance"
              ],
              "entreprise" => [
                "name" => "raison_sociale",
                "siren" => "siren",
                "number_tva" => "numero_tva"
              ]
            ],
            'authorized_country' => [
              "france",
              "luxembourg",
              "suisse",
              "belgique"
            ]
          ]
     ]
];
