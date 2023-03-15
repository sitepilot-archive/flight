# Flight ✈

<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/v/release/sitepilot/flight" alt="Latest Version"></a>
<a href="https://github.com/sitepilot/flight/releases"><img src="https://img.shields.io/github/downloads/sitepilot/flight/total" alt="Total Downloads"></a>
<a href="https://github.com/sitepilot/flight/actions"><img src="https://img.shields.io/github/actions/workflow/status/sitepilot/flight/tests.yml" alt="Build Status"></a>
<a href="https://github.com/sitepilot/flight"><img src="https://img.shields.io/github/license/sitepilot/flight" alt="License"></a>

## Introduction

About
Flight is a remote development tool that enables your existing local tools to work with code in remote environments. It helps you to manage your projects,
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

The configuration will be stored in `<project-root>/flight.yml` and is composed of the following parts:

```yaml
remote:
  host: 1.2.3.4           # the remote ssh host
  port: 22                # the remote ssh port
  user: root              # the remote ssh user
  path: ~/code/project    # the remote project path
  shell: bash             # the remote shell

links: # list of project links (key-value)
  preview: 'https://sitepilot.io'

sync:
  ignore: # list of ignored files and folders
    - node_modules

database:
  ssh: false              # connect to database over ssh
  type: mariadb           # the database type, default: mariadb (e.g. mariadb, mysql, microsoftsqlserver)
  host: 1.2.3.4           # the database host, default: remote.host (or 127.0.0.1 for ssh)
  port: 3306              # the database port, default: 3306
  name: sandbox           # the database name
  user: user              # the database username
  password: supersecret   # the database user password
```

## Commands

```bash
# Display project configuration
flight config

# Start a remote shell
flight shell

# Open a project link in the default browser
flight open {link}

# Open project files in explorer / finder 
flight folder

# Start / resume file synchronization
flight sync

# Display file synchronization status 
flight sync:status

# Pause file synchronization
flight sync:pause

# Terminate file synchronization
flight sync:terminate

# Display all file synchronization sessions
flight sync:list

# Open database connnection string (this will open TablePlus if installed)
flight db

# Show database connnection string (copy this string to manually import the connection into TablePlus)
flight db --show

# Run Laravel Artisan command
flight artisan {command}

# Run WPCLI command
flight wp {command}
```

## Working with containers

Flight is also compatible with remote containers. Flight can forward Docker Compose commands and
automatically execute shell commands (like `flight exec`, `flight artisan` and `flight wp`) in a container
instead of on the remote host. Add the following configuration to start working with containers:

```yaml
container:
  name: app   # the remote container name
  user: app   # the remote container user
  shell: bash # the remote container shell
```

### Commands

```bash
# Run Docker Compose command
flight compose <command>

# Run Docker Compose up command
flight up <command>

# Run Docker Compose down command
flight down <command>
```
