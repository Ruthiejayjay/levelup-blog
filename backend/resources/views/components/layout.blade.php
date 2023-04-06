<!DOCTYPE html>

<a href="{{ route('home') }}">
    LevelUp Blog
</a>

@isset($head)

    <head>
        {{ $head }}
    </head>
@endisset


<body>
    {{ $slot }}
</body>
