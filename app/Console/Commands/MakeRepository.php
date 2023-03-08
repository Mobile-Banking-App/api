<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;


class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function repoPath($repo)
    {
        $repo = str_replace('.','/',$repo). '.php';

        $path = 'app/Http/Repositories/'.$repo;

        return $path;
    }

    public function createDir($path)
    {
        $dir = dirname($path);

        if (! file_exists($dir)) {

            mkdir($dir,0777,true);
        }
    }

    public function handle()
    {
        $repo = $this->argument('repo');

        $path = $this->repoPath($repo);

        $this->createDir($path);

        if (File::exists($path)) {

            $this->error('Repository already exists!');

            return;
        }

        $class = explode('/', $repo);
        $class_path = array_pop($class);
        $class = implode("\\", $class);

        $write = "<?php
namespace App\Http\Repositories\\".$class.";

class ".$class_path."
{
    public function handle()
    {
        // add code...
    }
}";

        File::put($path, $write);

        $this->info('Repository created successfully!');
    }
}
