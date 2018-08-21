<html>
    <head>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset("vendor/lnch/laravel-blog/css/styles.css") }}" />

    </head>

    <body>

        @if(!Request::get("laravel-blog-embed", false))
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <p class="navbar-brand" style="margin: 0;">
                                <a href="{{ blogUrl("", true) }}">
                                    Laravel Blog
                                </a>
                            </p>

                            <ul class="nav navbar-nav">
                                <li><a href="{{ blogUrl("posts") }}">Posts</a></li>
                                <li><a href="{{ blogUrl("posts/scheduled") }}">Scheduled Posts</a></li>
                                <li><a href="{{ blogUrl("comments") }}">Comments</a></li>
                                <li><a href="{{ blogUrl("categories") }}">Categories</a></li>
                                <li><a href="{{ blogUrl("tags") }}">Tags</a></li>
                                <li><a href="{{ blogUrl("images") }}">Images</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </nav>
        @endif

        <div class="container">
            @yield("content")
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>

        <script src="{{ asset("vendor/lnch/laravel-blog/js/blog.js") }}"></script>

    </body>
</html>