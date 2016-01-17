<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = intval($_SESSION["uid"]);
$color = intval($_POST["color"]);
$_SESSION["color"] = $color;
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"UPDATE users SET bgcolor = $color WHERE id=$uid;");
if($q)
{
	echo $color_array[$color];	
}
?>