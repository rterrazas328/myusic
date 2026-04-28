<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Validator;
use DB;
use Mail;
use Auth;
use Illuminate\Http\RedirectResponse;
use Storage;

class MusicController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function getTracks(){
        $userID = Auth::user()['id'];

        $userTracks = DB::select('SELECT * FROM music where band_id = ?', [$userID]);

        return view('tracks', [ 'data' => $userTracks, 'page_name' => 'tracks']);
    }

    public function getPlaylists(){
        $userID = Auth::user()['id'];

        $userPlaylists = DB::select('SELECT * FROM playlists where user_id = ?', [$userID]);

        return view('playlists', [ 'data' => $userPlaylists, 'page_name' => 'playlists']);
    }

    public function getCreatePlaylist(){
        $userID = Auth::user()['id'];

        $userTracks = DB::select('SELECT * FROM music where band_id = ?', [$userID]);

        return view('createplaylist', [ 'data' => $userTracks, 'page_name' => 'createplaylist']);
    }

    public function saveTrack(Request $request){
        $request->validate([
            'mp3' => 'max:12000',
        ]);
        //'mp3' => 'file|mimes:mp3,wav,ogg|max:7000',

        $userID = Auth::user()['id'];
        /*echo "In SaveTrack()";
        echo "RequestF: ".print_r(RequestF::file('mp3'));
        echo "has file?: ".print_r(RequestF::hasFile('mp3'));
        var_dump(RequestF::hasFile('mp3'));
        var_dump(RequestF::hasFile('mp3') === true);
        var_dump(RequestF::hasFile('mp3') == true);
        var_dump(RequestF::hasFile('mp3') ? 'truthy' : 'falsey');
        echo "Dumping request:";
        dd($_FILES);*/

       /* dd([
        'Facade hasFile' => RequestF::hasFile('mp3'),
        'Helper hasFile' => $request->hasFile('mp3'),
        'Facade file' => RequestF::file('mp3'),
        'Helper file' => $request->file('mp3'),
        'FILES superglobal' => $_FILES,
            ]);*/

        //if (RequestF::hasFile('mp3')){
        if ($request->hasFile('mp3')){
            $file = $request->file('mp3');
            //echo "Request had file" . print_r($file);
            if ($file->isValid()){
                $target_dir = "audio/".$userID;
                //echo "Target Dir:" . print_r($target_dir);
                //if target_dir doesn't exist, create it
                if(!is_dir($target_dir)){
                    Storage::makeDirectory($target_dir);
                }

                $path = $file->store("audio/".$userID);
                if (!$path){
                    //abort(500);
                    return redirect('/tracks');
                }
                //if($file->move(storage_path() . "/app/" .$target_dir, $file->getClientOriginalName())){

                    //if($track == null) {
                        $track = new Track;
                        //fill in fields
                        $track->band_id = $userID;
                        $track->song_name = $request->input('track');
                        $track->authors = $request->input('artist');
                        $track->genre = $request->input('genre');
                        //$track->file_path = storage_path() . "/app/" . $target_dir . "/" . $file->getClientOriginalName();
                        $track->file_path = $path;
                        //echo "Track is :". print_r($track);
                        $track->save();
                        return redirect('/tracks');
                    //}
                //}
            }
        }

        return redirect('/tracks');
    }

    public function deleteTrack(Request $request){
        $userID = Auth::user()['id'];

        $data=$request->all();

        foreach ($data as $name => $val){

            if ($val == "on"){

                //find corresponding model
                $track = Track::find($name);

                //delete the model
                if($track != null){
                    if ($track->band_id != $userID) {
                        //abort(403);
                        return redirect('/tracks');;
                    }


                    $trackID = $track->id;
                    $track->delete();
                    //remove from playlist_songs
                    DB::delete('DELETE FROM playlist_songs where track_id = ?', [$trackID]);
                }

            }
        }

        return redirect('/tracks');
    }

    public function savePlaylist(Request $request, $id = null){

        $request->validate([
            'playlistName' => 'required|string|max:20',
        ]);

        $userID = Auth::user()['id'];

        if($id != null){
            $playlist = Playlist::find($id);
            if($playlist == null){
                //create new
                $playlist = new Playlist;
            }
        }
        else{
            //create new
            $playlist = new Playlist;
        }

        //fill in fields
        $playlist->user_id = $userID;
        $playlist->playlist_name = $request->input('playlistName');

        //create playlist
        $playlist->save();

        $insertedID = $playlist->id;
            //for each checkbox checked add song in playlist songs table
        $data=$request->all();

        foreach ($data as $name => $val){

            if ($val == "on"){

                //find corresponding model
                $track = Track::find($name);

                //delete the model
                if($track != null){
                    DB::insert('INSERT INTO playlist_songs (playlist_id, track_id) values (?, ?)', [$insertedID, $name]);
                }

            }
        }
        return redirect('/playlists');
    }

    public function deletePlaylist(Request $request){

        $request->validate([
            'delete' => 'required',
        ]);

        $playlistID = $request->input('delete');

        $playlist = Playlist::find($playlistID);

        if($playlist != null){
            DB::delete('DELETE FROM playlist_songs where playlist_id = ?', [$playlistID]);
            $playlist->delete();
        }

        return redirect('/playlists');
    }

    public function editPlaylist($id, Request $request){
        $playlist = Playlist::find($id);

        $pName = $playlist->playlist_name;

        $userID = Auth::user()['id'];

        if ($playlist->user_id != $userID) {
            //abort(403);
            return;
        }


        $playlistTrackIDs = DB::select('SELECT track_id FROM playlist_songs where playlist_id = ?', [$id]);

        $userTracks = DB::select('SELECT * FROM music where band_id = ?', [$userID]);

        $tracksData = array();

        foreach($userTracks as $track){

            $inArray = false;

            foreach($playlistTrackIDs as $trackID){
                if($track->id == $trackID->track_id){
                    $inArray = true;
                }
            }

            if($inArray){
                $tracksData[$track->id."_on"] = $track;
            }
            else{
                $tracksData[$track->id."_off"] = $track;
            }
        }
        $tracksData = $tracksData;

        return view('editplaylist', [ 'playlistName' => $pName, 'playlistID' => $id , 'data' =>  $tracksData,'page_name' => 'editplaylist']);
    }

}