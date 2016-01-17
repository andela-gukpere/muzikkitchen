<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];
$cat = array("Artist of the Week","Artist of the Month");

$w = date("W");
$d = date("j");
$m  = date("n");
$y = date("Y");
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT * FROM cat WHERE month = $m");
while($r = mysqli_fetch_array($q))
{
	echo "<div><span style='font-size:15px'>$r[1] <br/><i style='font-size:10px;'>$r[5]</i></span><div><form>";
	$qq = mysqli_query($conc,"SELECT `cand`.`id`,`users`.`id`,`users`.`user`,`users`.`name` FROM cand INNER JOIN `users` ON `cand`.`uid` = `users`.`id`WHERE `cand`.`cat` = $r[0]");
	while($rr = mysqli_fetch_array($qq))
	{
		echo "<label href='./?i=$rr[1]' class='v_t'><input type='radio' title = '$rr[3]' value='$rr[1]' onclick='_vote(event,$rr[0])' name='cat$r[0]' />$rr[2]</label></br/>";			
	}
	echo "<input type='button' value='Vote' class='button1' onclick='_Vote(event,$r[0]);' /><input type='hidden' value='0' /></form></div></div>";
}

?>