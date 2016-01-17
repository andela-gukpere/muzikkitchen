<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = intval($_SESSION["uid"]);
$id = $_POST["id"];
if(isset($id))
{
	$id = trim($id);
   	$file = "../chatt/room/$id.dat";
	if(is_file($file))
	{
		unlink($file);
	}	
}
exit();
?>