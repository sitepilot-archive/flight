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

        $host = $this->ask('Remote host');
        $port = $this->ask('Remote port', 22);
        $user = $this->ask('Remote user', 'captain');
        $path = $this->ask('Remote path', '~/code/' . basename(getcwd()));

        if (!File::exists($file)) {
            File::put($file,
                Yaml::dump([
                    'host' => $host,
                    'port' => (int)$port,
                    'user' => $user,
                    'path' => $path,
                    'sync' => [
                        'ignore' => [
                            '.idea', '.fleet', '.vscode', '.DS_Store', 'flight.yml', 'node_modules'
                        ]
                    ],
                ], 99, 2));

            $this->info("Flight configuration initialized!");
        } else {
            $this->abort('A flight configuration file already exists.');
        }
    }
}
