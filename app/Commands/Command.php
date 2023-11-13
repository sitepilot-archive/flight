<?php

namespace App\Commands;

use App\Repositories\ConfigRepository;
use LaravelZero\Framework\Commands\Command as BaseCommand;
use Symfony\Component\Process\Process;

abstract class Command extends BaseCommand
{
    protected ConfigRepository $config;

    protected bool $ignoreValidationErrors = false;

    public function __construct(
        ConfigRepository $config,
    )
    {
        parent::__construct();

        if ($this->ignoreValidationErrors) {
            $this->ignoreValidationErrors();
        }

        $this->config = $config;
    }

    public function localCmd(array $command, int $timeout = 0): Process
    {
        return (new Process($command))
            ->setTty(Process::isTtySupported())
            ->setTimeout($timeout);
    }

    public function remoteCmd(array|string $command, int $timeout = 0): Process
    {
        if (is_array($command)) $command = implode(" ", $command);

        $remotePath = $this->config->get('path') . str_replace($this->config->path(), '', getcwd());

        $command = [
            'ssh', '-t', '-o', 'LogLevel=QUIET', '-o', 'ServerAliveInterval=60', '-p', $this->config->get('port', 22),
            $this->config->get('user') . '@' . $this->config->get('host'),
            "cd $remotePath ; $command"
        ];

        return (new Process($command, $localWorkdir ?? null))
            ->setTty(Process::isTtySupported())
            ->setTimeout($timeout);
    }

    public function isWSL(): bool
    {
        return !empty(getenv('WSL_DISTRO_NAME'));
    }

    public function abort(string $message, int $code = 1): void
    {
        $this->config->abort($message, $code);
    }
}
