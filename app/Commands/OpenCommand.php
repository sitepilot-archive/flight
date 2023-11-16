<?php

namespace App\Commands;

class OpenCommand extends Command
{
    protected $signature = 'open';

    protected $description = 'Open application URL';

    public function handle(): void
    {
        $rules = [
            'url' => ['required', 'url'],
        ];

        $this->config->validate($rules);

        $url = $this->config->get('url');

        if ($this->isWSL()) {
            $this->localCmd(['cmd.exe', '/c', "start $url"])->setTty(false)->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
