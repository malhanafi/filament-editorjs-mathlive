<?php

namespace Malhanafi\FilamentEditorjs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Malhanafi\FilamentEditorjs\FilamentEditorjs
 */
class FilamentEditorjs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Malhanafi\FilamentEditorjs\FilamentEditorjs::class;
    }
}
