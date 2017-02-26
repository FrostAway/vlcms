<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\PostTypeEloquent;
use App\Eloquents\TaxEloquent;
use App\Eloquents\FileEloquent;

class ApiController extends Controller {

    protected $post;
    protected $tax;
    protected $file;
    protected $request;

    public function __construct(
            PostTypeEloquent $post,  
            TaxEloquent $tax, 
            FileEloquent $file, 
            Request $request
    ) {
        $this->post = $post;
        $this->tax = $tax;
        $this->file = $file;
        $this->request = $request;
    }

    public function getPosts() {
        $posts = $this->post->all('post', $this->request->all());
        return response()->json($posts);
    }

    public function getPages() {
        $pages = $this->post->all('page', $this->request->all());
        return response()->json($pages);
    }

    public function getCats() {
        $cats = $this->tax->all('cat', $this->request->all());
        return response()->json($cats);
    }

    public function getFiles() {
        $files = $this->file->all($this->request->all());
        return response()->json($files);
    }

}
