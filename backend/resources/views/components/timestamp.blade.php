@props(['timestamp'])

<time datetime="{{ $timestamp }}">
    {{ $timestamp->diffForHumans() }}
</time>
