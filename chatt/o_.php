<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit();
}

	$uid = intval($_SESSION["uid"]);
	$id = $_POST["id"];
	$pid = intval($_POST["uid"]);
	if(isset($uid))
	{
		$con = new db();$conc = $con->c();
	//	$qu = mysqli_query($conc,"SELECT `u1`,`u2`FROM `chat` WHERE  `id` = $id");
	//	$qua = mysqli_fetch_array($qu);
		$em = $pid;//$qua[0]==$uid?$qua[1]:$qua[0];
		$qum = mysqli_query($conc,"SELECT `date` FROM `online` WHERE `uid` = $em");
		$tma = mysqli_fetch_array($qum);
		$tm = intval($tma[0]);
		$t = date("U") - $tm;
		$onl = $t < 60 * 5?($t > 60 * 3?"<span style='color:#888;'>away</span>":"<span style='color:green;'>online</span>"):"<span style='color:red;'>offline</span>";
		$con->close_db_con($conc);
		echo($onl);
	}
	exit();
?>