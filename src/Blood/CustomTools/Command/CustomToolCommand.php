<?php

namespace Customtools\Blood\Command;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use Customtools\Blood\Main;

class CustomToolCommand extends Command {
    public $plugin;
    public function __construct(Main $plugin, $name, $description) {
        $this->plugin = $plugin;
        parent::__construct($name, $description);
        $this->setAliases(["ctools"]);
        $this->setPermission("cmd.ctools.use");
    }
    public function execute(CommandSender $sender, string $label, array $args) : bool {
        if(!$sender->hasPermission("cmd.ctools.use")) {
            $sender->sendMessage("§cYou Don't Have Permission To Use This Command!");
        }
        if($sender instanceof Player) {
            $this->plugin->form($sender);
        }else{
            $sender->sendMessage("Please Use This Command In Game");
        }
        return true;
    }
}
