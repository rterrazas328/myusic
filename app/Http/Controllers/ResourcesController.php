<?php namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\Track;
use Auth;
use Storage;

class ResourcesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadImage(){
        $userID = Auth::user()['id'];
        $profile = UserProfile::find($userID);
        $path = $profile?->profile_picture;


        if (Storage::exists($path))
        {
            return Storage::download($path);
        }

        return Storage::download("private/images/default/icon.png");
    }

    public function loadAudio($id){
        $userID = Auth::user()['id'];
        $track = Track::find($id);

        if (!$track) {
            return;
            //abort(404);
        }


        if ($track->band_id != $userID) {
            abort(403);
        }

        $path = $track->file_path;


        if (Storage::exists($path)){
            return Storage::download($path);
        }

        return;

    }

}