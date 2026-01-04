<?php

namespace Malhanafi\FilamentEditorjs\Renderers;

class ParagraphRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $content = $data['text'] ?? '';

        return view('filament-editorjs-mathlive::renderers.paragraph', [
            'content' => $content,
            'config'  => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'paragraph';
    }
}
