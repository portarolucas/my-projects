<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model{
  protected $table = 'entreprise';
  protected $primaryKey = 'id_utilisateur';
  public $timestamps = false;
}
