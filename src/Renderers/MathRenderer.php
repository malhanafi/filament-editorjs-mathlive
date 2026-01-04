<?php

namespace Malhanafi\FilamentEditorjs\Renderers;

class MathRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $latex = $data['latex'] ?? '';
        $escapedLatex = $this->escape($latex);

        return view('filament-editorjs-mathlive::renderers.math', [
            'latex'   => $escapedLatex,
            'config' => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'math';
    }
}
