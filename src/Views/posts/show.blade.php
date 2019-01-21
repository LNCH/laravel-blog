@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-6">
            <h3>{{ $post->title }}</h3>
        </div> <!-- End .col-sm-6 -->
        <div class="col-sm-6 text-right" style="padding-top: 1.5rem;">
            <a href="{{ blogUrl("posts/$post->id/edit") }}" class="btn btn-primary">Edit Post</a>
        </div>

        <div class="col-sm-12">

            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Slug</td>
                            <td>{{ $post->slug }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $post->status }}</td>
                        </tr>
                        <tr>
                            <td>Content</td>
                            <td>{{ $post->content }}</td>
                        </tr>
                        <tr>
                            <td>Published</td>
                            <td>{{ $post->published }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- End .table-responsive -->
        </div> <!-- End .col-sm-12 -->

    </div> <!-- End .row -->

@endsection
