<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
  protected $table = 'offre';
  protected $primaryKey = 'id_offre';
  public $timestamps = true;

  protected $guarded = ['id_offre', 'uuid', 'id_vente', 'id_utilisateur', 'created_at', 'updated_at'];

  public function vente(){
    return $this->hasOne('Autoriko\Models\Vente', 'id_vente');
  }

  public function utilisateur(){
    return $this->hasOne('Autoriko\Models\Utilisateur', 'id_utilisateur');
  }
}
