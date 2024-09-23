@props([
    'text' => null,
    'icon' => null,
    'action' => false,
    'disabled' => false,
])

<x-chip.layout :disabled="$disabled" {{ $attributes->class(['cursor-pointer']) }}>

    @if($icon)
        <x-dynamic-component component="icon::{{ $icon }}" type="mini" class="w-4.5 h-4.5" />
    @endif

    @if($text)
        <span class="mx-2">{{ $text }}</span>
    @endif

    <x-icon::chevron-down type="mini" class="w-4.5 h-4.5" />

</x-chip.layout>
