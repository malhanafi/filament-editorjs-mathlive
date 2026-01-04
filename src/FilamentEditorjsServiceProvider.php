<?php

namespace Malhanafi\FilamentEditorjs;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentEditorjsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-editorjs-mathlive';

    public static string $viewNamespace = 'filament-editorjs-mathlive';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('malhanafi/filament-editorjs-mathlive');
            });

        if (file_exists($package->basePath('/../config/filament-editorjs-mathlive.php'))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-editorjs-mathlive/{$file->getFilename()}"),
                ], 'filament-editorjs-mathlive-stubs');
            }
        }

        $this->publishes([
            __DIR__ . '/../resources/js/filament-editorjs-mathlive-extensions.stub.js' => resource_path('js/filament-editorjs-mathlive-extensions.js'),
        ], 'filament-editorjs-mathlive-extensions');

        $this->registerRendererManager();
    }

    protected function registerRendererManager(): void
    {
        $this->app->singleton('filament-editorjs-mathlive-renderer', function ($app) {
            $manager = new Renderers\BlockRendererManager([
                'wrapper_template' => 'filament-editorjs-mathlive::renderers.content-wrapper',
            ]);

            // Register default renderers
            $manager->addRenderer(new Renderers\HeaderRenderer());
            $manager->addRenderer(new Renderers\ImageRenderer());
            $manager->addRenderer(new Renderers\ListRenderer());
            $manager->addRenderer(new Renderers\ParagraphRenderer());
            $manager->addRenderer(new Renderers\QuoteRenderer());
            $manager->addRenderer(new Renderers\CodeRenderer());
            $manager->addRenderer(new Renderers\TableRenderer());
            $manager->addRenderer(new Renderers\DelimiterRenderer());
            $manager->addRenderer(new Renderers\RawRenderer());
            $manager->addRenderer(new Renderers\InlineCodeRenderer());
            $manager->addRenderer(new Renderers\ChecklistRenderer());
            $manager->addRenderer(new Renderers\MathRenderer());

            return $manager;
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'malhanafi/filament-editorjs-mathlive';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('filament-editorjs-mathlive-styles', __DIR__ . '/../resources/dist/filament-editorjs-mathlive.css'),
            Js::make('filament-editorjs-mathlive-scripts', __DIR__ . '/../resources/dist/filament-editorjs-mathlive.js'),
            Js::make('filament-editorjs-mathlive-js', 'https://unpkg.com/mathlive@latest/mathlive.min.js'),
            Css::make('filament-editorjs-mathlive-fonts', 'https://unpkg.com/mathlive@latest/mathlive-fonts.css'),
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }
}
