<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    
    protected $table = 'photo_enchere';
    protected $primaryKey = 'id_photo';
    public $timestamps = false;

}