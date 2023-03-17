<?php

namespace App\Commands;

class WpCommand extends Command
{
    protected $signature = 'wp';

    protected $description = 'Run WPCLI command';

    protected bool $ignoreValidationErrors = true;

    public function handle(): void
    {
        $this->assertWordPressProject();

        $this->askForEnv();

        $command = explode(" ", $this->input->__toString());

        if ($this->shouldRunInContainer()) {
            $this->composeCmd($command)->run();
        } else {
            $this->remoteCmd($command)->run();
        }
    }
}
