<?php

it('creates a configuration file', function () {
    $this->artisan('init')->assertExitCode(0);
});
