<?php
session_start();
$uid = intval($_SESSION["uid"]);
if(!isset($_SESSION["user"],$_SESSION["uid"]) || $uid == 0)
{
	exit();
}
include("../scripts/db.php");
$id = intval($_POST["id"]);
$userid = intval($_POST["userid"]);
if(isset($id))
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `id` FROM `like` WHERE `uid`=$uid AND `id`=$id");
	if(mysqli_num_rows($q) == 0)
	{
		$qp = mysqli_query($conc,"INSERT INTO `like` VALUES($id,$uid)");
		if($userid != $uid)
		{
			$qq = $con->insertInto("hist",array(7,$userid,$uid,$id,date("U")));
			s_mail($_SESSION["user"]," likes your <a href='http://muzikkitchen.com/?view=$id&t=0'>feed</a>",$userid,$conc,"likes your feed");
		}
		echo 1;
	}
	else
	{
		$qp = mysqli_query($conc,"DELETE FROM `like` WHERE `uid` = $uid AND `id` =$id");
		$qq = 	mysqli_query($conc,"DELETE FROM hist WHERE var1=$userid AND var2 = $uid AND var3 = '$id' ");
		echo 2;
	}
	$con->close_db_con($conc);
}
?>