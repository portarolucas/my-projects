<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Voiture extends Model{
  protected $table = 'voiture';
  protected $primaryKey = 'id_voiture';
  public $timestamps = false;

  public function brand(){
    return $this->belongsTo('Autoriko\Models\Marque', 'id_marque');
  }

  public function category(){
    return $this->belongsTo('Autoriko\Models\Categorie', 'id_categorie');
  }

  public function photos(){
    return $this->HasMany('Autoriko\Models\PhotoVoiture', 'id_voiture');
  }

}
