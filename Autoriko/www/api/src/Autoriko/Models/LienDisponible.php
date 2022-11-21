<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class LienDisponible extends Model{
  protected $table = 'lien_disponible';
  protected $primaryKey = 'id_lien';
  public $timestamps = false;
}
