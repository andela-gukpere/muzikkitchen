<?php
session_start();
$uid = intval($_SESSION["uid"]);
if(!isset($_SESSION["user"],$_SESSION["uid"]))
{
	exit();
}
include("../actions/main.php");

?>