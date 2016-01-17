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
   $con = new db();
   $conc  = $con->c();
   mysqli_query($conc,"DELETE FROM `open_chat` WHERE `u1` = $uid AND `cid` =$id");
   $con->close_db_con($conc);
}
exit();
?>