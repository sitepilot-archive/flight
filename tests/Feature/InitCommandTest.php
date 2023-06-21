<?php

it('creates a configuration file', function () {
    /** @var \Tests\TestCase $this */
    $this->artisan('init')
        ->expectsQuestion('Remote project host', '1.2.3.4')
        ->expectsQuestion('Remote SSH port', 22)
        ->expectsQuestion('Remote SSH user', 'captain')
        ->expectsQuestion('Remote project path', '~/code/test')
        ->assertExitCode(0);
});
