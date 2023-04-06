<h1>
    <a {{ $attributes->merge(['class' => '']) }}>
        {{ $article->title }}
    </a>
</h1>

Posted: <x-timestamp :timestamp="$article->created_at"></x-timestamp> by
<a href="{{ route('api.users.show', ['user' => $article->user]) }}">
    {{ $article->user->name }}
</a>

<p>{{ $article->content }}</p>

{{ $slot }}

@if (!$article->comments->isEmpty())
    <p>Comments:</p>

    <ul>
        <li>
            @foreach ($article->comments as $comment)
                <x-comment-card
                    :comment="$comment" />
            @endforeach
        </li>
    </ul>
@else
    No comments.
@endif
