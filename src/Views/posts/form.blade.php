<form action="{{ isset($post) ? blogUrl("posts/$post->id") : blogUrl("posts") }}" method="post" class="row">
    {{ csrf_field() }} {{ method_field(isset($post) ? "PATCH" : "POST") }}

    @if(isset($post))
        <input type="hidden" name="post_id" value="{{ $post->id }}" />
    @endif

    <div class="col-sm-9">

        <div class="row">

            <div class="col-sm-8">
                <div class="form-group">
                    <label for="post_title" class="control-label">Post Title</label>
                    <input type="text" class="form-control" name="title"
                           id="post_title" required value="{{ old("title", isset($post) ? $post->title : "") }}" />
                </div>
            </div> <!-- End .col-sm-8 -->

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="post_slug" class="control-label">URL Slug</label>
                    <input type="text" class="form-control" name="slug"
                           id="post_slug" value="{{ old("slug", isset($post) ? $post->slug : "") }}" />
                </div>
            </div> <!-- End .col-md-4 -->

        </div> <!-- End .row -->

        <div class="form-group">
            <textarea name="post_content" id="post_content" rows="10" class="form-control" style="resize: none;">{{--
            --}}{{ old("post_content", isset($post) ? $post->content : "") }}{{--
            --}}</textarea>
        </div>

    </div> <!-- End .col-sm-9 -->

    <div class="col-sm-3">

        <div class="laravel-blog-sidebar-block">
            <div class="title">Post Settings</div>
            <div class="content">

                <div class="form-group published_at_container">
                    <label for="post_title" class="control-label">Publish Date</label>
                    <input type="datetime-local" class="form-control" name="published_at"
                           id="post_published_at"
                           value="{{ old("published_at", isset($post) ? $post->publishedAtTimestamp : "") }}" />
                </div>

                <div class="form-group">
                    <label for="post_status" class="control-label">Status</label>
                    <select name="status" id="post_status" class="form-control">
                        @foreach(\Lnch\LaravelBlog\Models\BlogPost::statuses() as $status => $label)
                            <option value="{{ $status }}" @if(isset($post) && $post->status == $status) selected @endif>
                                {{ $label }}
                            </option>>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="post_status" for="post_is_featured" class="control-label">
                        <input type="checkbox" name="is_featured" id="post_is_featured"
                               value="1" @if(isset($post) && $post->is_featured) checked @endif /> Featured Post
                    </label>
                </div>

                <div class="form-group">
                    <label for="post_comments" class="control-label">Comments</label>
                    <select name="comments_enabled" id="post_comments" class="form-control">
                        <option value="0" @if(isset($post) && $post->comments_enabled == 0) selected @endif>Disabled</option>
                        <option value="1" @if(isset($post) && $post->comments_enabled == 1) selected @endif>Enabled</option>
                    </select>
                </div>

                <hr>

                <div class="form-group">
                    @if(isset($post) && config("laravel-blog.allow_post_previewing", true))
                        <a href="{{ blogUrl("$post->id/$post->slug", true) }}" target="_blank"
                           class="btn btn-block btn-primary">Preview Post</a>
                    @endif
                    <button class="btn btn-block btn-success">Save Post</button>
                </div>

            </div>
        </div> <!-- End .laravel-blog-sidebar-block -->

        @if(config("laravel-blog.images.enabled"))
            <div class="laravel-blog-sidebar-block">
                <div class="title">Featured Image</div>
                <div class="content">
                    <div id="featured-image-container">
                        @if(isset($post) && $post->featuredImage)
                            <img src="{{ $post->featuredImage->getUrl() }}" alt="" />
                        @endif
                    </div>
                    <input type="hidden" id="featured_image" name="blog_image_id" value="{{ isset($post) ? $post->blog_image_id : null }}" />
                    <button type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal"
                            data-target="#featured-image">Choose Image</button>
                </div> <!-- End .content -->
            </div> <!-- End .laravel-blog-sidebar-block -->
        @endif

        @if(config("laravel-blog.categories.enabled"))
            <div class="laravel-blog-sidebar-block">
                <div class="title">Category</div>
                <div class="content">

                    <div class="form-group">
                        <select name="category" id="post_category" class="form-control">
                            <option value="0"></option>
                            @foreach(\Lnch\LaravelBlog\Models\BlogCategory::all() as $category)
                                <option @if(isset($post) && $post->hasCategory($category)) class="hidden" @endif
                                    value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h5>Current Categories (click to remove)</h5>

                    <div class="existing-categories">
                        @if(isset($post))
                            @foreach($post->categories as $category)
                                <span class="label label-info tag-label">
                                    <a class="existing-category" href="#" data-id="{{ $category->id }}">{{ $category->name }}</a>
                                    <input type="hidden" name="category[{{ $category->id }}]" value="{{ $category->id }}" />
                                </span>
                            @endforeach
                        @endif
                    </div>

                </div> <!-- End .content -->
            </div> <!-- End .laravel-blog-sidebar-block -->
        @endif

        @if(config("laravel-blog.tags.enabled"))
            <div class="laravel-blog-sidebar-block">
                <div class="title">Tags</div>
                <div class="content">

                    <div class="form-group">
                        <p>Enter tags separated by a comma</p>
                        <input type="text" class="form-control" name="tags" id="post_tags" />
                    </div>

                    @if(isset($post) && count($post->tags))
                        <h5>Current Tags (click to remove)</h5>

                        @foreach($post->tags as $tag)
                            <span class="label label-info tag-label">
                                <a class="existing-tag" href="#">{{ $tag->name }}</a>
                                <input type="hidden" name="tag[{{ $tag->id }}]" value="{{ $tag->name }}" />
                            </span>
                        @endforeach
                    @endif

                </div> <!-- End .content -->
            </div> <!-- End .laravel-blog-sidebar-block -->
        @endif

    </div> <!-- End .col-sm-3 -->

</form>

<!-- Modal -->
<div class="modal fade" id="featured-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <iframe src="{{ blogUrl("images?laravel-blog-embed=true&laravel-blog-featured=true") }}" frameborder="0"
                        style="width: 100%; height: 500px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
