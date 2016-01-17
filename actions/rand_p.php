<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
	$mob = $_GET["mobile"];
	$con = new db();$conc = $con->c();
	$done_array = array();
	$ff_array = array();
	$n = 0;
	$uid = intval($_SESSION["uid"]);
	$res = "<table width='100%' align='center' ><tr>";
	$qf = $con->query("follow","u1,u2","u2 = $uid OR u1 = $uid");
	while($r = mysqli_fetch_array($qf[1]))
	{
		$_us = $r[0] == $uid?$r[1]:$r[0];
		array_push($ff_array,$_us);
	}
	$con->close_db_con($qf[2]);
	$r = NULL;
	$q  = mysqli_query($conc,"SELECT * FROM users INNER JOIN follow on users.id = follow.u1 WHERE follow.u1 <> $uid AND follow.u2 <> $uid AND users.id <> $uid ORDER BY users.id DESC ");
		while($r = mysqli_fetch_array($q))
		{
			if(in_array($r[0],$done_array) || in_array($r[0],$ff_array)  ){continue;}
			$n++;
			$bbb = PTH;
			$ajax = "onclick='return _pop(event,$r[0])'";	
			if(isset($mob))
			{		
				$ajax ="";
			}
			if($n == 9){break;}
			//$border=$n?"style='border:1px dashed #336699'":"";
			$res .= "<td align='center'><a style='color:#777;font-size:10px;' href='".PTH."/$r[2]' title='@$r[2]' $ajax ><div class='ssmpdiv' style='background-image:url($bbb$r[7])' ></div></a></td>";	
			$res .= $n % 4 == 0?"</tr><tr>":"";		
			array_push($done_array,$r[0]);
		}
		
	$res .= "</tr></table>__::__<table width='100%' align='center'><tr>";	
	$q = NULL;
	$r = NULL;
	$n = 0;
	$following = array();
	$q = mysqli_query($conc,"SELECT u2 FROM follow WHERE u1 = $uid");
	
		array_push($following,$uid);
		while($r = mysqli_fetch_array($q))
		{
			array_push($following,$r[0]);
		}
		$r = NULL;
		$q = NULL;

	$q = mysqli_query($conc,"SELECT follow.u1,users.user,users.img1,users.name FROM follow INNER JOIN users on users.id = follow.u1 WHERE follow.u2 = $uid");
	while($r = mysqli_fetch_array($q))
	{
		if(!in_array($r[0],$following))		
		{
			$n++;		
			$ajax = "onclick='return _pop(event,$r[0])' ";	
			$bbb = ".";
			if(isset($mob))
			{
				$ajax ="";
				//$bbb = "..";	
			}	
			$res .= "<td align='center'><a style='color:#777;font-size:10px;' href='".PTH."/$r[1]' title='@$r[1]' $ajax><div  class='ssmpdiv' style='background-image:url(".PTH."$r[2])' ></div></a></td>";
			$res .= $n % 4 == 0?"</tr><tr>":"";
			if($n == 8){break;}			
		}
	}
	if($n == 0)
		{
			$res .= "<td align='center'>Your dining back 100%</td>";	
		}
	$res .= "</tr></table>";
	echo $res;
	$con->close_db_con($conc);
?>
