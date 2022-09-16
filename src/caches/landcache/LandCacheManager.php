<?php

declare(strict_types=1);

namespace outiserver\landmanager\caches\landcache;

use outiserver\economycore\Caches\Base\BaseCacheManager;
use pocketmine\utils\SingletonTrait;

class LandCacheManager extends BaseCacheManager
{
    use SingletonTrait;

    public function __construct()
    {
        parent::__construct();
        self::setInstance($this);
    }

    public function get(string $xuid): ?LandCache
    {
        if (!isset($this->data[$xuid])) return null;
        return $this->data[$xuid];
    }

    public function create(string $xuid, int $startX, int $startY, int $startZ): LandCache
    {
        if (isset($this->data[$xuid])) return $this->data[$xuid];

    }
}