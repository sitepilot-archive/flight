<?php

namespace App\Commands;

use Symfony\Component\VarDumper\VarDumper;

class ConfigCommand extends Command
{
    protected $signature = 'config';

    protected $description = 'Show Flight configuration';

    public function handle(): void
    {
        VarDumper::dump($this->config->all());
    }
}
