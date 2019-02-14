<aside class="post-commments" id="comments-form">
    @if(!$post->comments_enabled)
        <p>Comments have been disabled for this post</p>
    @elseif(!config("laravel-blog.comments.allow_guests") && !Auth::check())
        <p>You must be signed in to leave a comment</p>
    @else
        @if($replyTo)
            <h2>Reply to @if($replyTo->user) {{ $replyTo->user->name }} @else {{ $replyTo->name }} @endif</h2>
        @else
            <h2>Leave a Comment</h2>
        @endif

        <form action="{{ blogUrl("$post->id/comments", true) }}" method="post">
            {{ csrf_field() }} {{ method_field("POST") }}

            <input type="hidden" name="parent_id" value="{{ $replyTo ? $replyTo->id : null }}" />

            @if(!Auth::check())
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Your Name</label>
                            <input type="text" class="form-control" name="name" id="name" required value="{{ old("name") }}" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label">Your Email</label>
                            <input type="email" class="form-control" name="email" id="email" required value="{{ old("email") }}" />
                        </div>
                    </div>
                </div>
            @else
                <p>Commenting as <strong>{{ auth()->user()->name }}</strong></p>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="comment" class="control-label">Your @if($replyTo) Reply @else Comment @endif</label>
                        <textarea name="comment" id="comment" rows="6" class="form-control">{{ old("comment") }}</textarea>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">Submit @if($replyTo) Reply @else Comment @endif</button>

        </form>
    @endif
</aside>
