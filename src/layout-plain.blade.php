<html>
    <head>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset("vendor/lnch/laravel-blog/css/styles.css") }}" />

    </head>

    <body>

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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>

        <script src="{{ asset("vendor/lnch/laravel-blog/js/blog.js") }}"></script>

    </body>
</html>