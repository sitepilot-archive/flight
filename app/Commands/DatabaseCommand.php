<?php

namespace App\Commands;

class DatabaseCommand extends Command
{
    protected $signature = 'db {--show}';

    protected $description = 'Open database connection string';

    public function handle(): void
    {
        $rules = [
            'database.type' => ['nullable', 'string'],
            'database.user' => ['required', 'string'],
            'database.password' => ['required', 'string'],
            'database.port' => ['nullable', 'numeric'],
            'database.name' => ['required', 'string'],
            'database.ssh' => ['nullable', 'boolean']
        ];

        if ($this->isWSL()) {
            $rules['remote.password'] = ['required_if:database.ssh,true', 'string'];
        }

        $this->config->validate($rules, [
            'remote.password' => 'The :attribute field is required for an SSH database connection on WSL.'
        ]);

        if ($this->config->get('database.ssh')) {
            $url = sprintf(
                '%s+ssh://%s:%s@%s:%s/%s:%s@%s:%s/%s',
                urlencode($this->config->get('database.type', 'mariadb')),
                urlencode($this->config->get('remote.user')),
                urlencode($this->config->get('remote.password', 'NULL')),
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

        $url = str_replace([':NULL', 'NULL'], '', $url);

        if ($this->option('show')) {
            $url .= sprintf('?enviroment=development&name=%s', $this->config->id());
            $this->info($url);
        } elseif ($this->isWSL()) {
            $this->localCmd(['/mnt/c/Windows/explorer.exe', $url])->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
