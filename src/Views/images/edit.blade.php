@extends(config("laravel-blog.view_layout", "laravel-blog::layout"))

@section(config("laravel-blog.view_content", "content"))

    <div class="row">

        <div class="col-sm-12">

            <h3>Edit Image</h3>

            @include("laravel-blog::actions")

            <form action="{{ blogUrl("images/$image->id") }}" method="post" id="image-upload-form">
                {{ csrf_field() }} {{ method_field("PATCH") }}

                <input type="hidden" name="image_id" value="{{ $image->id }}" />

                <div class="row">
                    <div class="col-sm-4 edit-image-form">
                        <img src="{{ $image->getUrl() }}" alt="" />
                    </div> <!-- End .col-sm-4 -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="caption" class="control-label">Image Caption</label>
                            <input type="text" id="caption" name="caption" class="form-control" value="{{ $image->caption }}" />
                        </div>

                        <div class="form-group">
                            <label for="alt" class="control-label">Alt Text</label>
                            <input type="text" id="alt" name="alt_text" class="form-control" value="{{ $image->alt_text }}" />
                        </div>
                    </div> <!-- End .col-sm-4 -->
                </div> <!-- End .row -->

                <div class="text-right">
                    <button class="btn btn-success">Update</button>
                </div>

            </form>

        </div> <!-- End .col-sm-12 -->

    </div> <!-- End .row -->

@endsection