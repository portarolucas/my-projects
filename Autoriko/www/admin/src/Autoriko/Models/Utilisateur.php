<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateur extends Model{
  protected $table = 'utilisateur';
  protected $primaryKey = 'id_utilisateur';
  public $timestamps = true;
  use SoftDeletes;

  protected $guarded = ['id_utilisateur', 'uuid', 'mdp', 'etat_confirmation_mail', 'etat_validation_compte', 'created_at', 'updated_at', 'deleted_at'];

  public function participation_vente(){
    return $this->belongsToMany('Autoriko\Models\Vente', 'participation', 'id_utilisateur', 'id_vente');
  }

  public function alertes(){
    return $this->belongsToMany('Autoriko\Models\Alerte', 'recevoir_alerte', 'id_utilisateur', 'id_alerte')
    ->withPivot('alerte_vu');
  }

  public function conversations(){
    return $this->HasMany('Autoriko\Models\Conversation', 'id_utilisateur');
  }

  public function particulier(){
    return $this->belongsTo('Autoriko\Models\Particulier', 'id_utilisateur');
  }

  public function entreprise(){
    return $this->belongsTo('Autoriko\Models\Entreprise', 'id_utilisateur');
  }
}
