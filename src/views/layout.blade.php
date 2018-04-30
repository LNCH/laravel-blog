<html>
    <head>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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

    </body>
</html>