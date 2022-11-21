<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie_photo extends Model{
  protected $table = 'categorie_photo';
  protected $primaryKey = 'id_categorie_photo';
  public $timestamps = false;

  public function photo_voiture(){
    return $this->hasMany('Autoriko\Models\Photo_voiture', 'id_categorie_photo');
  }

}
