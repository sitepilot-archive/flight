<?php

namespace App\Commands;

class OpenCommand extends Command
{
    protected $signature = 'open';

    protected $description = 'Open the project URL';

    public function handle(): void
    {
        $this->config->validate([
            'url' => ['required', 'url']
        ]);

        $url = $this->config->get('url');

        if ($this->isWSL()) {
            $this->localCmd(['/mnt/c/Windows/explorer.exe', $url])->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
