<?php

declare(strict_types=1);

namespace outiserver\landmanager\forms;

use Ken_Cir\LibFormAPI\FormContents\SimpleForm\SimpleFormButton;
use outiserver\economycore\Forms\Base\BaseForm;
use outiserver\landmanager\LandManagerMain;
use pocketmine\player\Player;

class AddLandForm implements BaseForm
{
    public const FORM_KEY = "add_land_form";

    public function execute(Player $player): void
    {
        $form = new SimpleFormButton();

        LandManagerMain::getInstance()->getStackFormManager()->addStackForm($player->getXuid(), self::FORM_KEY, $form);
    }
}