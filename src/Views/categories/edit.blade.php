@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">
        <div class="col-sm-5">
            <h3>Edit Category</h3>
            @include("laravel-blog::categories.form")
        </div> <!-- End .col-sm-12 -->
    </div> <!-- End .row -->

@endsection
