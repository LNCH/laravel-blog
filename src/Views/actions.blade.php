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