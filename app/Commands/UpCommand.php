<?php

namespace App\Commands;

class UpCommand extends Command
{
    protected $signature = 'up';

    protected $description = 'Create and start containers';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $this->assertComposeProject();

        $this->askForEnv();

        $this->remoteCmd("docker compose {$this->input->__toString()}")->run();
    }
}
