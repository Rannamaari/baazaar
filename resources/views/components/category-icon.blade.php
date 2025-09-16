@if($isEmoji())
    <span class="{{ $size }} {{ $class }} flex items-center justify-center text-2xl">
        {{ $icon }}
    </span>
@elseif($icon)
    @try
        <x-dynamic-component :component="'lucide-' . $icon" class="{{ $size }} {{ $class }}" />
    @catch
        <span class="{{ $size }} {{ $class }} flex items-center justify-center text-2xl">
            {{ $getDefaultIcon() }}
        </span>
    @endtry
@else
    <span class="{{ $size }} {{ $class }} flex items-center justify-center text-2xl">
        {{ $getDefaultIcon() }}
    </span>
@endif