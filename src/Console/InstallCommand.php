<?php

namespace Nubix\Toast\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nubix-toast:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Nubix toast notification resources';

    /**
     *  Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateNodePackages(fn ($packages) => [
            'mitt' => '^3.0.0',
            'uuid' => '^3.4.0'
        ] + $packages, false);

        // publish config
        copy(__DIR__.'/../../config/toast.php', config_path('toast.php'));

        // publish vue components
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs', resource_path('js/'));

        // update app.js to use plugin
        //        $this->replaceInFile('createInertiaApp({', "import toastPlugin from '@/Plugins/toast'\n\ncreateInertiaApp({", resource_path('js/app.js'));
        //        $this->replaceInFile('.use(plugin)', ".use(plugin)\n\t\t\t.use(toastPlugin)", resource_path('js/app.js'));

        $this->info('Nubix toast notification installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    protected function replaceInFile($search, $replace, $path, $check = null)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Update the "package.json" file.
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
