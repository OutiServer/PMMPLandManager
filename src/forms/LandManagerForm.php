<?php

declare(strict_types=1);

namespace outiserver\landmanager\forms;

use Ken_Cir\LibFormAPI\FormContents\SimpleForm\SimpleFormButton;
use Ken_Cir\LibFormAPI\Forms\SimpleForm;
use outiserver\economycore\Forms\Base\BaseForm;
use outiserver\landmanager\LandManagerMain;
use pocketmine\player\Player;

class LandManagerForm implements BaseForm
{
    public const FORM_KEY = "land_manager_form";

    public function execute(Player $player): void
    {
        $form = new SimpleForm(LandManagerMain::getInstance(),
        $player,
        "土地保護",
        "",
        [
            new SimpleFormButton("土地の追加")
        ],
        function (Player $player, int $data) {
            if ($data === 0) {
                (new AddLandForm())->execute($player);
            }
        },
        function (Player $player) {
            LandManagerMain::getInstance()->getStackFormManager()->deleteStack($player->getXuid());
        });

        LandManagerMain::getInstance()->getStackFormManager()->addStackForm($player->getXuid(), self::FORM_KEY, $form);
    }
}