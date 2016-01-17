<?php
session_start();
include("../scripts/db.php");

if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = $_SESSION["uid"];
$msg = _hstr_(strclean($_POST["msg"]),false);
$id = $_POST["id"];
$time = $_POST["time"];

if( isset($msg) && isset($id) && $id!="" && $msg !="")
{
	$con = new db();$conc = $con->c();
	$id=trim($id);
	//$u = users($conc,"`user`",$user);
	mysqli_kill($conc,mysqli_thread_id($con->c()));
	mysqli_close($con->c());
	$out_name = $_SESSION["user"];//"$u[0]";
	$fullmsg = "\n<tr><td><b>$out_name</b>: <span>$msg</span><br/><span class='tt' style='float:right' udate='".date("U")."'>$time</span></tr></td>";
	$file = "../chatt/room/$id.dat";
	if(is_file($file))
	{
		$cfile = fopen($file,"a");
		fwrite($cfile,$fullmsg);
	}
	else
	{
		$cfile = fopen($file,"w");
		fwrite($cfile,$fullmsg);
	}
	fclose($cfile);
}
exit();
?>