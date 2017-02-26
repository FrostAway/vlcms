<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\FileEloquent;
use App\Eloquents\MediaEloquent;

class AjaxController extends Controller
{
    protected $request;
    protected $file;

    public function __construct(Request $request, FileEloquent $file) {
        $this->request = $request;
        $this->file = $file;
    }
    
    public function action(){
        $action = $this->request->get('action');
        $result = '';
        switch ($action) {
            case 'load_files':
                $files = $this->file->all($this->request->all());
                if(!$files->isEmpty()){
                    foreach ($files as $file) {
                        $result .= '<li><a href="'.$file->getSrc('full').'" data-id="'.$file->id.'">';
                        $result .= $file->getImage('thumbnail');
                        $result .= '</a></li>';
                    }
                }
                break;
            case 'get_video_info':
                if (!$this->request->has('link')) {
                    return response()->json(trans('message.no_data'), 422);
                }
                break;
        }
        return $result;
    }
}
