<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initialize a new flight project';

    public function handle(): void
    {
        $file = getcwd() . DIRECTORY_SEPARATOR . 'flight.yml';

        if (!File::exists($file)) {
            File::put($file,
                Yaml::dump([
                    'url' => '',
                    'remote' => [
                        'host' => '',
                        'port' => 22,
                        'user' => 'root',
                        'path' => ''
                    ],
                    'sync' => [
                        'ignore' => [
                            '.idea', '.fleet', '.vscode', '.DS_Store', 'flight.yml', 'node_modules'
                        ]
                    ]
                ], 99, 2));
        } else {
            $this->abort('A flight configuration file already exists.');
        }
    }
}
