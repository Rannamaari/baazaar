<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $icon = null,
        public string $size = 'w-8 h-8',
        public string $class = ''
    ) {
        //
    }

    /**
     * Check if the icon is an emoji
     */
    public function isEmoji(): bool
    {
        if (! $this->icon) {
            return false;
        }

        // Check if the icon contains emoji characters
        // Emojis are typically in the Unicode ranges:
        // U+1F600-U+1F64F (Emoticons)
        // U+1F300-U+1F5FF (Misc Symbols and Pictographs)
        // U+1F680-U+1F6FF (Transport and Map)
        // U+1F700-U+1F77F (Alchemical Symbols)
        // U+1F780-U+1F7FF (Geometric Shapes Extended)
        // U+1F800-U+1F8FF (Supplemental Arrows-C)
        // U+1F900-U+1F9FF (Supplemental Symbols and Pictographs)
        // U+1FA00-U+1FA6F (Chess Symbols)
        // U+1FA70-U+1FAFF (Symbols and Pictographs Extended-A)
        // U+2600-U+26FF (Miscellaneous Symbols)
        // U+2700-U+27BF (Dingbats)

        $code = mb_ord($this->icon);

        // Check for common emoji ranges
        return
            ($code >= 0x1F600 && $code <= 0x1F64F) || // Emoticons
            ($code >= 0x1F300 && $code <= 0x1F5FF) || // Misc Symbols and Pictographs
            ($code >= 0x1F680 && $code <= 0x1F6FF) || // Transport and Map
            ($code >= 0x1F700 && $code <= 0x1F77F) || // Alchemical Symbols
            ($code >= 0x1F780 && $code <= 0x1F7FF) || // Geometric Shapes Extended
            ($code >= 0x1F800 && $code <= 0x1F8FF) || // Supplemental Arrows-C
            ($code >= 0x1F900 && $code <= 0x1F9FF) || // Supplemental Symbols and Pictographs
            ($code >= 0x1FA00 && $code <= 0x1FA6F) || // Chess Symbols
            ($code >= 0x1FA70 && $code <= 0x1FAFF) || // Symbols and Pictographs Extended-A
            ($code >= 0x2600 && $code <= 0x26FF) ||   // Miscellaneous Symbols
            ($code >= 0x2700 && $code <= 0x27BF);      // Dingbats
    }

    /**
     * Get the default icon
     */
    public function getDefaultIcon(): string
    {
        return '📦';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-icon');
    }
}
