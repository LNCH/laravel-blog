<?php

namespace Lnch\LaravelBlog\Controllers;

class BlogCommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (config("laravel-blog.use_auth_middleware", false)) {
            $this->middleware("auth");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(auth()->user()->cannot("view", BlogPost::class)) {
//            abort(403);
//        }


        return view($this->viewPath."comments.index", [

        ]);
    }
}
