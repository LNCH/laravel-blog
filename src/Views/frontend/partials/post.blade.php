<article class="post">

    <figure class="post-image">
        @if($post->featuredImage)
            <img src="{{ $post->featuredImage->getUrl() }}" alt="{{ $post->featuredImage->alt_text }}" />
        @endif
    </figure> <!-- End .post-image -->

    <div class="post-details">

        <header>
            <a href="{{ $post->url }}">
                <h1 class="post-title">
                    {{ $post->title }}
                </h1>
            </a>

            <div class="post-meta">
                Posted on {{ $post->published_at->format("jS F, Y") }} at {{ $post->published_at->format("H:i") }}
                @if (config("laravel-blog.comments.enabled") && $post->commentsCount)
                    - {{ $post->commentsCount }} comments
                @endif
            </div>
        </header>

        <p>{{ $post->getBriefContent() }}</p>

        <div class="text-right">
            <a href="{{ $post->url }}">Read More</a>
        </div>

    </div> <!-- End .post-details -->

</article>
