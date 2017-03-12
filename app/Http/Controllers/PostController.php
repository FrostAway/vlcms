<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostType;
use App\Models\Comment;

class PostController extends Controller
{
    protected $post;
    protected $comment;

    public function __construct(PostType $post, Comment $comment) {
        $this->post = $post;
        $this->comment = $comment;
    }
    
    public function lists(Request $request){
        $posts = $this->post->getData('post', $request->all());
        return view('front.post_lists', compact('posts'));
    }
    
    public function view($id, $slug=null){
        $post = $this->post->findByLang($id, ['posts.*', 'pd.*']);
        $comments = $this->comment->getData([
            'post_id' => $id
        ]);
        return view('front.post_detail', compact('post', 'comments'));
    }
}
