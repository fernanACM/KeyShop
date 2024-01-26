<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
 
namespace fernanACM\KeyShop\manager;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

use pocketmine\console\ConsoleCommandSender;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\KeyShop\KeyShop;
use fernanACM\KeyShop\utils\PluginUtils;

final class KeyManager{
    use SingletonTrait;

    private function __construct(){
        self::setInstance($this);
    }

    /**
     * @param Player $player
     * @return void
     */
    public function shop(Player $player): void{
        $configData = KeyShop::getInstance()->config->getNested("KeyShop");
        $server = Server::getInstance();
        if(!is_array($configData)){
            $player->sendMessage(KeyShop::getPrefix() . KeyShop::getMessage($player, "Messages.error.no-config"));
            return;
        }
        $form = new SimpleForm(function(Player $player, $data) use ($server, $configData){
            if(is_null($data)){
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
            $keys = array_keys($configData);
            $data = (int)$data;
            if(isset($keys[$data])){
                $selectedKey = $keys[$data]; // Obtener la llave seleccionada
                $keyData = $configData[$selectedKey];

                $price = intval($keyData["price"]);
                $amount = intval($keyData["amount"]) ?? 1;
                $buttonCommand = KeyShop::getInstance()->config->get("Key-command");
                KeyShop::getEconomy()->getMoney($player, function(int|float $myMoney) use($buttonCommand, $server, $player, $price, $selectedKey, $amount){
                    if($myMoney >= $price){
                        $command = str_replace(["{PLAYER}", "{KEY}", "{AMOUNT}"], [$player->getName(), $selectedKey, $amount], $buttonCommand);
                        KeyShop::getEconomy()->takeMoney($player, $price);
                        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
                        $player->sendMessage(KeyShop::getPrefix(). KeyShop::getMessage($player, "Messages.success.successful-purchase", ["{KEY}" => $selectedKey, "{PRICE}" => $price, "{AMOUNT}" => $amount]));
                        PluginUtils::PlaySound($player, "mob.villager.yes", 1, 1);
                        $this->shop($player);
                    }else{
                        $player->sendMessage(KeyShop::getPrefix(). KeyShop::getMessage($player, "Messages.error.no-money"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                    }
                });
            }else{
                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                return;
            }
        });
        $index = 0;
        $form->setTitle(KeyShop::getMessage($player, "Form.title"));
        $form->setContent(KeyShop::getMessage($player, "Form.content"));
        foreach($configData as $key => $button){
            $url = is_string($button["image"]) && (str_starts_with($button["image"], "http://") || str_starts_with($button["image"], "https://"));
            $price = intval($button["price"]);
            $amount = intval($button["amount"]) ?? 1;
            if(isset($button["name"])){
                $buttonInfo = str_replace(["{LINE}", "{PRICE}", "{AMOUNT}"], ["\n", $price, $amount], TextFormat::colorize($button["name"]));
                $form->addButton($buttonInfo, $url ? 1 : 0, $button["image"] ?? null, $index);
                $index++;
            }
        }
        $player->sendForm($form);
    }  
}