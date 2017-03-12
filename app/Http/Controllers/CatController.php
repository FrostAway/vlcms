<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\PostType;

class CatController extends Controller
{
    protected $cat;
    protected $post;
    
    public function __construct(Tax $cat, PostType $post) {
        $this->cat = $cat;
        $this->post = $post;
    }
    
    public function view($id, $slug=null){
        $cat = $this->cat->findByLang($id, ['td.name', 'td.slug', 'taxs.id']);
        $posts = $this->post->getData('post', [
            'field' => ['posts.*', 'pd.*'],
            'orderby' => 'created_at',
            'order' => 'desc',
            'cats' => [$id]
        ]);
        return view('front.category', compact('cat', 'posts'));
    }
}
