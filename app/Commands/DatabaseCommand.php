<?php

namespace App\Commands;

class DatabaseCommand extends Command
{
    protected $signature = 'db {--show : Show the database connection string}';

    protected $description = 'Open database connection string';

    public function handle(): void
    {
        $this->askForEnv();

        $rules = [
            'database.type' => ['nullable', 'string'],
            'database.user' => ['required', 'string'],
            'database.password' => ['required', 'string'],
            'database.port' => ['nullable', 'numeric'],
            'database.name' => ['required', 'string'],
            'database.ssh' => ['nullable', 'boolean']
        ];

        if ($this->isWSL()) {
            $rules['password'] = ['required_if:database.ssh,true', 'string'];
        }

        $this->config->validate($rules, [
            'password' => 'The :attribute field is required for an SSH database connection on WSL.'
        ]);

        $parameters = ['env=development', 'name=' . $this->config->id()];

        if ($this->config->get('database.ssh')) {
            $parameters[] = 'usePrivateKey=true';
            $url = sprintf(
                '%s+ssh://%s:%s@%s:%s/%s:%s@%s:%s/%s',
                urlencode($this->config->get('database.type', 'mariadb')),
                urlencode($this->config->get('user')),
                urlencode($this->config->get('password', 'NULL')),
                urlencode($this->config->get('host')),
                urlencode($this->config->get('port', 22)),
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
                urlencode($this->config->get('database.host', $this->config->get('host'))),
                urlencode($this->config->get('database.port', 3306)),
                urlencode($this->config->get('database.name'))
            );
        }

        $url = str_replace(
            [':NULL', 'NULL'], '', $url . '?' . implode('&', $parameters)
        );

        if ($this->option('show')) {
            $this->info($url);
        } elseif ($this->isWSL()) {
            $this->localCmd(['/mnt/c/Windows/explorer.exe', $url])->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
