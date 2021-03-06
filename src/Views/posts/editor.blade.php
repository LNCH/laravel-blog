@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-12">
            <h3>{{ isset($post) ? 'Edit' : 'New' }} {{ config("laravel-blog.taxonomy", "Blog") }} Post</h3>
            <hr />

            @include("laravel-blog::actions")

            @include("laravel-blog::posts.form")
        </div>

    </div> <!-- End .row -->

    {!! LaravelBlog::initCKEditor() !!}

@endsection