<?php

namespace App\Commands;

use Exception;

class SyncTerminateCommand extends Command
{
    protected $signature = 'sync:terminate';

    protected $description = 'Terminate synchronization session';

    public function handle(): void
    {
        $this->askForEnv(
            collect($this->config->all())->where('sync', '!=', null)->toArray()
        );
        
        $this->task('Terminate file synchronization', function () {
            try {
                $this->localCmd(['mutagen', 'sync', 'terminate', $this->config->id()])
                    ->setTty(false)
                    ->mustRun();
            } catch (Exception $e) {
                $this->abort($e->getMessage());
            }
        });
    }
}
