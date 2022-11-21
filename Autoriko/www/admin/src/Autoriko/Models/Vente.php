<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    
    protected $table = 'vente';
    protected $primaryKey = 'id_vente';
    public $timestamps = false;

}