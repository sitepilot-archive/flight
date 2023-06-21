<?php

namespace App\Commands;

class DownCommand extends Command
{
    protected $signature = 'down';

    protected $description = 'Stop and remove containers';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $this->assertComposeProject();

        $this->remoteCmd("docker compose {$this->input->__toString()}")->run();
    }
}
