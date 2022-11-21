<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Representation_voiture extends Model{
  protected $table = 'representation_voiture';
  protected $primaryKey = 'id_representation';
  public $timestamps = false;

  public function voiture(){
    return $this->belongsTo('Autoriko\Models\Voiture', 'id_voiture');
  }
}
