<?php

namespace App\Commands;

class ArtisanCommand extends Command
{
    protected $signature = 'artisan';

    protected $description = 'Run Artisan command';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $this->assertLaravelProject();

        $command = explode(" ", $this->input->__toString());

        $command = array_merge(['php'], $command);

        if ($this->shouldRunInContainer()) {
            $this->composeCmd($command)->run();
        } else {
            $this->remoteCmd($command)->run();
        }
    }
}
