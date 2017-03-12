<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

use Illuminate\Validation\ValidationException;
use Validator;

class MediaController extends Controller
{
    protected $media;

    public function __construct(Media $media, DriveEloquent $drive) {
        $this->media = $media;
    }
    
    public function lists(Request $request){
        $medias = $this->media->getData($request->all());
        return view('front.media_lists', compact('medias'));
    }
    
    public function view($id, $slug=null){
        $media = $this->media->findByLang($id);
        return view('front.media_detail', compact('media'));
    }
}
