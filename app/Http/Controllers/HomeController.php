<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Media;
use App\Models\PostType;
use Validator;
use Mail;
use Option;

class HomeController extends Controller {

    protected $tax;
    protected $slide;
    protected $post;

    public function __construct(
            Tax $tax,
            Media $slide,
            PostType $post
    ) {
        $this->tax = $tax;
        $this->slide = $slide;
        $this->post = $post;
    }

    public function index() {

        
        return view('front.index');
    }

    public function sendContact(Request $request) {
        $valid = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'content' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $mail_to = Option::get('_admin_email');
        $mail_to = $mail_to ? $mail_to : config('mail.contact_mail');
        
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'content' => $request->input('content'),
            'phone' => $request->input('phone')
        ];

        Mail::send('mails.contact', $data, function($mail) use($mail_to, $request) {
            $mail->to($mail_to);
            $mail->subject(trans('contact.subject_content', ['host' => $request->getHost()]));
        });

        if (count(Mail::failures()) > 0) {
            return redirect()->back()->withInput()->with('error_mess', trans('front.na_errors'));
        }

        return redirect()->back()->with('succ_mess', trans('contact.contact_sent'));
    }

}
