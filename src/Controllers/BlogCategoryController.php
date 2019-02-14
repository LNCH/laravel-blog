<?php

namespace Lnch\LaravelBlog\Controllers;

use Lnch\LaravelBlog\Models\BlogCategory;
use Lnch\LaravelBlog\Requests\BlogCategoryRequest;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (config("laravel-blog.use_auth_middleware", false)) {
            $this->middleware("auth");
        }

        if (!config("laravel-blog.categories.enabled")) {
            abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->cannot("view", BlogCategory::class)) {
            abort(403);
        }

        $categories = BlogCategory::paginate(config("laravel-blog.categories.per_page"));

        return view($this->viewPath."categories.index", [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->cannot("create", BlogCategory::class)) {
            abort(403);
        }

        return view($this->viewPath."categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $request)
    {
        if(auth()->user()->cannot("create", BlogCategory::class)) {
            abort(403);
        }

        // If the category has previously been deleted, we'll restore it
        $trashed = BlogCategory::where("name", $request->name)
            ->withTrashed()
            ->first();

        if($trashed)
        {
            $trashed->restore();
        }
        else
        {
            BlogCategory::create([
                'site_id'       => getBlogSiteID(),
                'name'          => $request->name,
                'description'   => $request->description
            ]);
        }

        return redirect($this->routePrefix."categories")
            ->with("success", "Category created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlogCategory $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(BlogCategory $category)
    {
        if(auth()->user()->cannot("edit", $category)) {
            abort(403);
        }

        return view($this->viewPath."categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryRequest $request
     * @param BlogCategory $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(BlogCategoryRequest $request, BlogCategory $category)
    {
        if(auth()->user()->cannot("edit", $category)) {
            abort(403);
        }

        $siteId = getBlogSiteID();

        $category->update($request->only(['name', 'description']));

        return redirect($this->routePrefix."categories")
            ->with("success", "Category updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogCategory $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(BlogCategory $category)
    {
        if(auth()->user()->cannot("delete", $category)) {
            abort(403);
        }

        $category->delete();

        return redirect($this->routePrefix."categories")
            ->with("success", "Category deleted successfully");
    }
}
