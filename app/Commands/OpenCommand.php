<?php

namespace App\Commands;

class OpenCommand extends Command
{
    protected $signature = 'open {link? : The link key (e.g. preview)}';

    protected $description = 'Open a project link';

    public function handle(): void
    {
        $this->config->validate([
            'global.links' => ['required', 'array'],
            'global.links.*' => ['required', 'url']
        ]);

        $links = $this->config->get('global.links', []);

        if (!empty($links[$this->argument('link')])) {
            $url = $links[$this->argument('link')];
        } elseif (count($links) == 1) {
            $url = reset($links);
        } else {
            $url = $links[$this->choice(
                'Which link would you like to open?',
                $links,
                array_key_first($links)
            )];
        }

        if ($this->isWSL()) {
            $this->localCmd(['/mnt/c/Windows/explorer.exe', $url])->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
