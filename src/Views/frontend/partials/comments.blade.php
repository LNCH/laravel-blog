<ul class="lnch-blog_comments" id="post-comments">
    @foreach($post->comments as $comment)
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
                </div>

                {{ $comment->body }}
            </div>
        </li>
    @endforeach
</ul> <!-- End .comments -->
