<?php

namespace App\Commands;

class ShellCommand extends Command
{
    protected $signature = 'shell';

    protected $description = 'Start a remote shell';

    public function handle(): void
    {
        $this->remoteCmd([$this->config->get('shell', 'bash')])->run();
    }
}
