<?php

namespace App\Commands;

use Exception;

class SyncListCommand extends Command
{
    protected $signature = 'sync:list';

    protected $description = 'Display all synchronization sessions';

    public function handle(): void
    {
        $this->localCmd(['mutagen', 'sync', 'list'])
            ->run();
    }
}
