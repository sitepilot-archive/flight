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

Run `flight init` within a local project folder to create a Flight configuration file. The configuration will be stored
in `<project-root>/flight.yml`.

## Configuration

The table below contains a list of all configuration options supported by Flight.

| Key                 | Default                   | Description                                                 |
|---------------------|---------------------------|-------------------------------------------------------------|
| `host`              | `${FLIGHT_HOST}`          | The remote SSH host                                         |
| `port`              | `${FLIGHT_PORT:-22}`      | The remote SSH port                                         |
| `user`              | `${FLIGHT_USER:-root}`    | The remote SSH user                                         |
| `shell`             | `${FLIGHT_SHELL:-bash}`   | The remote SSH port                                         |
| `path`              | `${FLIGHT_PATH}`          | The remote project path                                     | 
| `url`               | `${APP_URL}`              | The application URL                                         | 
| `sync.ignore`       | `[]`                      | A list of files and folders to ignore                       |
| `database.ssh`      | `false`                   | Connect to the database via SSH                             |
| `database.type`     | `${DB_CONNECTION:-mysql}` | The database type (e.g. mariadb, mysql, microsoftsqlserver) |
| `database.host`     | `${FLIGHT_HOST}`          | The database host                                           |
| `database.port`     | `${DB_PORT:-3306}`        | The database port                                           |
| `database.name`     | `${DB_DATABASE}`          | The database name                                           |
| `database.user`     | `${DB_USERNAME}`          | The database user                                           |
| `database.password` | `${DB_PASSWORD}`          | The database password                                       |

#### Example

```yaml
host: 1.2.3.4
port: 22
user: captain
path: ~/code/project
sync:
  ignore:
    - node_modules
```

## Commands

| Command                 | Description                                               |
|-------------------------|-----------------------------------------------------------|
| `flight init`           | Initialize configuration                                  |
| `flight config`         | Display the configuration                                 |
| `flight sync`           | Start / resume file synchronization                       |
| `flight sync:status`    | Display file synchronization status                       |
| `flight sync:pause`     | Pause file synchronization                                |
| `flight sync:terminate` | Terminate file synchronization                            |
| `flight sync:list`      | Display all file synchronization sessions                 |
| `flight exec`           | Run a remote command                                      |
| `flight shell`          | Start a remote shell                                      |
| `flight folder`         | Open project folder in explorer / finder                  |
| `flight docker:context` | Setup Docker context (for running remote Docker commands) |
| `flight open`           | Open application URL in default browser                   |
| `flight db`             | Open database in [TablePlus](https://tableplus.com/)      |
| `flight db --show`      | Show database connection string (for import in TablePlus) |

## Updating

You can update Flight with `sudo flight self-update`, or by repeating the installation steps.
