<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Photo_voiture extends Model{
  protected $table = 'photo_voiture';
  protected $primaryKey = 'id_photo';
  public $timestamps = false;

  public function voiture(){
    return $this->belongsTo('Autoriko\Models\Voiture', 'id_voiture');
  }

  public function categorie_photo(){
    return $this->belongsTo('Autoriko\Models\Categorie_photo', 'id_categorie_photo');
  }

}
