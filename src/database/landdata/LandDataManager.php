<?php

declare(strict_types=1);

namespace outiserver\landmanager\database\landdata;

use outiserver\economycore\Database\Base\BaseAutoincrement;
use outiserver\economycore\Database\Base\BaseDataManager;
use outiserver\landmanager\LandManagerMain;
use pocketmine\utils\SingletonTrait;
use poggit\libasynql\DataConnector;
use poggit\libasynql\SqlError;

class LandDataManager extends BaseDataManager
{
    use SingletonTrait;
    use BaseAutoincrement;

    public function __construct(DataConnector $dataConnector)
    {
        parent::__construct($dataConnector);
        self::setInstance($this);

        $this->dataConnector->executeSelect("economy.land.lands.load",
            [],
            function (array $row) {
                foreach ($row as $data) {
                    $this->data[$data["id"]] = new LandData($this->dataConnector, $data["id"], $data["owner_xuid"], $data["price"], $data["world_name"], $data["start_x"], $data["start_y"], $data["start_z"], $data["end_x"], $data["end_y"], $data["end_z"], $data["signboard_x"], $data["signboard_y"], $data["signboard_z"]);
                }
            },
            function (SqlError $error) {
                LandManagerMain::getInstance()->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });
        $this->dataConnector->executeSelect("economy.land.lands.seq",
            [],
            function (array $row) {
                if (count($row) < 1) {
                    $this->seq = 0;
                    return;
                }
                foreach ($row as $data) {
                    if (LandManagerMain::getInstance()->getDatabaseConfig()["type"] === "sqlite" or LandManagerMain::getInstance()->getDatabaseConfig()["type"] === "sqlite3" or LandManagerMain::getInstance()->getDatabaseConfig()["type"] === "sq3") {
                        $this->seq = $data["seq"];
                    } elseif (LandManagerMain::getInstance()->getDatabaseConfig()["type"] === "mysql" or LandManagerMain::getInstance()->getDatabaseConfig()["type"] === "mysqli") {
                        $this->seq = $data["Auto_increment"] ?? 0;
                    }
                }
            },
            function (SqlError $error) {
                LandManagerMain::getInstance()->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });
    }

    public function get(int $id): ?LandData
    {
        if (!isset($this->data[$id])) return null;
        return $this->data[$id];
    }

    public function getLand(string $worldName, int $x, int $y, int $z): ?LandData
    {
        $landDatas = array_filter($this->data, function ($landData) use ($worldName, $x, $y, $z) {
            return ($landData->getWorldName() === $worldName and $landData->getStartX() <= $x and $landData->getStartY() <= $y and $landData->getStartZ() <= $z and $landData->getEndX() >= $x and $landData->getEndY() >= $y and $landData->getEndZ() >= $z);
        });

        if (count($landDatas) < 1) return null;
        return array_shift($landDatas);
    }

    public function create(int $price, string $worldName, int $startX, int $startY, int $startZ, int $endX, int $endY, int $endZ, int $signboardX, int $signboardY, int $signboardZ): LandData
    {
        $this->dataConnector->executeInsert("economy.land.lands.create",
            [
                "price" => $price,
                "world_name" => $worldName,
                "start_x" => $startX,
                "start_y" => $startY,
                "start_z" => $startZ,
                "end_x" => $endX,
                "end_y" => $endY,
                "end_z" => $endZ,
                "signboard_x" => $signboardX,
                "signboard_y" => $signboardY,
                "signboard_z" => $signboardZ,
            ],
            null,
            function (SqlError $error) {
                LandManagerMain::getInstance()->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });

        return ($this->data[++$this->seq] = new LandData($this->dataConnector, $this->seq, null, $price, $worldName, $startX, $startY, $startZ, $endX, $endY, $endZ, $signboardX, $signboardY, $signboardZ));
    }

    public function delete(int $id): void
    {
        if (!$this->get($id)) return;

        $this->dataConnector->executeGeneric("economy.land.lands.delete",
            [
                "id" => $id
            ],
            null,
            function (SqlError $error) {
                LandManagerMain::getInstance()->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });
        unset($this->data[$id]);
    }
}