<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
 
namespace fernanACM\KeyShop;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
# Libs
use Vecnavium\FormsUI\FormsUI;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;

use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;
# My files
use fernanACM\KeyShop\manager\KeyManager;
use fernanACM\KeyShop\utils\PluginUtils;

class KeyShop extends PluginBase{
    use SingletonTrait;

    /** @var Config $config */
    public Config $config;
    /** @var EconomyProvider $economyProvider */
    protected static EconomyProvider $economyProvider; 

    # CheckConfig
    private const CONFIG_VERSION = "1.0.0";

    /**
     * @return void
     */
    public function onLoad(): void{ 
        self::setInstance($this);
        $this->loadFiles();
    }

    /**
     * @return void
     */
    public function onEnable(): void{
        $this->loadCheck();
        $this->loadVirions();
    }

    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return boolean
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch($command->getName()){
            case "keyshop":
                if(!$sender instanceof Player){
                    $sender->sendMessage("Use this command in-game");
                    return false;
                }
                KeyManager::getInstance()->shop($sender);
            break;
        }
        return true;
    }

    /**
     * @return void
     */
    private function loadFiles(): void{
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml");
    }

    /**
     * @return void
     */
    private function loadCheck(): void{
        # CONFIG
        if((!$this->config->exists("config-version")) || ($this->config->get("config-version") != self::CONFIG_VERSION)){
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveResource("config.yml");
            $this->getLogger()->critical("Your configuration file is outdated.");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file has been generated. Please update accordingly.");
        }
    }

    /**
     * @return void
     */
    private function loadVirions(): void{
        foreach([
            "FormsUI" => FormsUI::class,
            "libPiggyEconomy" => libPiggyEconomy::class,
            "libPiggyUpdateChecker" => libPiggyUpdateChecker::class
            ] as $virion => $class
        ){
            if(!class_exists($class)){
                $this->getLogger()->error($virion . " virion not found. Please download KeyShop from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }
        # Update
        libPiggyUpdateChecker::init($this);
        # libPiggyEconomy
        libPiggyEconomy::init();
        self::$economyProvider = libPiggyEconomy::getProvider($this->config->get("Economy"));
    }

    /**
     * @return EconomyProvider
     */
    public static function getEconomy(): EconomyProvider{
        return self::$economyProvider;
    }

    /**
     * @param Player $player
     * @param string $key
     * @param array $customKeys
     * @return string
     */
    public static function getMessage(Player $player, string $key, array $customKeys = []): string{
        $messageArray = self::$instance->config->getNested($key, []);
        if(!is_array($messageArray)) $messageArray = [$messageArray];
        $message = implode("\n", $messageArray);
        foreach($customKeys as $search => $replacement){
            $message = str_replace($search, $replacement, $message);
        }
        return PluginUtils::codeUtil($player, $message);
    }

    /**
     * @return string
     */
    public static function getPrefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}