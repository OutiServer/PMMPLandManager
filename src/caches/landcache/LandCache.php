<?php

declare(strict_types=1);

namespace outiserver\landmanager\caches\landcache;

use outiserver\economycore\Caches\Base\BaseCache;

class LandCache extends BaseCache
{
    private string $xuid;

    private int $startX;

    private int $startY;

    private int $startZ;

    private int $endX;

    private int $endY;

    private int $endZ;

    public function __construct(string $xuid, int $startX, int $startY, int $startZ, int $endX, int $endY, int $endZ)
    {
        $this->xuid = $xuid;
        $this->startX = $startX;
        $this->startY = $startY;
        $this->startZ = $startZ;
        $this->endX = $endX;
        $this->endY = $endY;
        $this->endZ = $endZ;
    }

    /**
     * @return string
     */
    public function getXuid(): string
    {
        return $this->xuid;
    }

    /**
     * @return int
     */
    public function getStartX(): int
    {
        return $this->startX;
    }

    /**
     * @return int
     */
    public function getStartY(): int
    {
        return $this->startY;
    }

    /**
     * @return int
     */
    public function getStartZ(): int
    {
        return $this->startZ;
    }

    /**
     * @return int
     */
    public function getEndX(): int
    {
        return $this->endX;
    }

    /**
     * @param int $endX
     */
    public function setEndX(int $endX): void
    {
        $this->endX = $endX;
    }

    /**
     * @return int
     */
    public function getEndY(): int
    {
        return $this->endY;
    }

    /**
     * @param int $endY
     */
    public function setEndY(int $endY): void
    {
        $this->endY = $endY;
    }

    /**
     * @return int
     */
    public function getEndZ(): int
    {
        return $this->endZ;
    }

    /**
     * @param int $endZ
     */
    public function setEndZ(int $endZ): void
    {
        $this->endZ = $endZ;
    }
}