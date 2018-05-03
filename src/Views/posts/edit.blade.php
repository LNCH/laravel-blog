@extends('admin.layout')
@section("title", "Edit Blog Post")

@section('main_content')
    @include('partials.action_result')

    <div class="row">

        <div class="col-sm-12">
            <h3>Edit Blog Post</h3>
            <hr />
        </div>

        @include("admin.blog.form")

    </div> <!-- End .row -->

@endsection

@push("foot")
    <script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>
    <script>
        var ckOptions = {
            filebrowserImageBrowseUrl: '/admin/blog/images?embed=true',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            customConfig: '/js/ckeditor_config.js'
        }

        CKEDITOR.replace("post_content", ckOptions);

        $('#post_published_at').flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: 'd/m/Y H:i'
        });
    </script>
@endpush