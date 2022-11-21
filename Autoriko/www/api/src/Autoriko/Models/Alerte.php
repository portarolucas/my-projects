<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model{
  protected $table = 'alerte';
  protected $primaryKey = 'id_alerte';
  public $timestamps = true;

  protected $guarded = ['id_alerte', 'id_admin', 'created_at', 'updated_at', 'deleted_at'];

  public function utilisateur(){
    return $this->belongsToMany('Autoriko\Models\Utilisateur', 'recevoir_alerte', 'id_alerte', 'id_utilisateur')
    ->withPivot('alerte_vu');
  }
}
