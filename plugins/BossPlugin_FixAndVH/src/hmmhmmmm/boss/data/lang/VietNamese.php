<?php

namespace hmmhmmmm\boss\data\lang;

class VietNamese{

   public static function init(): array{
      return [
         "reset" => false,
         "version" => 1,
         "notfound.plugin" => "§cPlugin sẽ không hoạt động nếu bạn không cài plugin hỗ trợ%1",
         "notfound.libraries" => "§cLibraries %1 not found, Please download this plugin to as .phar",
         "plugininfo.name" => "§fTên plugin %1",
         "plugininfo.version" => "§fVersion %1",
         "plugininfo.author" => "§fList of creators %1",
         "plugininfo.description" => "§fDescription of the plugin. §eis a plugin free. If you redistribute it, please credit the creator. :)",
         "plugininfo.facebook" => "§fFacebook %1",
         "plugininfo.youtube" => "§fYoutube %1",
         "plugininfo.website" => "§fWebsite %1",
         "plugininfo.discord" => "§fDiscord %1",
         "boss.death.message1" => "§l§aNgười chơi §f[§c%1§f] §ađã tiêu diệt thành công boss §f[§c%2§f] §avà nhận được phần thưởng §f[§c%3§f]",
         "boss.death.message2" => "§eBoss §f[§c%2§f] §esẽ được hồi sinh trong §f%1 nữa",
         "boss.spawn" => "§eBoss §f[§c%2§f] §eđã được hồi sinh!",
         "boss.respawninfo" => "§eBoss §f%1\n§esẽ được hồi sinh trong \n§c%2§e nữa\n §l§cVui Lòng Đợi",
         "command.consoleError" => "§cSorry: commands can be typed only in the game.",
         "command.permissionError" => "§cSorry: You cannot type this command.",
         "command.sendHelp.empty" => "§eYou can see more commands by typing /boss help",
         "command.info.usage" => "/boss info",
         "command.info.description" => "§fCredit of the plugin creator",
         "command.help.usage" => "/boss help",
         "command.help.description" => "§fHelp",
         "command.create.usage" => "/boss create <NameTheBoss> <Monster> <Health> <Damage>",
         "command.create.description" => "§fTạo boss",
         "command.create.error1" => "§cLỗi: %1",
         "command.create.error2" => "§cBoss %1 đã tồn tại",
         "command.create.error3" => "§cMob không tồn tại %1",
         "command.create.complete" => "§aBoss §f%1§a với mob §f%2 §ađã được tạo thành công!",
         "command.remove.usage" => "/boss remove <BossName>",
         "command.remove.description" => "§fXoá boss",
         "command.remove.error1" => "§cLỗi: %1",
         "command.remove.error2" => "§cBoss §f%1§c không tồn tại",
         "command.remove.complete" => "§aĐã xoá thành công boss §f%1",
         "command.respawn.usage" => "/boss respawn <BossName>",
         "command.respawn.description" => "§fHồi sinh boss",
         "command.respawn.error1" => "§cLỗi: %1",
         "command.respawn.error2" => "§cBoss §f%1§c không tồn tại",
         "command.respawn.complete" => "§aBoss §f%2 §esẽ được hồi sinh trong §f%1 nữa",
         "command.setrespawn.usage" => "/boss setrespawn <BossName> <Time>",
         "command.setrespawn.description" => "§fChỉnh sửa hồi sinh boss",
         "command.setrespawn.error1" => "§cLỗi: %1",
         "command.setrespawn.error2" => "§cBoss §f%1§c không tồn tại",
         "command.setrespawn.complete" => "§aBoss §f%2 §esẽ được hồi sinh trong §f%1 nữa",
         "command.slapper_respawn.usage" => "/boss slapper_respawn <BossName>",
         "command.slapper_respawn.description" => "§fTạo NPC hồi sinh Boss",
         "command.slapper_respawn.error1" => "§cLỗi: %1",
         "command.slapper_respawn.error2" => "§cBoss §f%1§c không tồn tại",
         "form.menu.button1" => "§c♦§a Tạo §9Boss§c ♦",
         "form.menu.button2" => "§c♦§a Tạo §9boss-object§c ♦",
         "form.create.input1" => "§l§c• §aTên Boss §c•",
         "form.create.input2" => "§l§c• §aThời Gian Hồi Sinh §c(giây) §c•",
         "form.create.input3" => "§l§c• §aThời Gian Hồi Sinh Khi Chết §c(giây)§c •",
         "form.create.input4" => "§l§c• §aMáu §c•",
         "form.create.input5" => "§l§c• §aTốc Độ Di Chuyển §f/ §aBay §c•",
         "form.create.input6" => "§l§c• §aKích Thước §c•",
         "form.create.input7" => "§l§c• §aDamage Thấp Nhất §c•",
         "form.create.input8" => "§l§c• §aDamage Cao Nhất §c•",
         "form.create.input9" => "§l§c• §aTin Nhắn Phần Thưởng §c•",
         "form.create.input10" => "§l§c•> §aLệnh Phần Thưởng §c•",
         "form.create.error1" => "§cLỖI\n§e<%1> CẦN PHẢI NHẬP",
         "form.create.error2" => "§cLỖI\n§e<%1> VUI LÒNG GHI BẰNG SỐ!",
         "form.edit.button1" => "§l§c♦ §aChỉnh Sửa Boss §c♦",
         "form.edit.button2" => "§l§c♦ §aĐặt Hồi Sinh §c♦",
         "form.edit.button3" => "§l§c♦ §aHồi Sinh§c ♦",
         "form.edit.button4" => "§l§c♦ §aTạo NPC Hồi Sinh Boss§c ♦",
         "form.edit.button5" => "§l§f[§cXoá Boss§f]",
         "form.edit2.complete" => "§aBoss §f%1 §ađã được chỉnh sửa thành công",
         "form.remove.content" => "§aBạn có chắc muốn xoá boss §f%1 §akhông?",
         "form.remove.button1" => "§aCó",
         "form.remove.button2" => "§cKhông",
         "utils.sendtime.msgday" => "ngày.",
         "utils.sendtime.msghours" => "giờ.",
         "utils.sendtime.msgminutes" => "phút.",
         "utils.sendtime.msgseconds" => "giây.",
         "utils.makeslapper.complete" => "§aĐã tạo thành công NPC spawn boss!"
      ];
   }
   
}