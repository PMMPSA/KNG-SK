<?php

declare(strict_types=1);

namespace CLADevs\Minion;

use CLADevs\Minion\entities\types\FarmerMinion;
use CLADevs\Minion\entities\types\MinerMinion;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

    /** @var Main */
	private static $instance;
	/** @var array  */
	private $removeTap = [];

	public function onLoad(): void{
		self::$instance = $this;
		$this->saveDefaultConfig();
	}

	public function onEnable(): void{
	    Entity::registerEntity(MinerMinion::class, true);
	    Entity::registerEntity(FarmerMinion::class, true);
	    $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

	public static function get(): self{
		return self::$instance;
	}

	public function isInRemove(Player $player): bool{
	    return isset($this->removeTap[$player->getName()]);
    }

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
	    if($command->getName() === "minion"){
	        if(!$sender->hasPermission("minion.commands")){
	            $sender->sendMessage(TextFormat::RED . "You don't have permission to run this command.");
	            return false;
            }
	        if(!isset($args[1]) && (!$sender instanceof Player || !isset($args[0]))){
                $sender->sendMessage("Usage: /minion (miner|farmer) (player)");
                return false;
            }
	        if($sender instanceof Player && isset($args[0]) && in_array(strtolower($args[0]), ["rm", "remove", "forceremove"])){
	            if($this->isInRemove($sender)){
	                $sender->sendMessage(TextFormat::GREEN . "You have left the minion removable mode.");
	                unset($this->removeTap[$sender->getName()]);
	                return true;
                }
	            $sender->sendMessage(TextFormat::GREEN . "You have entered minion removable mode.");
	            $sender->sendMessage(TextFormat::YELLOW . "To disable repeat same command.");
	            $this->removeTap[$sender->getName()] = $sender;
	            return true;
            }
	        $player = $sender;
	        if(isset($args[1]) && (!$player = $this->getServer()->getPlayer($args[1]))){
                $sender->sendMessage(TextFormat::RED . "That player could not be found.");
                return false;
            }
	        $type = $args[0];
	        switch(strtolower($type)){
                case "miner":
                case "m":
                    $type = MinerMinion::NAME;
                    break;
                case "farmer":
                case "f":
                    $type = FarmerMinion::NAME;
                    break;
                default:
                    $type = null;
                    break;
            }
            if($type === null){
                $sender->sendMessage(TextFormat::RED . "Unknown type: " . $args[0]);
                return false;
            }
            if($player instanceof Player){
                $player->getInventory()->addItem(self::asItem($type, $player));
                $sender->sendMessage(TextFormat::GREEN . "Given " . $player->getName() . " $type minion spawner.");
            }
        }
        return true;
    }

    public static function asItem(string $type, Player $sender, int $level = 1, string $xyz = "n"): Item{
        $minionType = "Miner";
	    $msgByType = "I will mine block in front me";
	    if($type === FarmerMinion::NAME){
	        $minionType = "Farmer";
	        $msgByType = "I will harvest crops around me";
        }
	    $lore = [];
	    foreach(
	        [
                " ",
                C::GRAY . "• " . C::YELLOW . "    §e§lKnight§fGhost§cVN",
                C::GRAY . "• " . C::YELLOW . "§eHãy Làm Theo Các Bước Dưới Đây Để Có Thể Xài §cMinion §eĐúng Cách",
                C::GRAY . "• " . C::YELLOW . "§eBước 1: Xác Định Chỗ Muốn Đặt §cMinion§e Xuống!",
                C::GRAY . "• " . C::YELLOW . "§eBước 2: Quay Người Lại Với Chỗ Muốn Đặt §cMinion§e Rồi Đặt Xuống!",
                C::GRAY . "• " . C::YELLOW . "§eBước 3: Nếu §cMinion§e Chưa Chịu Hoạt Động Bạn Hãy Nhấp Vào §cMinion\n§e Sau Đó Chọn <§cLiên Kết Rương§e> Rồi Lại Nhấp Vào Rương!",
                C::GRAY . "• " . C::YELLOW . "§eNếu Làm Xong Các Bước Trên Thì Bạn Đã Setup Thành Công Cho §cMinion!",
                C::GRAY . "• " . C::RED . "§eCÁC NƠI §cMINION§e KHÔNG THỂ SPAWN§f: ",
                C::GRAY . "• " . C::RED . "SPAWN, PVP, PARKOUR, MINIGAME, BOSS"
            ] as $l){
	        $lore[] = C::RESET . C::GRAY . "* " . C::YELLOW . $l;
        }
        $item = Item::get(Item::NETHER_STAR);
        $item->setCustomName(C::RESET . C::BOLD . C::AQUA . "* " . C::GOLD . "Minion " . C::AQUA . "$minionType *");
        $item->setLore($lore);
        $nbt = $item->getNamedTag();
        $nbt->setString("summon", $type);
        $nbt->setString("player", $sender->getName());
        $nbt->setString("xyz", $xyz);
        $nbt->setInt("level", $level);
        $item->setNamedTag($nbt);
        return $item;
    }
}
