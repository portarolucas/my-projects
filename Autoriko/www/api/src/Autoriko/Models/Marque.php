<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model{
  protected $table = 'marque';
  protected $primaryKey = 'id_marque';
  public $timestamps = false;

}
