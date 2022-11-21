<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Representation extends Model{
  protected $table = 'reprensentation_enchere';
  protected $primaryKey = 'id_representation';
  public $timestamps = false;

  public function enchere(){
    return $this->belongTo('Autoriko\Models\Vente', 'id_vente');
  }
}
