<?php

declare(strict_types=1);

namespace outiserver\landmanager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class LandManagerMain extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }
}