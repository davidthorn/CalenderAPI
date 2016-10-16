<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Process\Process;

class ApiDocCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:makedoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates api documentation blueprint';

    public function handle()
    {
        $apiDocPath = storage_path('apidoc');
        $modulesPath = base_path('resources/apidoc');

        $cmd = "apidoc -i {$modulesPath} -o {$apiDocPath} --debug";

        $this->output->note($cmd);
        $process = new Process($cmd);

        $process->run();

        echo $process->getOutput();
    }
}
