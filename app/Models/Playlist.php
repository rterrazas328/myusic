<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'playlists';



    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'playlist_name'];

 
}
