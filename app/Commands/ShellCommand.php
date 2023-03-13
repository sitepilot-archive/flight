<?php

namespace App\Commands;

use Exception;

class ShellCommand extends Command
{
    protected $signature = 'shell {--host}';

    protected $description = 'Start a remote shell';

    public function handle(): void
    {
        try {
            if (
                !$this->option('host')
                && $this->shouldRunInContainer()
            ) {
                $this->composeCmd([$this->config->get('container.shell', 'bash')])->mustRun();
            } else {
                $this->remoteCmd([$this->config->get('remote.shell', 'bash')])->run();
            }
        } catch (Exception) {
            //
        }
    }
}
