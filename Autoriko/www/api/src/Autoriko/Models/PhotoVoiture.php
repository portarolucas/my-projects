<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoVoiture extends Model{
  protected $table = 'photo_voiture';
  protected $primaryKey = 'id_photo';
  public $timestamps = false;

  public function categorie_photo(){
    return $this->belongsTo('Autoriko\Models\CategoriePhoto', 'id_categorie_photo');
  }

}
