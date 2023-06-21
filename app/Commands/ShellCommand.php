<?php

namespace App\Commands;

class ShellCommand extends Command
{
    protected $signature = 'shell {--host}';

    protected $description = 'Start a remote shell';

    public function handle(): void
    {
        if (
            !$this->option('host')
            && $this->shouldRunInContainer()
        ) {
            $this->composeCmd([$this->config->get('container.shell', 'bash')])->run();
        } else {
            $this->remoteCmd([$this->config->get('shell', 'bash')])->run();
        }
    }
}
