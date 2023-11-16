<?php

namespace App\Commands;

class DatabaseCommand extends Command
{
    protected $signature = 'db {--show : Show the database connection string}';

    protected $description = 'Open database connection string';

    public function handle(): void
    {
        $rules = [
            'database.type' => ['required', 'string'],
            'database.user' => ['required', 'string'],
            'database.password' => ['required', 'string'],
            'database.port' => ['required', 'numeric'],
            'database.name' => ['required', 'string'],
            'database.ssh' => ['required', 'boolean']
        ];

        $this->config->validate($rules);

        $parameters = ['env=development', 'name=' . $this->config->id()];

        $type = match ($value = $this->config->get('database.type', 'mysql')) {
            'sqlsrv' => 'microsoftsqlserver',
            default => $value,
        };

        if ($this->config->get('database.ssh')) {
            $parameters[] = 'usePrivateKey=true';
            $url = sprintf(
                '%s+ssh://%s:%s@%s:%s/%s:%s@%s:%s/%s',
                urlencode($type),
                urlencode($this->config->get('user')),
                urlencode($this->config->get('password')),
                urlencode($this->config->get('host')),
                urlencode($this->config->get('port')),
                urlencode($this->config->get('database.user')),
                urlencode($this->config->get('database.password')),
                urlencode($this->config->get('database.host')),
                urlencode($this->config->get('database.port')),
                urlencode($this->config->get('database.name'))
            );
        } else {
            $url = sprintf(
                '%s://%s:%s@%s:%s/%s',
                urlencode($type),
                urlencode($this->config->get('database.user')),
                urlencode($this->config->get('database.password')),
                urlencode($this->config->get('database.host')),
                urlencode($this->config->get('database.port')),
                urlencode($this->config->get('database.name'))
            );
        }

        $url = str_replace(
            [':NULL', 'NULL'], '', $url . '?' . implode('&', $parameters)
        );

        if ($this->option('show')) {
            $this->info($url);
        } elseif ($this->isWSL()) {
            $this->localCmd(['cmd.exe', '/c', "start $url"])->setTty(false)->run();
        } else {
            $this->localCmd(['open', $url])->run();
        }
    }
}
