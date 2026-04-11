<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'music';



    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['band_id', 'song_name', 'authors', 'genre', 'file_path'];


}
