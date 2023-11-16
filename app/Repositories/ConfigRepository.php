<?php

namespace App\Repositories;

use Dotenv\Dotenv;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Yaml\Yaml;

class ConfigRepository
{
    protected ?string $file = null;

    protected ?array $config = null;

    public function file(): string
    {
        if ($this->file) {
            return $this->file;
        }

        $path = getcwd();
        for ($i = 0; $i < 4; $i++) {
            $file = $path . DIRECTORY_SEPARATOR . 'flight.yml';
            if (File::isFile($file)) {
                $this->file = realpath($file);
            } else {
                $path .= DIRECTORY_SEPARATOR . '..';
            }
        }

        if (!$this->file) {
            $this->abort("Could not find a flight configuration file.");
        }

        return $this->file;
    }

    public function path(string $path = ''): string
    {
        return dirname($this->file()) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function name(): string
    {
        return basename($this->path());
    }

    public function id(): string
    {
        return Str::slug('fl-' . $this->name());
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get(
            $this->loadConfig(),
            $key,
            $default
        );
    }

    public function all(): array
    {
        return $this->loadConfig();
    }

    public function abort(string $message, int $code = 1): void
    {
        abort($code, $message);
    }

    public function validate(array $rules, array $messages = []): void
    {
        $config = $this->loadConfig();

        try {
            Validator::make($config, $rules, $messages)->validate();
        } catch (ValidationException $e) {
            $this->abort($e->getMessage());
        }
    }

    private function loadConfig(): array
    {
        if ($this->config) {
            return $this->config;
        }

        $config = Yaml::parse(File::get($this->file()));

        return $this->config = $this->replaceEnv($config ?: [], [
            'host' => '${FLIGHT_HOST}',
            'port' => '${FLIGHT_PORT:-22}',
            'user' => '${FLIGHT_USER:-root}',
            'shell' => '${FLIGHT_SHELL:-bash}',
            'path' => '${FLIGHT_PATH}',
            'url' => '${APP_URL}',
            'sync.ignore' => [],
            'database.ssh' => false,
            'database.host' => '${FLIGHT_HOST:-' . ($config['host'] ?? null) . '}',
            'database.port' => '${DB_PORT:-3306}',
            'database.type' => '${DB_CONNECTION:-mysql}',
            'database.name' => '${DB_DATABASE}',
            'database.user' => '${DB_USERNAME}',
            'database.password' => '${DB_PASSWORD}',
        ]);
    }

    public function replaceEnv(array $array, array $defaults = []): array
    {
        $env = Dotenv::createImmutable($this->path())->safeLoad();

        $array = array_merge($defaults, Arr::dot($array));

        foreach ($array as &$value) {
            $matches = null;
            if (is_string($value) && preg_match('/^\${(.*)}/', $value, $matches)) {
                $match = explode(':-', $matches[1]);
                $default = $match[1] ?? null;
                $value = $env[$match[0]] ?? $default;
            }
        }

        return Arr::undot($array);
    }
}
