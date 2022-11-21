<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model{
  protected $table = 'achat';
  protected $primaryKey = 'id_achat';
  public $timestamps = true;

  protected $guarded = ['id_achat', 'uuid', 'date_confirmation_mail', 'date_validation_vente', 'id_vente', 'id_utilisateur', 'created_at', 'updated_at', 'deleted_at'];

  public function enchere(){
    return $this->belongsTo('Autoriko\Models\Vente', 'id_vente');
  }

  public function utilisateur(){
    return $this->belongsTo('Autoriko\Models\Utilisateur', 'id_utilisateur');
  }
}
