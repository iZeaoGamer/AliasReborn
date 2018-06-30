<?php

namespace AliasReborn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\{Utils, Config, TextFormat};
use pocketmine\command\{Command, CommandSender, CommandExecuter, CommandMap, ConsoleCommandSender};

use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\inventory\PlayerInventory;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\entity\Effect;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\player\{PlayerChatEvent, PlayerCommandPreprocessEvent, PlayerJoinEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener{

public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->saveDefaultConfig();
if(is_dir($this->getDataFolder() . "alias/") == false){
@mkdir($this->getDataFolder() . "alias/", 0777, true);
}
}

public function onJoin(PlayerJoinEvent $e){
$p = $e->getPlayer();
$name = $p->getName();
$ip = $p->getAddress();
$uid = $p->getUniqueId();
$cid = $p->getClientId();
$xb = $p->getXuid();
$track = $this->getConfig()->get("track");
if($track == strtolower("ip")){
if(file_exists($this->getDataFolder() . "alias/" . $ip)){
file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n", FILE_APPEND);
} else {
file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n");
}
}
if($track == strtolower("uid")){
if(file_exists($this->getDataFolder() . "alias/" . $uid)){
file_put_contents($this->getDataFolder() . "alias/" . $uid, $name . ",\n", FILE_APPEND);
} else {
file_put_contents($this->getDataFolder() . "alias/" . $uid, $name . ",\n");
}
}
if($track == strtolower("cid")){
if(file_exists($this->getDataFolder() . "alias/" . $cid)){
file_put_contents($this->getDataFolder() . "alias/" . $cid, $name . ",\n", FILE_APPEND);
} else {
file_put_contents($this->getDataFolder() . "alias/" . $cid, $name . ",\n");
}
}
if($track == strtolower("xid")){
if(file_exists($this->getDataFolder() . "alias/" . $xb)){
file_put_contents($this->getDataFolder() . "alias/" . $xb, $name . ",\n", FILE_APPEND);
} else {
file_put_contents($this->getDataFolder() . "alias/" . $xb, $name . ",\n");
}
}
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args): bool {
switch(strtolower($command->getName())){
case "alias":
if(isset($args[0])){
$p = $this->getServer()->getPlayer($args[0]);
if($p != null && $p->isOnline() && $p instanceof Player){
$ip = $p->getAddress();
$uid = $p->getUniqueId();
$cid = $p->getClientId();
$xb = $p->getXuid();
$track = strtolower($this->getConfig()->get("track"));
if($track == strtolower("ip")){
$contents = file_get_contents($this->getDataFolder() . "alias/" . $ip, true);
$final_list = implode(", ", array_unique(explode(",\n", $contents)));
$sender->sendMessage($final_list);
}
if($track == strtolower("uid")){
$contents = file_get_contents($this->getDataFolder() . "alias/" . $uid, true);
$final_list = implode(", ", array_unique(explode(",\n", $contents)));
$sender->sendMessage($final_list);
}
if($track == strtolower("cid")){
$contents = file_get_contents($this->getDataFolder() . "alias/" . $cid, true);
$final_list = implode(", ", array_unique(explode(",\n", $contents)));
$sender->sendMessage($final_list);
}
if($track == strtolower("xid")){
$contents = file_get_contents($this->getDataFolder() . "alias/" . $xb, true);
$final_list = implode(", ", array_unique(explode(",\n", $contents)));
$sender->sendMessage($final_list);
}
return true;
} else {
$sender->sendMessage("Player not online or does not exist.");
return false;
}
} else {
$sender->sendMessage("Usage: /alias <player>");
return false;
}
break;
}
}

}
