<?php

namespace App;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use LaravelZero\Framework\Components\Updater\Strategy\StrategyInterface;

class Updater extends GithubStrategy implements StrategyInterface
{
    public function __construct()
    {
        $this->setPharName('flight');
    }
}
