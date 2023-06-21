# Flight ✈

<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/v/release/sitepilot/flight" alt="Latest Version"></a>
<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/downloads/sitepilot/flight/total" alt="Total Downloads"></a>
<a href="https://github.com/sitepilot/flight/actions"><img src="https://img.shields.io/github/actions/workflow/status/sitepilot/flight/tests.yml" alt="Build Status"></a>
<a href="https://github.com/sitepilot/flight"><img src="https://img.shields.io/github/license/sitepilot/flight" alt="License"></a>

## Introduction

Flight is a remote development tool that enables your existing local tools to work with code in remote environments. It
helps you to manage your projects, execute remote commands, work with remote containers and enables real-time file
synchronization using [Mutagen](https://mutagen.io).

## Installation

Downloading the phar file is the recommended installation method for most users. Before installing Flight, please make
sure your environment meets the minimum requirements:

* UNIX-like environment (Linux, MacOS, WSL)
* PHP 8.1 or later
* [Mutagen](https://mutagen.io/)

```bash
php -r "copy('https://github.com/sitepilot/flight/releases/latest/download/flight', 'flight');"
```

Next, check the phar file to verify that it’s working:

```bash
php flight --version
```

To use Flight from the command line by typing `flight`, make the file executable and move it to somewhere in
your `PATH`. For example:

```bash
chmod +x flight
```

```bash
sudo mv flight /usr/local/bin/flight
```

## Getting Started

Run `flight init` to create a Flight configuration file in the current project folder. The configuration will be stored
in `<project-root>/flight.yml`.

## Configuration

The table below contains a list of all configuration options supported by Flight.

| Key                 | Default      | Description                                                 |
|---------------------|--------------|-------------------------------------------------------------|
| `host`              | -            | The remote SSH host                                         |
| `port`              | 22           | The remote SSH port                                         |
| `user`              | root         | The remote SSH user                                         |
| `shell`             | bash         | The remote SSH port                                         |
| `path`              | -            | The remote project path                                     | 
| `container.name`    | -            | The remote container name                                   |
| `container.user`    | root         | The remote container user                                   |
| `container.shell`   | bash         | The remote container shell                                  |
| `database.ssh`      | false        | Connect to the database via SSH                             |
| `database.type`     | mariadb      | The database type (e.g. mariadb, mysql, microsoftsqlserver) |
| `database.host`     | `<env>.host` | The database host                                           |
| `database.port`     | 3306         | The database port                                           |
| `database.name`     | -            | The database name                                           |
| `database.user`     | -            | The database user                                           |
| `database.password` | -            | The database user                                           |
| `sync.ignore`       | -            | A list of files and folders to ignore                       |
| `links.*`           | -            | A list of external project links (key-value)                |

#### Example

```yaml
host: 1.2.3.4
port: 22
user: captain
path: ~/code/project
sync:
  ignore:
    - node_modules
links:
  preview: https://sitepilot.io
```

## Commands

| Command                    | Permission | Description                                               |
|----------------------------|------------|-----------------------------------------------------------|
| `flight init`              | -          | Initialize configuration                                  |
| `flight config`            | -          | Display the configuration                                 |
| `flight shell`             | -          | Start a remote shell                                      |
| `flight folder`            | -          | Open project folder in explorer / finder                  |
| `flight open {link}`       | -          | Open a project link in the default browser                |
| `flight db`                | -          | Open database in [TablePlus](https://tableplus.com/)      |
| `flight db --show`         | -          | Show database connection string (for import in TablePlus) |
| `flight sync`              | sync       | Start / resume file synchronization                       |
| `flight sync:status`       | sync       | Display file synchronization status                       |
| `flight sync:pause`        | sync       | Pause file synchronization                                |
| `flight sync:terminate`    | sync       | Terminate file synchronization                            |
| `flight sync:list`         | -          | Display all file synchronization sessions                 |
| `flight artisan {command}` | -          | Run a Laravel Artisan command                             |
| `flight wp {command}`      | -          | Run a WPCLI command                                       |
| `flight compose {command}` | -          | Run a Docker Compose command                              |
| `flight up {options}`      | -          | Alias for the `docker compose up` command                 |
| `flight down {options}`    | -          | Alias for the `docker compose down` command               |

## Updating

You can update Flight with `sudo flight self-update`, or by repeating the installation steps.
