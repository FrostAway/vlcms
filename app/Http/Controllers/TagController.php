<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\PostType;

class TagController extends Controller
{
    protected $tag;
    protected $post;

    public function __construct(Tax $tag, PostType $post) {
        $this->tag = $tag;
        $this->post = $post;
    }
    
    public function lists(Request $request){
        $tags = $this->tag->getData('tag', $request->all());
        return view('front.tag_lists', compact('tags'));
    }
    
    public function view($id, $slug=null){
        $tag = $this->tag->findByLang($id);
        $posts = $this->post->getData('post', [
            'field' => ['posts.*', 'pd.*'],
            'tags' => [$id]
        ]);
        return view('front.tag', compact('tag', 'posts'));
    }
}
