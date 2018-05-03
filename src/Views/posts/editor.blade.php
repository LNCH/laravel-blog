@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-12">
            <h3>{{ isset($post) ? 'Edit' : 'New' }} Blog Post</h3>
            <hr />
        </div>

        @include("laravel-blog::posts.form")

    </div> <!-- End .row -->

    <script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>
    <script>
        var ckOptions = {
            filebrowserImageBrowseUrl: '{{ blogUrl('images?embed=true') }}',
            filebrowserImageUploadUrl: '{{ blogUrl('images/dialog-upload?_token='.csrf_token()) }}'
        }

        @if(config("laravel-blog.posts.ckeditor.custom_config", null))
            ckOptions.customConfig = '{{ config("laravel-blog.posts.ckeditor.custom_config") }}';
        @endif

        CKEDITOR.replace("post_content", ckOptions);
    </script>

@endsection