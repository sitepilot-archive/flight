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
            $config = [
                'host' => $this->ask('Remote project host'),
                'port' => (int)$this->ask('Remote SSH port', 22),
                'user' => $this->ask('Remote SSH user', 'captain'),
                'path' => $this->ask('Remote project path', '~/code/' . basename(getcwd()))
            ];

            File::put($file,
                Yaml::dump(array_merge($config, [
                    'sync' => [
                        'ignore' => [
                            '.idea', '.fleet', '.vscode', '.DS_Store', 'flight.yml', 'node_modules'
                        ]
                    ],
                ]), 99, 2));

            $this->info("Flight configuration initialized!");
        } else {
            $this->abort('Flight configuration file already exists.');
        }
    }
}
