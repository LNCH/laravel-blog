<ul class="lnch-blog_comments">
    @foreach($comments as $comment)
        <li>
            <div class="lnch-blog_post-comment">
                <div class="comment-meta">
                    Posted by
                    <span class="user">
                        @if($comment->user) {{ $comment->user->name }} @else {{ $comment->name }} @endif
                    </span>
                    on
                    <span class="date">{{ $comment->created_at->format("jS F, Y") }} </span>
                    at <span class="time">{{ $comment->created_at->format("h:ia") }}</span>

                    <a href="?reply={{ $comment->id }}#comments-form" class="reply-link">Reply</a>
                </div>

                {{ $comment->body }}
            </div>

            @if(count($comment->replies))
                @include("laravel-blog::frontend.partials.comments", ['comments' => $comment->replies])
            @endif
        </li>
    @endforeach
</ul> <!-- End .comments -->
