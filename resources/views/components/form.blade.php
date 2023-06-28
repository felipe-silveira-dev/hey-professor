@props(['action', 'post' => null, 'put' => null, 'delete' => null, 'patch' => null])

<form action="{{ $action }}" method="post" {{ $attributes }}>
    @csrf
    @if ($put)
        @method('put')
    @endif

    @if ($patch)
        @method('patch')
    @endif

    @if ($delete)
        @method('delete')
    @endif

    {{ $slot }}
</form>
