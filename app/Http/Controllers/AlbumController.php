<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Media;

class AlbumController extends Controller
{
    protected $album;
    protected $media;

    public function __construct(Tax $album, Media $media) {
        $this->album = $album;
        $this->media = $media;
    }
    
    public function lists(Request $request){
        $albums = $this->album->getData('album', $request->all());
        return view('front.album_lists', compact('albums'));
    }
    
    public function view($id, $slug=null){
        $album = $this->album->findByLang($id);
        $images = $this->media->getData([
            'albums' => [$id]
        ]);
        return view('front.album', compact('album', 'images'));
    }
}
