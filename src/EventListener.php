<?php

declare(strict_types=1);

namespace outiserver\landmanager;

use pocketmine\event\Listener;

class EventListener implements Listener
{
    private LandManagerMain $plugin;

    public function __construct(LandManagerMain $plugin)
    {
        $this->plugin = $plugin;
    }
}