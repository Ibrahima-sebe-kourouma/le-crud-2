<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Blade template.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $view = $this->argument('view');
        $path = $this->viewPath($view);

        // Ensure the directory exists
        $this->createDir($path);

        // Check if the file already exists
        if (File::exists($path)) {
            $this->error("File {$path} already exists!");
            return;
        }

        // Create the Blade template file
        File::put($path, '');
        $this->info("File {$path} created.");
    }

    /**
     * Get the full view path.
     *
     * @param string $view
     * @return string
     */
    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';
        $path = resource_path("views/{$view}");
        return $path;
    }

    /**
     * Create the view directory if it does not exist.
     *
     * @param string $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0777, true);
        }
    }
}
