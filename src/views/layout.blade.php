<html>
    <head>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    </head>

    <body>

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <p class="navbar-brand" style="margin: 0;">Laravel Blog</p>

                        <ul class="nav navbar-nav">
                            <li><a href="{{ blogUrl("posts") }}">Posts</a></li>
                            <li><a href="{{ blogUrl("comments") }}">Comments</a></li>
                            <li><a href="{{ blogUrl("categories") }}">Categories</a></li>
                            <li><a href="{{ blogUrl("tags") }}">Tags</a></li>
                            <li><a href="{{ blogUrl("images") }}">Images</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>

        @if (isset($errors) && $errors->count() > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach (array_unique($errors->all()) as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (session('error') || isset($error) )
            <div class="alert alert-error">
                {{ $error or session('error') }}
            </div>
        @elseif (session('message') || isset($message))
            <div class="alert alert-success">
                {{ $message or session('message') }}
            </div>
        @elseif (session('success') || isset($success))
            <div class="alert alert-success">
                {{ $success or session('success') }}
            </div>
        @endif

        <div class="container">
            @yield("content")
        </div>

        <script src="{{ asset("vendor/lnch/laravel-blog/blog.js") }}"></script>

    </body>
</html>