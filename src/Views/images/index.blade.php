@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row header">

        <div class="col-sm-6">
            <h3>{{ config("laravel-blog.taxonomy", "Blog") }} Images</h3>
        </div> <!-- End .col-sm-6 -->

        <div class="col-sm-6 text-right" style="padding-top: 1.5rem;">
            @if(Request::get("laravel-blog-embed", false) && Request::get("laravel-blog-featured", false))
                <a href="{{ blogUrl("images/create?laravel-blog-embed=true&laravel-blog-featured=true") }}" class="btn btn-primary btn-sm">
                    Upload Images
                </a>
            @elseif(Request::get("laravel-blog-embed", false))
                <a href="{{ blogUrl("images/create?laravel-blog-embed=true") }}" class="btn btn-primary btn-sm">
                    Upload Images
                </a>
            @else
                <a href="{{ blogUrl("images/create") }}" class="btn btn-primary">
                    Upload Images
                </a>
            @endif
        </div>

    </div> <!-- End .row -->

    <div class="row">
        <div class="col-sm-12">

            @include("laravel-blog::actions")

            <div class="images-flex">
                @forelse($images as $image)
                    <div class="image">

                        @if(Request::get("laravel-blog-embed", false))
                            <a href="{{ $image->getUrl() }}" target="_blank" class="ck-select-image"
                               data-url="{{ $image->getUrl() }}" data-alt-text="{{ $image->alt_text }}">
                                <img src="{{ $image->getUrl() }}" alt="">
                            </a>
                        @else
                            <a href="{{ $image->getUrl() }}" target="_blank">
                                <img src="{{ $image->getUrl() }}" alt="">
                            </a>
                        @endif

                        @if(Request::get("laravel-blog-featured", false))
                            <div class="actions text-center">
                                <button class="btn btn-xs btn-primary select-featured" data-id="{{ $image->id }}"
                                    data-url="{{ $image->getUrl() }}" data-alt-text="{{ $image->alt_text }}">
                                    Select
                                </button>
                            </div> <!-- End .actions.text-center -->
                        @elseif(Request::get("laravel-blog-embed", false))
                            <div class="actions text-center">
                                <button class="btn btn-xs btn-primary ck-select-image" data-id="{{ $image->id }}"
                                        data-url="{{ $image->getUrl() }}" data-alt-text="{{ $image->alt_text }}">
                                    Select
                                </button>
                            </div> <!-- End .actions.text-center -->
                        @else
                            <div class="actions text-right">
                                <div class="dropdown">
                                    <button class="btn btn-default btn-xs dropdown-toggle"
                                            type="button" id="dropdownMenu-{{$image->id}}"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu-{{$image->id}}">
                                        <li>
                                            <a href="{{ $image->getUrl() }}" target="_blank">
                                                <i class="fa fa-fw fa-eye"></i>View
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ blogUrl("images/$image->id/edit") }}">
                                                <i class="fa fa-fw fa-pencil"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="copy-url"><i class="fa fa-fw fa-copy"></i>Copy Url</a>
                                            <input type="text" value="{{ $image->getUrl() }}" />
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <form action="{{ blogUrl("images/$image->id") }}" method="post" class="form-inline confirm-delete">
                                                {{ csrf_field() }} {{ method_field("DELETE") }}
                                                <button class="dropdown-button"><i class="fa fa-fw fa-trash"></i>Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div> <!-- End .actions.text-right -->
                        @endif

                    </div>
                @empty
                    <div class="text-muted">
                        No images uploaded yet
                    </div>
                @endforelse
            </div>

            @if($images)
                <div class="text-right">
                    {{ $images->appends([
                        'laravel-blog-embed' => Request::get("laravel-blog-embed", false) ? "true" : "",
                        'laravel-blog-featured' => Request::get("laravel-blog-featured", false) ? "true" : ""
                    ])->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
