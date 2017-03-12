<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PostType;
use App\Models\Tax;
use App\Models\File as FileModel;

class ApiController extends Controller
{
    protected $post;
    protected $page;
    protected $cat;
    protected $file;
    protected $request;

    public function __construct(
            PostType $post, 
            PostType $page, 
            Tax $cat, 
            FileModel $file, 
            Request $request
    ) {
        $this->post = $post;
        $this->page = $page;
        $this->cat = $cat;
        $this->file = $file;
        $this->request = $request;
    }

    public function getPosts() {
        $posts = $this->post->getData('post', $this->request->all());
        return response()->json($posts);
    }

    public function getPages() {
        $pages = $this->page->getData('page', $this->request->all());
        return response()->json($pages);
    }

    public function getCats() {
        $cats = $this->cat->getData('cat', $this->request->all());
        return response()->json($cats);
    }

    public function getFiles() {
        if(cando('read_files')) {
            return response()->json([], 402);
        }
        
        $files = $this->file->getData($this->request->all());
        return response()->json($files);
    }
}
