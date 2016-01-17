<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$cid = intval($_POST["cid"]);
$cat = intval($_POST["cat"]);
$uid = $_SESSION["uid"];
if($cid != 0)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT id FROM votes WHERE uid = $uid AND cat = $cat");
	if(mysqli_num_rows($q) == 0)
	{
		$q = NULL;
		$q = $con->insertInto("votes",array($uid,$cid,$cat));
		$qq = mysqli_query($conc,"UPDATE cand SET votes = votes + 1 WHERE id = $cid;");
		echo $q && $qq?"Vote success":"Error occured voting";		
	}
	else
	{
		echo "Already Voted";
	}	
	echo getVoteScreen($conc,$cat,"");
	$con->close_db_con($conc);
}
?>