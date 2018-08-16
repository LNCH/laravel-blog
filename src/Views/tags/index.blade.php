@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-12">
            <h3>Tags</h3>
        </div> <!-- End .col-sm-12 -->

        @include("laravel-blog::actions")

        <div class="col-sm-3">
            @include("laravel-blog::tags.form")
        </div> <!-- End .col-sm-3 -->

        <div class="col-sm-9">

            <div class="table-responsive">
                <table class="table table-striped">
                    <colgroup>
                        <col style="width: 40%;">
                        <col style="width: 40%;">
                        <col style="width: 20%;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Usages</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>{{ count($tag->posts) }}</td>
                            <td>
                                @can("edit", $tag)
                                    <a href="{{ blogUrl("tags/$tag->id/edit") }}" class="btn btn-sm btn-primary">Edit</a>
                                @endcan

                                @can("delete", $tag)
                                    <form action="{{ blogUrl("tags/$tag->id") }}" method="post" class="form-inline confirm-delete">
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
                {{ $tags->links() }}
            </div>

        </div> <!-- End .col-sm-9 -->

    </div> <!-- End .row -->

@endsection