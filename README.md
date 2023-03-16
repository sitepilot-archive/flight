# Flight ✈

<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/v/release/sitepilot/flight" alt="Latest Version"></a>
<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/downloads/sitepilot/flight/total" alt="Total Downloads"></a>
<a href="https://github.com/sitepilot/flight/actions"><img src="https://img.shields.io/github/actions/workflow/status/sitepilot/flight/tests.yml" alt="Build Status"></a>
<a href="https://github.com/sitepilot/flight"><img src="https://img.shields.io/github/license/sitepilot/flight" alt="License"></a>

## Introduction

About
Flight is a remote development tool that enables your existing local tools to work with code in remote environments. It
helps you to manage your projects,
execute remote commands, work with remote containers and enables real-time file synchronization
using [Mutagen](https://mutagen.io).

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

### Updating

You can update Flight with `sudo flight self-update`, or by repeating the installation steps.

## Getting Started

Run `flight init` to create a Flight configuration file in the current project folder. This file contains the
configuration for syncing files en running commands on the remote host or container.

## Configuration

The configuration will be stored in `<project-root>/flight.yml` and is composed of the following sections:

* [Remote](#remote)
* [Container](#container)
* [Database](#database)
* [Environments](#environments)
* [Links](#links)
* [Sync](#sync)

### Remote

The `remote` section contains the remote host configuration.

| Key            | Default    | Description             |
|----------------|------------|-------------------------|
| `remote.host`  | _required_ | The remote SSH host     |
| `remote.path`  | _required_ | The remote project path |
| `remote.port`  | 22         | The remote SSH port     |
| `remote.user`  | root       | The remote SSH user     |
| `remote.shell` | bash       | The remote SSH port     |

```yaml
remote:
  host: 1.2.3.4
  path: ~/code/project
  port: 22
  user: root
  shell: bash             
```

### Container

The `container` section contains the remote container configuration. Flight will automatically execute shell commands (
like `flight exec`, `flight artisan` and `flight wp`) in the configured container
instead of on the remote host.

| Key               | Default    | Description                |
|-------------------|------------|----------------------------|
| `container.name`  | _required_ | The remote container name  |
| `container.user`  | root       | The remote container user  |
| `container.shell` | bash       | The remote container shell |

```yaml
container:
  name: app
  user: app
  shell: bash
```

### Database

The `database` section contains the remote database configuration.

| Key                 | Default       | Description                                                 |
|---------------------|---------------|-------------------------------------------------------------|
| `database.name`     | *required*    | The database name                                           |
| `database.user`     | *required*    | The database user                                           |
| `database.password` | *required*    | The database user                                           |
| `database.ssh`      | false         | Connect to the database via SSH                             |
| `database.type`     | mariadb       | The database type (e.g. mariadb, mysql, microsoftsqlserver) |
| `database.port`     | 3306          | The database port                                           |
| `database.host`     | `remote.host` | The database host (defaults to 127.0.0.1 when using SSH)    |

```yaml
database:
  ssh: false
  type: mariadb
  host: 1.2.3.4
  port: 3306
  name: sandbox
  user: user
  password: secret
```

### Environments

The `environments` section contains a list of other remote environments related to the current project.

| Key                    | Default    | Description                  |
|------------------------|------------|------------------------------|
| `environments.*.host`  | *required* | The environment SSH host     |
| `environments.*.port`  | 22         | The environment SSH port     |
| `environments.*.user`  | root       | The environment SSH user     |
| `environments.*.path`  | ~          | The environment project path |
| `environments.*.shell` | bash       | The environment shell        |

```yaml
environments:
  production:
    host: 1.2.3.4
    port: 22
    user: root
    path: ~/code/live
    shell: bash           
```

### Links

The `links` section contains a list of external project links (key-value).

| Key       | Default    | Description |
|-----------|------------|-------------|
| `links.*` | *required* | A valid URL |

```yaml
links:
  preview: https://sitepilot.io
  github: https://github.com/sitepilot/flight
```

### Sync

The `sync` section contains the file synchronization configuration.

| Key           | Default | Description                           |
|---------------|---------|---------------------------------------|
| `sync.ignore` | -       | A list of files and folders to ignore |

```yaml
sync:
  ignore:
    - node_modules
```

## Commands

| Command                    | Description                                               |
|----------------------------|-----------------------------------------------------------|
| `flight init`              | Initialize configuration                                  |
| `flight config`            | Display the configuration                                 |
| `flight shell`             | Start a remote shell                                      |
| `flight folder`            | Open project folder in explorer / finder                  |
| `flight open {link}`       | Open a project link in the default browser                |
| `flight db`                | Open database in [TablePlus](https://tableplus.com/)      |
| `flight db --show`         | Show database connection string (for import in TablePlus) |
| `flight sync`              | Start / resume file synchronization                       |
| `flight sync:status`       | Display file synchronization status                       |
| `flight sync:pause`        | Pause file synchronization                                |
| `flight sync:terminate`    | Terminate file synchronization                            |
| `flight sync:list`         | Display all file synchronization sessions                 |
| `flight artisan {command}` | Run a Laravel Artisan command                             |
| `flight wp {command}`      | Run a WPCLI command                                       |
| `flight ssh {environment}` | SSH into a remote environment                             |
| `flight compose {command}` | Run a Docker Compose command                              |
| `flight up {options}`      | Alias for the `docker compose up` command                 |
| `flight down {options}`    | Alias for the `docker compose down` command               |
