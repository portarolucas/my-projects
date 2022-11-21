<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    
    protected $table = 'video_vente';
    protected $primaryKey = 'id_video';
    public $timestamps = false;

}