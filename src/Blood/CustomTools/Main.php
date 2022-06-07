<?php

namespace Blood\Customtools;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\block\BlockFactory;
use pocketmine\item\ItemFactory;
use pocketmine\item\VanillaItems;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\world\World;
use pocketmine\world\Position;
use pocketmine\world\Explosion;
use pocketmine\world\ChunkManager;
use pocketmine\math\VoxelRayTrace;
use pocketmine\math\Vector3;
use pocketmine\math\AxisAlignedBB;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\plugin\MethodEventExecutor;
use pocketmine\event\EventPriority;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\TextFormat;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

use Blood\Customtools\Command\CustomToolCommand;

class Main extends PluginBase implements Listener {
	
	public function onEnable() : void {
        $this->getLogger()->info("========Custom Tools Plugin By Bloodsucker Is Enable========");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("command", new CustomToolCommand($this, "customtools", "Opens Custom Tools Menu"));
        @mkdir($this->getDataFolder());
        $this->saveResource('config.yml', true);
        $this->getResource("config.yml");
	}
 
    public function form(Player $player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null) {
            if ($data === null) {
                return true;
            }
            switch ($data) {
                case 0:
                    $tool1 = ItemFactory::getInstance()->get(272, 0, 1);
                    $tool1->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool1->setCustomName("§r§l§eRabbit Sword");
                    $tool1->setLore(["§r§7Damage: §c50+\n§r§7Strength: §c25+\n\n§r§l§6•Item Ability: JUMP BOOST §d[§r§l§eRIGHT CLICK§d]\n§r§b•Right Click To Get Jump Boost\n§r§b•Like A Rabbit.\n\n§r§l§7COMMON"]);
                    $player->getInventory()->addItem($tool1);
                break;
                case 1:
                    $tool2 = ItemFactory::getInstance()->get(267, 0, 1);
                    $tool2->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool2->setCustomName("§r§l§eGolem Sword");
                    $tool2->setLore(["§r§7Damage: §c100+\n§r§7Strength: §c50+\n\n§r§l§6•Item Ability: EXPLOSION §d[§r§l§eRIGHT CLICK§d]\n§r§b•Right Click To Explosion In\n§r§b•Clicked Block Like A TNT.\n\n§r§l§aUNCOMMON"]);
                    $player->getInventory()->addItem($tool2);
                break;
                case 2:
                    $tool3 = ItemFactory::getInstance()->get(276, 0, 1);
                    $tool3->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool3->setCustomName("§r§l§eEnd Sword");
                    $tool3->setLore(["§r§7Damage: §c150+\n§r§7Strength: §c75+\n\n§r§l§6•Item Ability: TELEPORTING §d[§r§l§eRIGHT CLICK§d]\n§r§b•Right Click To Teleport In\n§r§b•Clicked Block Like A Enderman.\n\n§r§l§9RARE"]);
                    $player->getInventory()->addItem($tool3);
                break;
                case 3:
                    $tool4 = ItemFactory::getInstance()->get(283, 0, 1);
                    $tool4->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool4->setCustomName("§r§l§rGod Sword");
                    $tool4->setLore(["§r§7Damage: §c200+\n§r§7Strength: §c100+\n\n§r§l§6•Item Ability: THUNDER §d[§r§l§eRIGHT CLICK§d]\n§r§b•Right Click To Lighting In\n§r§b•Clicked Block Like A God.\n\n§r§l§eLEGENDARY"]);
                    $player->getInventory()->addItem($tool4);
                break;
                case 4:
                    $tool5 = ItemFactory::getInstance()->get(278, 0, 1);
                    $tool5->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool5->setCustomName("§r§l§eTelekinesis Pickaxe");
                    $tool5->setLore(["§r§l§6Item Ability: AUTO PICKUP §d[§r§l§eLEFT CLICK§d]\n§r§b•If You Mine Any Block So This\n§r§b•Automatically Come In You Inventory.\n\n§r§l§aUNCOMMON"]);
                    $player->getInventory()->addItem($tool5);
                break;
                case 5:
                    $tool6 = ItemFactory::getInstance()->get(278, 0, 1);
                    $tool6->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SILK_TOUCH(), 1));
                    $tool6->setCustomName("§r§l§eSmelt Pickaxe");
                    $tool6->setLore(["§r§l§6Item Ability: AUTO SMELT §d[§r§l§eLEFT CLICK§d]\n§r§b•If You Mine Any Block So This\n§r§b•Automatically Smelt In Items.\n\n§r§l§aUNCOMMON"]);
                    $player->getInventory()->addItem($tool6);
                break;
                case 6:
                    $tool7 = ItemFactory::getInstance()->get(278, 0, 1);
                    $tool7->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool7->setCustomName("§r§l§eHammer");
                    $tool7->setLore(["§r§l§6Item Ability: INSANE MINING §d[§r§l§eLEFT CLICK§d]\n§r§b•If You Mine Any Block So This\n§r§b•Will Mine 3 x 3 Cunk Of It.\n\n§r§l§aRARE"]);
                    $player->getInventory()->addItem($tool7);
                break;
                case 7:
                    $tool8 = ItemFactory::getInstance()->get(279, 0, 1);
                    $tool8->setCustomName("§r§l§eTelekinesis Axe");
                    $tool8->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $tool8->setLore(["§r§l§6Item Ability: AUTO PICKUP §d[§r§l§eLEFT CLICK§d]\n§r§b•If You Mine Any Block So This\n§r§b•Automatically Come In You Inventory.\n\n§r§l§aUNCOMMON"]);
                    $player->getInventory()->addItem($tool8);
                break;
                case 8:
                    $tool9 = ItemFactory::getInstance()->get(279, 0, 1);
                    $tool9->setCustomName("§r§l§eSmelt Axe");
                    $tool9->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SILK_TOUCH(), 1))
                    $tool9->setLore(["§r§l§6Item Ability: AUTO SMELT §d[§r§l§eLEFT CLICK§d]\n§r§b•If You Mine Any Block So This\n§r§b•Automatically Smelt In Items.\n\n§r§l§aUNCOMMON"]);
                    $player->getInventory()->addItem($tool9);
                break;
            }
        });
        $form->setTitle("§l§6CUSTOM TOOLS");
        $form->setContent("§dSelect The Which Custom Tool You Want:", 0, );
        $form->addButton("§r§l§eRabbit Sword\n§9»» §r§6Tap To Get", 0, "textures/items/stone_sword");
        $form->addButton("§r§l§eGolem Sword\n§9»» §r§6Tap To Get", 0, "textures/items/iron_sword");
        $form->addButton("§r§l§eEnd Sword\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_sword");
        $form->addButton("§r§l§eGod Sword\n§9»» §r§6Tap To Get", 0, "textures/items/gold_sword");
        $form->addButton("§r§l§eTelekinesis Pickaxe\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_pickaxe");
        $form->addButton("§r§l§eSmelt Pickaxe\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_pickaxe");
        $form->addButton("§r§l§eHammer\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_pickaxe");
        $form->addButton("§r§l§eTelekinesis Axe\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_axe");
        $form->addButton("§r§l§eSmelt Axe\n§9»» §r§6Tap To Get", 0, "textures/items/diamond_axe");
        $form->sendToPlayer($player);
        return $form;
    }
    public function break(BlockBreakEvent $e){
        $b = $e->getBlock();
        $p = $e->getPlayer();
        $i = $e->getItem();
      
        if($i->getId() === 278 && $i->getCustomName() === "§r§l§eTelekinesis Pickaxe"){
            $drops = $e->getDrops();
            foreach ($drops as $key => $drop) {
                if($p->getInventory()->canAddItem($drop)) {
                    $p->getInventory()->addItem($drop);
                    unset($drops[$key]);
                } else {
                    if($this->fullInvPopup != '') {
                        $p->sendPopup("§cInventory Is Full");
                    }
                }
            }
            $e->setDrops($drops);

            $xpDrops = $e->getXpDropAmount();
            $p->getXpManager()->addXp($xpDrops);
            $e->setXpDropAmount(0);
        }
        if($i->getId() === 279 && $i->getCustomName() === "§r§l§eTelekinesis Axe"){
            $drops = $e->getDrops();
            foreach ($drops as $key => $drop) {
                if($p->getInventory()->canAddItem($drop)) {
                    $p->getInventory()->addItem($drop);
                    unset($drops[$key]);
                } else {
                    if($this->fullInvPopup != '') {
                        $p->sendPopup("§cInventory Is Full");
                    }
                }
            }
               $e->setDrops($drops);

            $xpDrops = $e->getXpDropAmount();
            $p->getXpManager()->addXp($xpDrops);
            $e->setXpDropAmount(0);
        }
        if($i->getId() === 278 && $i->getCustomName() === "§r§l§eSmelt Pickaxe"){
            if($i->hasEnchantment(VanillaEnchantments::SILK_TOUCH(), 1)) {
                if($b->getId() === 4){
                    $item = ItemFactory::getInstance()->get(1, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 15){
                    $item = ItemFactory::getInstance()->get(265, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 16){
                    $item = ItemFactory::getInstance()->get(263, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 14){
                    $item = ItemFactory::getInstance()->get(266, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 56){
                    $item = ItemFactory::getInstance()->get(264, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 129){
                    $item = ItemFactory::getInstance()->get(388, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 21){
                    $item = ItemFactory::getInstance()->get(351, 4, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 73){
                    $item = ItemFactory::getInstance()->get(331, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 74){
                    $item = ItemFactory::getInstance()->get(331, 0, 1);
                    $e->setDrops([$item]);
                }
                if($b->getId() === 153){
                    $item = ItemFactory::getInstance()->get(406, 0, 1);
                    $e->setDrops([$item]);
                }
            }
        }
        if($i->getId() === 278 && $i->getCustomName() === "§r§l§eSmelt Axe"){
            if($i->hasEnchantment(VanillaEnchantments::SILK_TOUCH(), 1)) {
                if($b->getId() === 12) {
                    $item = ItemFactory::getInstance()->get(20, 0, 1);
                    $e->setDrops([$item]);
                }
            }
        }
        if($i->getId() === 278 && $i->getCustomName() === "§r§l§eSmelt Axe"){
            if($i->hasEnchantment(VanillaEnchantments::SILK_TOUCH(), 1)) {
                if($b->getId() === 12) {
                    $item = ItemFactory::getInstance()->get(20, 0, 1);
                    $e->setDrops([$item]);
                }
            }
        }
        if($i->getId() === 278 && $i->getCustomName() === "§r§l§eHammer") {
            $bx = $b->getPosition()->getX();
            $by = $b->getPosition()->getY();
            $bz = $b->getPosition()->getZ();
            $world = $b->getPosition()->getWorld();
            for($count = 0; $count >= -2; $count--) {
                $block = $world->getBlockAt($bx + 1, $by + $count, $bz);
                if($block->getId() != 7 && $block->getId() != 49) {
                    $world->setBlockAt($bx + 1, $by + $count, $bz, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block->getId(), $block->getMeta(), 1);
                    $world->dropItem(new Vector3($bx + 1, $by + $count, $bz), $blockdrop);
                }
                $block2 = $world->getBlockAt($bx - 1, $by + $count, $bz);
                if($block2->getId() != 7 && $block2->getId() != 49) {
                    $world->setBlockAt($bx - 1, $by + $count, $bz, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block2->getId(), $block2->getMeta(), 1);
                    $world->dropItem(new Vector3($bx - 1, $by + $count, $bz), $blockdrop);
                }
                $block3 = $world->getBlockAt($bx - 1, $by + $count, $bz + 1);
                if($block3->getId() != 7 && $block3->getId() != 49) {
                    $world->setBlockAt($bx - 1, $by + $count, $bz + 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block3->getId(), $block3->getMeta(), 1);
                    $world->dropItem(new Vector3($bx - 1, $by + $count, $bz + 1), $blockdrop);
                }
                $block4 = $world->getBlockAt($bx, $by + $count, $bz + 1);
                if($block4->getId() != 7 && $block4->getId() != 49) {
                    $world->setBlockAt($bx, $by + $count, $bz + 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block4->getId(), $block4->getMeta(), 1);
                    $world->dropItem(new Vector3($bx, $by + $count, $bz + 1), $blockdrop);
                }
                $block5 = $world->getBlockAt($bx + 1, $by + $count, $bz + 1);
                if($block5->getId() != 7 && $block5->getId() != 49) {
                    $world->setBlockAt($bx + 1, $by + $count, $bz + 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block5->getId(), $block5->getMeta(), 1);
                    $world->dropItem(new Vector3($bx + 1, $by + $count, $bz + 1), $blockdrop);
                }
                $block6 = $world->getBlockAt($bx - 1, $by + $count, $bz - 1);
                if($block6->getId() != 7 && $block6->getId() != 49) {
                    $world->setBlockAt($bx - 1, $by + $count, $bz - 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block6->getId(), $block6->getMeta(), 1);
                    $world->dropItem(new Vector3($bx - 1, $by + $count, $bz - 1), $blockdrop);
                }
                $block7 = $world->getBlockAt($bx, $by + $count, $bz - 1);
                if($block7->getId() != 7 && $block7->getId() != 49) {
                    $world->setBlockAt($bx, $by + $count, $bz - 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block7->getId(), $block7->getMeta(), 1);
                    $world->dropItem(new Vector3($bx, $by + $count, $bz - 1), $blockdrop);
                }
                $block8 = $world->getBlockAt($bx + 1, $by + $count, $bz - 1);
                if($block8->getId() != 7 && $block8->getId() != 49) {
                    $world->setBlockAt($bx + 1, $by + $count, $bz - 1, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block8->getId(), $block8->getMeta(), 1);
                    $world->dropItem(new Vector3($bx + 1, $by + $count, $bz - 1), $blockdrop);
                }
                $block9 = $world->getBlockAt($bx, $by - 1, $bz);
                if($block9->getId() != 7 && $block9->getId() != 49) {
                    $world->setBlockAt($bx, $by - 1, $bz, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block9->getId(), $block9->getMeta(), 1);
                    $world->dropItem(new Vector3($bx, $by - 1, $bz), $blockdrop);
                }
                $block10 = $world->getBlockAt($bx, $by - 2, $bz);
                if($block10->getId() != 7 && $block10->getId() != 49) {
                    $world->setBlockAt($bx, $by - 2, $bz, VanillaBlock::AIR());
                    $blockdrop = ItemFactory::getInstance()->get($block10->getId(), $block10->getMeta(), 1);
                    $world->dropItem(new Vector3($bx, $by - 2, $bz), $blockdrop);
                }
            }
        }
    }
    public function onuse(PlayerInteractEvent $e){
        $p = $e->getPlayer();
        $i = $e->getItem();
        $b =$e->getBlock();
        
        if($i->getId() === 283 && $i->getCustomName() === "§r§l§rGod Sword"){
			      $pos = $b->getPosition();
			      $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $b->getPosition()->asVector3(), null, $p->getLocation()->getYaw(), $p->getLocation()->getPitch(), 0.0, [], [], []);
			      $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
			      Server::getInstance()->broadcastPackets($p->getWorld()->getPlayers(), [$light2, $sound2]);
			  }
        if($i->getId() === 276 && $i->getCustomName() === "§r§l§eEnd Sword"){
			      $start = $p->getPosition()->add(0, $p->getEyeHeight(), 0);
			      $end = $start->addVector($p->getDirectionVector()->multiply($p->getViewDistance() * 16));
			      $world = $p->getWorld();
			      foreach(VoxelRayTrace::betweenPoints($start, $end) as $vector3){
				        if($vector3->y >= World::Y_MAX or $vector3->y <= 0){
					          return;
				        }
				        if(($result = $world->getBlock($vector3)->calculateIntercept($start, $end)) !== null){
					          $target = $result->hitVector;
					          $p->teleport($target);
					          return;
				        }
			      }
		    }
        if($i->getId() === 267 && $i->getCustomName() === "§r§l§eGolem Sword"){
			      $explosion = new Explosion(new Position($b->getPosition()->getX(), $b->getPosition()->getY(), $b->getPosition()->getZ(), $p->getWorld()), 1, null);
            $explosion->explodeB();
		    }
        if($i->getId() === 272 && $i->getCustomName() === "§r§l§eRabbit Sword"){
            $p->setMotion(new Vector3(3, 1, 3));
        }
        return true;
    }
}
