<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostType;

class PageController extends Controller {

    protected $page;

    public function __construct(PostType $page) {
        $this->page = $page;
    }

    public function lists(Request $request) {
        $pages = $this->page->getData('page', $request->all());
        return view('front.page_lists', compact('pages'));
    }

    public function view($id, $slug = null) {
        $page = $this->page->findByLang($id);

        if (!$page) {
            abort(404);
        }

        if ($page->is_auth) {
            if (!auth()->check()) {
                return redirect()->route('get_login');
            }
        }

        if (trim($page->template)) {
            return view('front.templates.' . $page->template, compact('page'));
        }
        return view('front.page_detail', compact('page'));
    }

}
