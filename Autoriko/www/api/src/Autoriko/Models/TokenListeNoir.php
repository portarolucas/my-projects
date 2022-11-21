<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class TokenListeNoir extends Model{
  protected $table = 'token_liste_noir';
  protected $primaryKey = null;
  public $incrementing = false;
  public $timestamps = false;
}
