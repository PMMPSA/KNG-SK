<?php

namespace hmmhmmmm\boss\entity\walk;

use revivalpmmp\pureentities\entity\monster\walking\SnowGolem;
use revivalpmmp\pureentities\entity\monster\Monster;
use slapper\entities\SlapperHuman;
use hmmhmmmm\boss\BossData;
use hmmhmmmm\boss\Boss;

use pocketmine\Player;
use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Arrow;
use pocketmine\entity\projectile\Projectile;
use pocketmine\entity\projectile\ProjectileSource;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\level\sound\LaunchSound;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\StringTag;

class BossSnowGolem extends SnowGolem{
   public $health = 4;
   public $boss_data = "0xAAA001";
  
   public function getName(): string{
      $name = $this->boss_data;
      if(BossData::isBoss($name)){
         return "BossSnowGolem";
      }else{
         return parent::getName();
      }
   }
   
   public function attackEntity(Entity $player){
      if($this->attackDelay > 23 && $this->distanceSquared($player) <= 55){
         $this->attackDelay = 0;
         if($player instanceof Player){
            $f = 1.2;
            $yaw = $this->yaw + mt_rand(-220, 220) / 10;
            $pitch = $this->pitch + mt_rand(-120, 120) / 10;
            $nbt = new CompoundTag("", [
               "Pos" => new ListTag("Pos", [
                  new DoubleTag("", $this->x + (-sin($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI) * 0.5)),
                  new DoubleTag("", $this->y + 1.62),
                  new DoubleTag("", $this->z + (cos($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI) * 0.5))
               ]),
               "Motion" => new ListTag("Motion", [
                  new DoubleTag("", -sin($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI) * $f),
                  new DoubleTag("", -sin($pitch / 180 * M_PI) * $f),
                  new DoubleTag("", cos($yaw / 180 * M_PI) * cos($pitch / 180 * M_PI) * $f)
               ]),
               "Rotation" => new ListTag("Rotation", [
                  new FloatTag("", $yaw),
                  new FloatTag("", $pitch)
               ]),
            ]);
            $snowball = Entity::createEntity("Snowball", $this->getLevel(), $nbt, $this);
            $snowball->setMotion($snowball->getMotion()->multiply($f));
            $this->server->getPluginManager()->callEvent($launch = new ProjectileLaunchEvent($snowball));
            if($launch->isCancelled()){
               $snowball->kill();
            }else{
               $snowball->spawnToAll();
               $this->level->addSound(new LaunchSound($this), $this->getViewers());
            }
            $this->checkTamedMobsAttack($player);
         }
      }
   }

   public function getMaxHealth(): int{
      $name = $this->boss_data;
      if(BossData::isBoss($name)){
         return BossData::getHealth($name);
      }else{
         return $this->health;
      }
   }
   
       public function entityBaseTick(int $tickDiff = 1): bool{
        $hasUpdate = parent::entityBaseTick($tickDiff);
        $name = $this->boss_data;
        if(BossData::isBoss($name)){
            $max = $this->getMaxHealth();         $hp = $this->getHealth();
            $hps= ""; 
            for($i = 1; $i <=10;$i++){
                $check = $max * ($i * 10) / 100; 
                if($i == 1){
                   $hps .= "§a▃";
                }else{
                    if($hp >= $check){
                       $hps .= "§a▃";
                    }else{
                        $hps .= "§c▃"; 
                    }
                }
               
            }
            $this->setNameTag($name."\n$hps");
            $this->setNameTagAlwaysVisible(true);
            $this->setNameTagVisible(true);
            if($this->isOnFire()){
                $this->extinguish();
            }
            return $hasUpdate;
        }else{
            return parent::entityBaseTick($tickDiff);
        }
    }
   
   public function targetOption(Creature $creature, float $distance) : bool{
      if(!($creature instanceof SlapperHuman)){
         if($creature instanceof Player){
            return $this instanceof Monster
               && (!($creature instanceof Player)
               || ($creature->isSurvival() && $creature->spawned))
               && $creature->isAlive() && !$creature->isClosed()
               && $distance <= 81;
         }
      }
      return false;
   }
   
}