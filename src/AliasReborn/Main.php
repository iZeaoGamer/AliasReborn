<?php

namespace AliasReborn;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\{Utils, Config, TextFormat};
use pocketmine\command\{Command, CommandSender, CommandExecuter, CommandMap, ConsoleCommandSender};
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
	
	class Main extends PluginBase implements Listener{
	
		public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->saveDefaultConfig();
			if(is_dir($this->getDataFolder() . "alias/") == false){
				@mkdir($this->getDataFolder() . "alias/", 0777, true);
				}
			$this->getLogger()->info("Version: 2.0.0 for API: 3.0.0");
			$this->seedevice = $this->getServer()->getPluginManager()->getPlugin("SeeDevice");
		}
		public function onLoad(PlayerLoginEvent $event){
					$p = $event->getPlayer();
			$name = $p->getName();
			$ip = $p->getAddress();
			$uid = $p->getUniqueId();
			$cid = $p->getClientId();
			$xid = $p->getXuid();
			//$track = $this->getConfig()->get("track");
	//  if(strtolower($track) === "ip"){
				if(file_exists($this->getDataFolder() . "alias/" . $ip)){ //|| file_exists($this->getDataFolder() . "alias/". $modal){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $ip, true));
					if(!in_array($name, $file)){
						file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n", FILE_APPEND);
						
						$this->getLogger()->info("§aThis seems to be an alt on the same IP Address.\nyou should look into it if this person has been banned before or not.");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n");
						$this->getLogger()->info("§5No records found for this person.");
					}
		  $this->getLogger()->info("Checked IP Addresses.");
		}
		public function onJoin(PlayerJoinEvent $e){
			$p = $e->getPlayer();
			$name = $p->getName();
			$ip = $p->getAddress();
			$uid = $p->getUniqueId();
			$cid = $p->getClientId();
			$xid = $p->getXuid();
			$modal = $this->seedevice->getUsd($p);
		//	$track = $this->getConfig()->get("track");
	//  if(strtolower($track) === "ip"){
				if(file_exists($this->getDataFolder() . "alias/" . $modal)){ //|| file_exists($this->getDataFolder() . "alias/". $modal){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $modal, true));
					if(!in_array($name, $file)){
						file_put_contents($this->getDataFolder() . "alias/" . $modal, $name . ",\n", FILE_APPEND);
						$this->getLogger()->info("§aThis seems to be an alt on the same Device.\nyou should look into it if this person has been banned before or not.");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $modal, $name . ",\n");
						$this->getLogger()->info("§5No records found for this person.");
					}
$this->getLogger()->info("Device Checked.");
				}
	
		public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
			switch(strtolower($command->getName())){
				case "alias":
				if(!isset($args[1])){
					$sender->sendMessage(TextFormat::colorize("&5Please use: &6/alias <player> <ip/device>"));
					return true;
				}
					$p = $this->getServer()->getPlayer($args[0]);
					if($p == null && !$p->isOnline() && !$p instanceof Player){
						$sender->sendMessage(TextFormat::colorize("&cPlayer &4" . $args[0] . " &cnot found."));
						return true;
					}
						$ip = $p->getAddress();
							switch($args[1]){
            
								case "ip":
$contents = file_get_contents($this->getDataFolder() . "alias/" . $ip, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage("§5Here are the accounts this player is using on that ip: §6". $final_list);
							break;
								case "device":
									$modal = $this->seedevice->getUsd($p);
							$contents = file_get_contents($this->getDataFolder() . "alias/" . $modal, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage("§5Here are the accounts this player is using on that Device: §6" . $final_list);
							
					break;
							}
					         return true;
						
		}
		
	}
}
