<?php

declare(strict_types=1);

namespace outiserver\landmanager\database\landdata;

use outiserver\economycore\Database\Base\BaseData;
use outiserver\landmanager\LandManagerMain;
use poggit\libasynql\DataConnector;
use poggit\libasynql\SqlError;

class LandData extends BaseData
{
    private int $id;

    private ?string $ownerXuid;

    private int $price;

    private string $worldName;

    private int $startX;

    private int $startY;

    private int $startZ;

    private int $endX;

    private int $endY;

    private int $endZ;

    private int $signboardX;

    private int $signboardY;

    private int $signboardZ;

    public function __construct(DataConnector $dataConnector, int $id, ?string $ownerXuid, int $price, string $worldName, int $startX, int $startY, int $startZ, int $endX, int $endY, int $endZ, int $signboardX, int $signboardY, int $signboardZ)
    {
        parent::__construct($dataConnector);

        $this->id = $id;
        $this->ownerXuid = $ownerXuid;
        $this->price = $price;
        $this->worldName = $worldName;
        $this->startX = $startX;
        $this->startY = $startY;
        $this->startZ = $startZ;
        $this->endX = $endX;
        $this->endY = $endY;
        $this->endZ = $endZ;
        $this->signboardX = $signboardX;
        $this->signboardY = $signboardY;
        $this->signboardZ = $signboardZ;
    }

    protected function update(): void
    {
        $this->dataConnector->executeChange("economy.land.lands.update",
            [
                "owner_xuid" => $this->ownerXuid,
                "price" => $this->price,
                "id" => $this->id
            ],
            null,
            function (SqlError $error) {
                LandManagerMain::getInstance()->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getOwnerXuid(): ?string
    {
        return $this->ownerXuid;
    }

    /**
     * @param string|null $ownerXuid
     */
    public function setOwnerXuid(?string $ownerXuid): void
    {
        $this->ownerXuid = $ownerXuid;
        $this->update();
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
        $this->update();
    }

    /**
     * @return string
     */
    public function getWorldName(): string
    {
        return $this->worldName;
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
     * @return int
     */
    public function getEndY(): int
    {
        return $this->endY;
    }

    /**
     * @return int
     */
    public function getEndZ(): int
    {
        return $this->endZ;
    }

    /**
     * @return int
     */
    public function getSignboardX(): int
    {
        return $this->signboardX;
    }

    /**
     * @return int
     */
    public function getSignboardY(): int
    {
        return $this->signboardY;
    }

    /**
     * @return int
     */
    public function getSignboardZ(): int
    {
        return $this->signboardZ;
    }
}