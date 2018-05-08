@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-6">
            <h3>{{ config("laravel-blog.taxonomy", "Blog") }} Categories</h3>
        </div> <!-- End .col-sm-6 -->
        <div class="col-sm-6 text-right" style="padding-top: 1.5rem;">
            <a href="{{ blogUrl("categories/create") }}" class="btn btn-primary">New Category</a>
        </div>

        <div class="col-sm-12">

            @include("laravel-blog::actions")

            <div class="table-responsive">
                <table class="table table-striped">
                    <colgroup>
                        <col style="width: 20%;">
                        <col style="width: 50%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Usages</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ count($category->posts) }}</td>
                            <td>
                                @can("edit", $category)
                                    <a href="{{ blogUrl("categories/$category->id/edit") }}" class="btn btn-sm btn-primary">Edit</a>
                                @endcan

                                @can("delete", $category)
                                    <form action="{{ blogUrl("categories/$category->id") }}" method="post" class="form-inline confirm-delete">
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
                {{ $categories->links() }}
            </div>

        </div> <!-- End .col-sm-12 -->

    </div> <!-- End .row -->

@endsection
