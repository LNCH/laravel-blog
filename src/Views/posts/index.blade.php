@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-6">
            <h3>Blog Posts</h3>
        </div> <!-- End .col-sm-6 -->
        <div class="col-sm-6 text-right" style="padding-top: 1.5rem;">
            <a href="{{ blogUrl("posts/create") }}" class="btn btn-primary">New Post</a>
        </div>

        <div class="col-sm-12">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Categories</th>
                            <th>Tags</th>
                            <th>Comments</th>
                            <th>Published</th>
                            <th style="width: 12.5%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                @can("edit", $post)
                                    <a href="{{ blogUrl("posts/$post->id/edit") }}">
                                        {{ $post->title }}
                                    </a>
                                @else
                                    {{ $post->title }}
                                @endcan
                                @if($post->is_featured)
                                    <span class="label label-info" style="margin-left: 0.5rem;">Featured</span>
                                @endif
                            </td>
                            <td>
                                {{ $post->author->name }}
                            </td>
                            <td>
                                {{ \Lnch\LaravelBlog\Models\BlogPost::statuses()[$post->status] }}
                            </td>
                            <td style="font-style: italic; color: grey;">
                                {{ implode(", ", $post->categories()->pluck("name")->toArray()) }}
                            </td>
                            <td style="font-style: italic; color: grey;">
                                {{ implode(", ", $post->tags()->pluck("name")->toArray()) }}
                            </td>
                            <td>
                                @if($post->comments_enabled)
                                    {{-- Comments count --}}
                                @else
                                    <div class="text-muted">Disabled</div>
                                @endif
                            </td>
                            <td>
                                {{ $post->published_at->format("d/m/Y H:i") }}
                            </td>
                            <td>
                                @can("edit", $post)
                                    <a href="{{ blogUrl("posts/$post->id/edit") }}" class="btn btn-sm btn-primary">Edit</a>
                                @endcan

                                @can("delete", $post)
                                    <form action="{{ blogUrl("posts/$post->id") }}" method="post" class="form-inline confirm-delete">
                                        {{ csrf_field() }} {{ method_field("DELETE") }}
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> <!-- End .table-responsive -->

            <div class="text-right">
                {{ $posts->links() }}
            </div>

        </div> <!-- End .col-sm-12 -->

    </div> <!-- End .row -->

@endsection
