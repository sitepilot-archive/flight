<?php

namespace App\Commands;

class DatabaseCommand extends Command
{
    protected $signature = 'db';

    protected $description = 'Open database connection string';

    public function handle(): void
    {
        $this->config->validate([
            'database.type' => ['nullable', 'string'],
            'database.user' => ['required', 'string'],
            'database.password' => ['required', 'string'],
            'database.port' => ['nullable', 'numeric'],
            'database.name' => ['required', 'string'],
            'database.ssh' => ['nullable', 'boolean'],
            'remote.password' => ['required_if:database.ssh,true', 'string']
        ]);

        if ($this->config->get('database.ssh')) {
            $url = sprintf(
                '%s+ssh://%s:%s@%s:%s/%s:%s@%s:%s/%s',
                urlencode($this->config->get('database.type', 'mariadb')),
                urlencode($this->config->get('remote.user')),
                urlencode($this->config->get('remote.password')),
                urlencode($this->config->get('remote.host')),
                urlencode($this->config->get('remote.port', 22)),
                urlencode($this->config->get('database.user')),
                urlencode($this->config->get('database.password')),
                urlencode($this->config->get('database.host', '127.0.0.1')),
                urlencode($this->config->get('database.port', 3306)),
                urlencode($this->config->get('database.name'))
            );
        } else {
            $url = sprintf(
                '%s://%s:%s@%s:%s/%s',
                urlencode($this->config->get('database.type', 'mariadb')),
                urlencode($this->config->get('database.user')),
                urlencode($this->config->get('database.password')),
                urlencode($this->config->get('database.host', $this->config->get('remote.host'))),
                urlencode($this->config->get('database.port', 3306)),
                urlencode($this->config->get('database.name'))
            );
        }

        if ($this->isWSL()) {
            $this->localCmd(['/mnt/c/Windows/explorer.exe', $url])->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
