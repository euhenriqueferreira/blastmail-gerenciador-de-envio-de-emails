@props([
    'post'=>null,
    'put'=>null,
    'delete'=>null,
    'flat'=> false,
])

@php
    $method = ($post || $delete || $put) ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['gap-4 flex flex-col' => ! $flat]) }} method="{{ $method }}">
    @if($method != 'GET')
        @csrf
    @endif

    @if($delete)
        @method('delete')
    @endif

    @if($put)
        @method('put')
    @endif

    {{ $slot }}
</form>