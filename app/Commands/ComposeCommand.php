<?php

namespace App\Commands;

class ComposeCommand extends Command
{
    protected $signature = 'compose';

    protected $description = 'Run Docker Compose command';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $this->assertComposeProject();

        $this->remoteCmd("docker {$this->input->__toString()}")->run();
    }
}
