<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$id = intval($_POST["id"]);
if(isset($id))
{
	$uid = $_SESSION["uid"];
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"DELETE FROM post WHERE id=$id and user=$uid");
	$q2 = mysqli_query($conc,"DELETE FROM `like` WHERE `id`= '$id'");
	if($q && $q2)
	{
		echo 1;	
	}
	else
	{
		echo 2;	
	}
	$con->close_db_con($conc);
}
?>