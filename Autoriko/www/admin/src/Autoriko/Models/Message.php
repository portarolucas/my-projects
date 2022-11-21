<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model{
  protected $table = 'message';
  protected $primaryKey = 'id_message';
  public $timestamps = true;

  protected $guarded = ['id_message', 'id_conversation', 'id_utilisateur', 'id_admin', 'created_at', 'updated_at', 'deleted_at'];

  public function conversation(){
    return $this->belongTo('Autoriko\Models\Utilisateur', 'id_utilisateur');
  }

  public function utilisateur(){
    return $this->belongsTo('Autoriko\Models\Utilisateur', 'id_utilisateur');
  }

  public function admin(){
    return $this->belongsTo('Autoriko\Models\Admin', 'id_administrateur');
  }
}
