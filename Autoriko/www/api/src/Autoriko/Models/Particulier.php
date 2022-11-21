<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Particulier extends Model{
  protected $table = 'particulier';
  protected $primaryKey = 'id_utilisateur';
  public $timestamps = false;
}
