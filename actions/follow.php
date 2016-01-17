<?php
session_start();
$notify = true;
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = $_SESSION["uid"];
$u2 = $_POST["u2"];
if($uid == $u2)
{
	exit("Impossible argument");	
}
if(isset($uid,$u2))
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"select id from follow where u1 = $uid and u2 = $u2");
	if(mysqli_num_rows($q)!= 1)
	{
		$q = NULL;
		$q = $con->insertInto("follow",array($uid,$u2,date("U")));
		if($q)
		{
			if(me_n_you($conc,$uid,$u2))
			{
				$q = $con->insertInto("hist",array(2,$u2,$uid,"",date("U")));
				$q = NULL;
				$q = $con->insertInto("chat",array($uid,$u2,date("U")));	
				
				//mail
			s_mail($_SESSION["user"]," is dinning back with you",$u2,$conc," is dinning back with you");
				//mail
			}
			else
			{
				$q = $con->insertInto("hist",array(1,$u2,$uid,"",date("U")));
				s_mail($_SESSION["user"]," is dinning with you",$u2,$conc," is dinning with you");
			}
			echo 1;	
		}
	}
	else
	{
		$q = NULL;
		$q = mysqli_query($conc,"DELETE FROM follow where u1=$uid AND u2=$u2");
		if($q)
		{
			$q = NULL;
			$q = mysqli_query($conc,"SELECT id FROM chat WHERE (u1 = $uid AND u2 = $u2) OR (u1 = $u2 AND u2 = $uid)");
			$r = mysqli_fetch_array($q);
			$q = NULL;
			$q = mysqli_query($conc,"DELETE FROM chat where (u1=$uid AND u2=$u2) OR (u1=$u2 AND u2=$uid)");
			$q = $con->insertInto("hist",array(3,$u2,$uid,"",date("U")));
			echo 2;
			if(is_file("../chatt/room/$r[0]".".dat"))	
			{
				unlink("../chatt/room/$r[0]".".dat");
			}
		}
	}
	$con->close_db_con($conc);
}
?>