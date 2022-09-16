<?php

declare(strict_types=1);

namespace outiserver\landmanager;

use Ken_Cir\LibFormAPI\FormStack\StackFormManager;
use outiserver\economycore\EconomyCore;
use outiserver\landmanager\database\landdata\LandDataManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use poggit\libasynql\DataConnector;
use poggit\libasynql\SqlError;

class LandManagerMain extends PluginBase
{
    use SingletonTrait;

    public const DATABASE_VERSION = "1.0.0";

    public const CONFIG_VERSION = "1.0.0";

    private DataConnector $dataConnector;

    private LandDataManager $landDataManager;

    private Config $config;

    private mixed $databaseConfig;

    private StackFormManager $stackFormManager;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        if (@file_exists("{$this->getDataFolder()}database.yml")) {
            $config = new Config("{$this->getDataFolder()}database.yml", Config::YAML);
            // データベース設定のバージョンが違う場合は
            if ($config->get("version") !== self::DATABASE_VERSION) {
                rename("{$this->getDataFolder()}database.yml", "{$this->getDataFolder()}database.yml.{$config->get("version")}");
                $this->getLogger()->warning("database.yml バージョンが違うため、上書きしました");
                $this->getLogger()->warning("前バージョンのdatabase.ymlは{$this->getDataFolder()}database.yml.{$config->get("version")}にあります");
            }
        }
        if (@file_exists("{$this->getDataFolder()}config.yml")) {
            $config = new Config("{$this->getDataFolder()}config.yml", Config::YAML);
            // Config設定のバージョンが違う場合は
            if ($config->get("version") !== self::CONFIG_VERSION) {
                rename("{$this->getDataFolder()}config.yml", "{$this->getDataFolder()}config.yml.{$config->get("version")}");
                $this->getLogger()->warning("config.yml バージョンが違うため、上書きしました");
                $this->getLogger()->warning("前バージョンのconfig.ymlは{$this->getDataFolder()}config.yml.{$config->get("version")}にあります");
            }
        }
        $this->saveResource("database.yml");
        $this->saveResource("config.yml");
        $this->config = new Config("{$this->getDataFolder()}config.yml", Config::YAML);
        $this->databaseConfig = (new Config("{$this->getDataFolder()}database.yml", Config::YAML))->get("database");

        $this->dataConnector->executeGeneric("economy.land.lands.init",
            [],
            null,
            function (SqlError $error) {
                $this->getLogger()->error("[SqlError] {$error->getErrorMessage()}");
            });
        $this->dataConnector->waitAll();
        $this->landDataManager = new LandDataManager($this->dataConnector);
        $this->dataConnector->waitAll();

        $this->stackFormManager = new StackFormManager();
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return mixed
     */
    public function getDatabaseConfig(): mixed
    {
        return $this->databaseConfig;
    }

    /**
     * @return DataConnector
     */
    public function getDataConnector(): DataConnector
    {
        return $this->dataConnector;
    }

    /**
     * @return LandDataManager
     */
    public function getLandDataManager(): LandDataManager
    {
        return $this->landDataManager;
    }

    /**
     * @return StackFormManager
     */
    public function getStackFormManager(): StackFormManager
    {
        return $this->stackFormManager;
    }
}