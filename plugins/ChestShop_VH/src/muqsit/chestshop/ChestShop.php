<?php

declare(strict_types=1);

namespace muqsit\chestshop;

use muqsit\chestshop\button\ButtonFactory;
use muqsit\chestshop\button\ButtonIds;
use muqsit\chestshop\button\CategoryButton;
use muqsit\chestshop\category\Category;
use muqsit\chestshop\database\Database;
use muqsit\chestshop\libs\muqsit\invmenu\InvMenu;
use muqsit\chestshop\libs\muqsit\invmenu\transaction\DeterministicInvMenuTransaction;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

final class ChestShop{

	/** @var Database */
	private $database;

	/** @var InvMenu */
	private $menu;

	/** @var Category[] */
	private $categories = [];

	public function __construct(Database $database){
		$this->database = $database;
		$this->menu = InvMenu::create(InvMenu::TYPE_CHEST)
			->setName("Menu Danh Mục")
			->setListener(InvMenu::readonly(function(DeterministicInvMenuTransaction $transaction) : void{
				$button = ButtonFactory::fromItem($transaction->getItemClicked());
				if($button instanceof CategoryButton){
					$player = $transaction->getPlayer();
					$category = null;
					try{
						$category = $this->getCategory($button->getCategory());
					}catch(\InvalidArgumentException $e){
						$player->sendMessage(TextFormat::RED . $e->getMessage());
						return;
					}

					if(!$category->send($player)){
						$player->removeWindow($transaction->getAction()->getInventory());
						$player->sendMessage(TextFormat::RED . "Danh mục này hiện tại đang trống.");
					}
				}
			}));
	}

	public function addCategory(Category $category, bool $update = true) : void{
		if(isset($this->categories[$name = $category->getName()])){
			throw new \InvalidArgumentException("§aDanh mục có tên §f[§l§a• §c {$name}§a •§f] §ađã tồn tại.");
		}

		$this->categories[$name] = $category;
		$this->menu->getInventory()->addItem(ButtonFactory::get(ButtonIds::CATEGORY, $category->getName(), $category->getButton()));

		if($update){
			$this->database->addCategory($category, function(int $id) use($category) : void{
				$category->init($this->database, $id);
			});
		}
	}

	public function removeCategory(string $name) : void{
		if(!isset($this->categories[$name])){
			throw new \InvalidArgumentException("§aKhông có danh mục nào có tên §f[§l§a• §c {$name}§a •§f] §ađang tồn tại.");
		}

		$category = $this->categories[$name];
		unset($this->categories[$name]);

		$inventory = $this->menu->getInventory();
		$contents = $inventory->getContents();
		foreach($contents as $slot => $item){
			$button = ButtonFactory::fromItem($item);
			if($button instanceof CategoryButton && $button->getCategory() === $name){
				unset($contents[$slot]);
			}
		}

		$inventory->setContents($contents);
		$this->database->removeCategory($category);
	}

	public function getCategory(string $name) : Category{
		if(!isset($this->categories[$name])){
			throw new \InvalidArgumentException("§aKhông có danh mục nào có tên §f[§l§a• §c {$name}§a •§f] §ađang tồn tại.");
		}

		return $this->categories[$name];
	}

	/**
	 * @return Category[]
	 */
	public function getCategories() : array{
		return $this->categories;
	}

	public function send(Player $player) : void{
		$this->menu->send($player);
	}
}