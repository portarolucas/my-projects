<?php

namespace Autoriko\Controllers;

use Autoriko\Utils\Writer;
use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

use Autoriko\Models\Achat;
use Autoriko\Models\Administrateur;
use Autoriko\Models\Alerte;
use Autoriko\Models\Conversation;
use Autoriko\Models\Vente;
use Autoriko\Models\Encherissement;
use Autoriko\Models\Entreprise;
use Autoriko\Models\Faq;
use Autoriko\Models\Message;
use Autoriko\Models\Particulier;
use Autoriko\Models\Photo;
use Autoriko\Models\Representant;
use Autoriko\Models\Utilisateur;
use Autoriko\Models\Video;

class DeleteController
{
  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function deleteAccount(Request $request, Response $response, $args){
    $uuid = $request->getAttribute('user_uuid');
    $user = Utilisateur::where('uuid', 'like', '%' . $uuid . '%')->first();
    if($user){
      try{
        $user->delete();
        $array_return = [];
        return Writer::json_output($response, 204, $array_return);
      }
      catch(\Exception $e){
        $this->c['logger.error']->error("-\n\r" . "Exception : " . $e->getMessage() . "- File : " . $e->getFile() . "- Line : " . $e->getLine() . "- Trace : " . $e->getTraceAsString() . "\n\r");
        return Writer::json_error($response, $this->c['return_message']['internal_server_error']['code'], $this->c['return_message']['internal_server_error']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['unknown_authenticated_user']['code'], $this->c['return_message']['unknown_authenticated_user']['message']);
    }
  }
}
