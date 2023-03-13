<?php

namespace App\Commands;

class FolderCommand extends Command
{
    protected $signature = 'folder';

    protected $description = 'Open project folder';

    public function handle(): void
    {
        if ($this->isWSL()) {
            $path = $this->localCmd(['wslpath', '-w', $this->config->get('local.path')])->setTty(false)->mustRun();
            $this->localCmd(['/mnt/c/Windows/explorer.exe', trim($path->getOutput())])->run();
        } else {
            $this->localCmd(['open', $this->config->get('local.path')])->run();
        }
    }
}
