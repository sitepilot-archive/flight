<?php

namespace App\Commands;

class DockerContextCommand extends Command
{
    protected $signature = 'docker:context';

    protected $description = 'Set docker context';

    public function handle(): void
    {
        $this->localCmd(['docker', 'context', 'rm', '-f', $this->config->id()])
            ->setTty(false)->mustRun();

        $this->localCmd(['docker', 'context', 'create', $this->config->id(), '--docker', sprintf('host=ssh://%s@%s:%s',
            $this->config->get('user'),
            $this->config->get('host'),
            $this->config->get('port')
        )])->setTty(false)->mustRun();

        $this->localCmd(['docker', 'context', 'use', $this->config->id()])
            ->mustRun();
    }
}
