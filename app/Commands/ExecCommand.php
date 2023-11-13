<?php

namespace App\Commands;

class ExecCommand extends Command
{
    protected $signature = 'exec';

    protected $description = 'Execute a remote command';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $command = explode(" ", $this->input->__toString());

        unset($command[0]); // remove exec

        $this->remoteCmd($command)->run();
    }
}
