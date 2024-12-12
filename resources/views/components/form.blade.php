@props([
    'post'=>null,
    'delete'=>null,
    'flat'=> false,
])

@php
    $method = ($post || $delete) ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['gap-4 flex flex-col' => ! $flat]) }} method="{{ $method }}">
    @if($method != 'GET')
        @csrf
    @endif

    @if($delete)
        @method('delete')
    @endif

    {{ $slot }}
</form>