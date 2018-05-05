@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">
        <div class="col-md-9">

            @foreach($posts as $post)
                @include("laravel-blog::frontend.partials.post")
            @endforeach

            <div style="text-align: center;">
                {{ $posts->links() }}
            </div>

        </div>
    </div>

@endsection