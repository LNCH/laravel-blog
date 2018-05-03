<?php

namespace Lnch\LaravelBlog\Controllers;

use Illuminate\Support\Facades\DB;
use Lnch\LaravelBlog\Models\BlogImage;
use Illuminate\Http\UploadedFile;
use Lnch\LaravelBlog\Requests\BlogImageRequest;

class BlogImageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!config("laravel-blog.images.enabled")) {
            abort(404);
        }
    }

    /**
     * Displays a full list of the active site's uploaded blog images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user()->cannot("view", BlogImage::class)) {
            abort(403);
        }

        $images = BlogImage::paginate(config("laravel-blog.images.per_page"));

        return view("laravel-blog::".$this->viewPath."images.index", [
            'images' => $images
        ]);
    }

    /**
     * Presents the interface to upload a new image or images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if(auth()->user()->cannot("create", BlogImage::class)) {
            abort(403);
        }

        return view("laravel-blog::".$this->viewPath."images.create");
    }

    /**
     * Handles upload of images and stores them in the database
     *
     * @param BlogImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogImageRequest $request)
    {
        if(auth()->user()->cannot("create", BlogImage::class)) {
            abort(403);
        }

        // Upload files, create records
        foreach($request->images as $image)
        {
            DB::transaction(function() use($image, $request) {
                $this->uploadFile($image, $request);
            });
        }

        $returnUrl = blogUrl("images");
        if($request->embed && $request->featured) {
            $returnUrl .= "?embed=true&featured=true";
        } else if ($request->embed) {
            $returnUrl .= "?embed=true";
        } else if ($request->featured) {
            $returnUrl .= "?featured=true";
        }

        // Return
        return redirect($returnUrl)
            ->with("success", (!$request->embed) ? "Images uploaded successfully!" : '');
    }

    /**
     * Displays a form for editing the selected BlogImage.
     *
     * @param BlogImage $image
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(BlogImage $image)
    {
        if(auth()->user()->cannot("edit", $image)) {
            abort(403);
        }

        return view("laravel-blog::".$this->viewPath."images.edit", [
            'image' => $image
        ]);
    }

    /**
     * Updates the given resource
     *
     * @param BlogImageRequest $request
     * @param BlogImage        $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogImageRequest $request, BlogImage $image)
    {
        if(auth()->user()->cannot("edit", $image)) {
            abort(403);
        }

        $image->update($request->only([
            "caption",
            "alt_text"
        ]));

        // Return
        return redirect($this->routePrefix."images")
            ->with("success", "Image updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlogImage $image
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(BlogImage $image)
    {
        if(auth()->user()->cannot("delete", $image)) {
            abort(403);
        }

        $image->delete();

        // Return
        return redirect($this->routePrefix."images")
            ->with("success", "Image deleted successfully!");
    }

    /**
     * Uploads a file to the server and creates a DB entry.
     *
     * @param UploadedFile $file
     * @param BlogImageRequest      $request
     * @return string
     */
    private function uploadFile(UploadedFile $file, BlogImageRequest $request)
    {
        // Create filename
        $originalFilename = $file->getClientOriginalName();

        $patterns = [
            '@\[date\]@is',
            '@\[datetime\]@is',
            '@\[filename\]@is',
        ];

        $matches = [
            date("Ymd"),
            date("Ymd-His"),
            $originalFilename,
        ];

        $filenamePattern = config("laravel-blog.images.filename_format", "[datetime]_[filename]");
        $filename = preg_replace($patterns, $matches, $filenamePattern);
//        $filename = date("Ymd-His-") . $originalFilename;

        $caption = $request->caption ? $request->caption[$originalFilename] : '';
        $alt_text = $request->alt_text ? $request->alt_text[$originalFilename] : '';

        // Create DB record
        BlogImage::create([
            'site_id' => getBlogSiteID(),
            'path' => $filename,
            'caption' => $caption,
            'alt_text' => $alt_text,
        ]);

        // Upload file
        $destinationPath = public_path(config("laravel-blog.images.storage_path"));
        $file->move($destinationPath, $filename);

        return $filename;
    }

//    /**
//     * Retrieves a request to upload an image from the CKEditor
//     *
//     * @param Request $request
//     * @return string
//     */
//    public function dialogUpload(Request $request)
//    {
//        $files = request()->file('upload');
//        $error_bag = [];
//        foreach (is_array($files) ? $files : [$files] as $file)
//        {
//            $new_filename = $this->uploadFile($file, $request);
//        }
//
//        $response = $this->useFile($new_filename);
//
//        return $response;
//    }

//    /**
//     * Automatically populates the URL field on CKEditor after
//     * a successful upload.
//     *
//     * @param $new_filename
//     * @return string
//     */
//    private function useFile($new_filename)
//    {
//        $file = url("/image/original/blog/".$new_filename);
//
//        return "<script type='text/javascript'>
//
//        function getUrlParam(paramName) {
//            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
//            var match = window.location.search.match(reParam);
//            return ( match && match.length > 1 ) ? match[1] : null;
//        }
//
//        var funcNum = getUrlParam('CKEditorFuncNum');
//
//        var par = window.parent,
//            op = window.opener,
//            o = (par && par.CKEDITOR) ? par : ((op && op.CKEDITOR) ? op : false);
//
//        if (op) window.close();
//        if (o !== false) o.CKEDITOR.tools.callFunction(funcNum, '$file');
//        </script>";
//    }
}
