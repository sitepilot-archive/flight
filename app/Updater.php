<?php

namespace App;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Illuminate\Support\Str;
use LaravelZero\Framework\Components\Updater\Strategy\StrategyInterface;

class Updater extends GithubStrategy implements StrategyInterface
{
    public function __construct()
    {
        $packageName = Str::slug(config('app.name'));

        $this->setPackageName($packageName);
        $this->setCurrentLocalVersion(config('app.version'));
        $this->setPharName($packageName);
    }
}
