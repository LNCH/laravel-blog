@foreach($post->comments as $comment)
    <div class="lnch-blog_post-comment">
        Posted by
        @if($comment->user) {{ $comment->user->name }} @else {{ $comment->name }} @endif
        on {{ $comment->created_at->format("jS F, Y") }} at {{ $comment->created_at->format("h:ia") }}
        <br /><br />
        {{ $comment->body }}
    </div>
@endforeach
