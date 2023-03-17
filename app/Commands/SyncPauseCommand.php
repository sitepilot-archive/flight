<?php

namespace App\Commands;

use Exception;

class SyncPauseCommand extends Command
{
    protected $signature = 'sync:pause';

    protected $description = 'Pause synchronization session';

    public function handle(): void
    {
        $this->askForEnv('sync');

        $this->task('Pause file synchronization', function () {
            try {
                $this->localCmd(['mutagen', 'sync', 'pause', $this->config->id()])
                    ->setTty(false)
                    ->mustRun();
            } catch (Exception $e) {
                $this->abort($e->getMessage());
            }
        });
    }
}
