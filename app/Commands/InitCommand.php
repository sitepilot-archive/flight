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
                    'remote' => [
                        'host' => '',
                        'port' => 22,
                        'user' => 'root',
                        'path' => ''
                    ]
                ], 99, 2));
        } else {
            $this->abort('A flight configuration file already exists.');
        }
    }
}
