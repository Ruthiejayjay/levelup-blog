{{ $comment->author->name }}
said <x-timestamp
    :timestamp="$comment->created_at">
</x-timestamp>
:
"{{ $comment->content }}"
