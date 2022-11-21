<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model{
  protected $table = 'categorie';
  protected $primaryKey = 'id_categorie';
  public $timestamps = false;

  public function voiture(){
    return $this->hasMany('Autoriko\Models\Voiture', 'id_categorie');
  }
}
