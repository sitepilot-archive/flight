<?php

namespace App\Commands;

use Exception;

class SyncStatusCommand extends Command
{
    protected $signature = 'sync:status';

    protected $description = 'Display synchronization status';

    public function handle(): void
    {
        try {
            $process = $this->localCmd(['mutagen', 'sync', 'list', '--long', $this->config->id()])
                ->setTty(false)
                ->mustRun();

            $this->line(trim($process->getOutput()));
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'did not match any sessions')) {
                $this->abort("File sync not started, start sync with `flight sync`.");
            } else {
                $this->abort($e->getMessage());
            }
        }
    }
}
