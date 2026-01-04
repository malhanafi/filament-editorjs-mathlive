<?php

namespace Malhanafi\FilamentEditorjs\Renderers;

class DelimiterRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        return view('filament-editorjs-mathlive::renderers.delimiter', [
            'config' => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'delimiter';
    }
}
