# Flight ✈

<a href="https://github.com/sitepilot/flight/actions"><img src="https://github.com/sitepilot/flight/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/sitepilot/flight"><img src="https://img.shields.io/packagist/dt/sitepilot/flight" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sitepilot/flight"><img src="https://img.shields.io/packagist/v/sitepilot/flight" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sitepilot/flight"><img src="https://img.shields.io/packagist/l/sitepilot/flight" alt="License"></a>

## Introduction

Flight is a remote development tool that enables your existing local tools to work with code in remote cloud
environments.

## Requirements

* MacOS, Linux or Windows
* PHP >= 8.1
* [Mutagen](https://mutagen.io/)

## Installation

Coming soon.

## Getting Started

Run `flight init` to create a Flight configuration file in the current project folder. This file contains the
configuration for syncing files en running commands on the remote host or container.

## Configuration

The configuration will be stored in `<project-root>/flight.yml` and is composed of the following parts:

```yaml
remote:
    host: '1.2.3.4'        # the remote ssh host
    port: 22               # the remote ssh port
    user: 'root'           # the remote ssh user
    path: '~/code/project' # the remote project path
    shell: 'bash'          # the remote shell
```

## Commands

```bash
# Display project configuration
flight config

# Start a remote shell
flight shell

# Open project url in the default browser
flight open

# Open project files in explorer / finder 
flight folder

# Start / resume file synchronization
flight sync

# Display file synchronization status 
flight sync:status

# Display all file synchronization sessions
flight sync:status --all

# Pause file synchronization
flight sync:pause

# Terminate file synchronization
flight sync:terminate

# Run Laravel Artisan command
flight artisan <command>

# Run WPCLI command
flight wp <command>
```

## Working with containers

Flight is also compatible with (remote) containers. Flight can forward Docker Compose commands and
automatically execute shell commands (like `flight exec`, `flight artisan` and `flight wp`) in a container
instead of on the host. Add the following configuration to the project to start working with containers:

```yaml
container:
    name: 'app'   # the remote container name
    user: 'app'   # the remote container user
    shell: 'bash' # the remote container shell
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
