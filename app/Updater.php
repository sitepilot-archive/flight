<?php

namespace App;

use LaravelZero\Framework\Components\Updater\Strategy\StrategyInterface;

class Updater extends \Humbug\SelfUpdate\Strategy\GithubStrategy implements StrategyInterface
{
    public function __construct()
    {
        $this->setPharName('flight');
    }
}
