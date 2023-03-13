<?php

namespace App\Commands;

use Exception;
use Illuminate\Support\Arr;

class SyncCommand extends Command
{
    protected $signature = 'sync';

    protected $description = 'Start file synchronization';

    public function handle(): void
    {
        try {
            $this->localCmd(['mutagen', 'sync', 'list', $this->config->id()])
                ->setTty(false)->mustRun();
        } catch (Exception) {
            $ignores = $this->config->get('sync.ignore', [
                '.idea', '.vscode', '.DS_Store', 'node_modules', '/wp-content/uploads'
            ]);

            $ignores = Arr::map($ignores, function ($ignore) {
                return "--ignore=$ignore";
            });

            $this->task('Start file synchronization', function () use ($ignores) {
                $this->localCmd(array_merge(
                    ['mutagen', 'sync', 'create', '--name=' . $this->config->id(), '--default-directory-mode=0755', '--default-file-mode=0644'],
                    $ignores,
                    [$this->config->path(), $this->config->get('remote.user') . '@' . $this->config->get('remote.host') . ':' . $this->config->get('remote.port', 22) . ':' . $this->config->get('remote.path')]
                ))
                    ->mustRun();
            });

            return;
        }

        $this->task('Resume file synchronization', function () {
            $this->localCmd(['mutagen', 'sync', 'resume', $this->config->id()])
                ->setTty(false)->mustRun();
        });
    }
}
