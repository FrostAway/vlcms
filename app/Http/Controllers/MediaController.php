<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\MediaEloquent;
use App\Eloquents\DriveEloquent;

use Illuminate\Validation\ValidationException;
use Validator;

class MediaController extends Controller
{
    protected $media;
    protected $drive;

    public function __construct(MediaEloquent $media, DriveEloquent $drive) {
        $this->media = $media;
        $this->drive = $drive;
    }
    
    public function lists(Request $request){
        $medias = $this->media->all($request->all());
        return view('front.media_lists', compact('medias'));
    }
    
    public function view($id, $slug=null){
        $media = $this->media->findByLang($id);
        return view('front.media_detail', compact('media'));
    }
    
    public function uploadDrive(Request $request) {
        $files = $request->file('upload_files');
        
        if ($files) {
            $result = [];
            try {
                foreach ($files as $file) {
                    $result[] = $this->drive->upload($file); 
                }
//                return redirect()->back()->with('succ_mess', trans('message.upload_success'));
                dd($result);
            } catch (\Exception $ex) {
//                return redirect()->back()->with('error_mess', trans('message.na_error'));
                dd($ex);
            }
        }
        
//        return redirect()->back()->withErrors(['upload_files' => trans('message.file.required')]);
    }
    
    public function getVideoInfoByLink(Request $request) {
        if (!$request->has('link')) {
            return response()->json(trans('message.no_item'), 422);
        }
        return $this->media->getVideoInfoByLink($request->get('link'));
    }
    
    public function addVideo(Request $request) {
        try {
            $this->media->insert($request->all(), $request->get('media_type'));
            return redirect()->back()->with('succ_mess', trans('manage.store_success'));
        } catch (ValidationException $ex) {
            return redirect()->back()->withErrors($ex->validator);
        }
    }
}
