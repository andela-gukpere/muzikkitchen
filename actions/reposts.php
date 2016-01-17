<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$uid = intval($_SESSION["uid"]);
	$pag = isset($_POST["page"])?intval($_POST["page"]):0;
	$owner = intval($_POST["owner"]);
	$n = 0;
	$mypost = array();
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `id` FROM post WHERE user = $uid");
	while($r = mysqli_fetch_array($q))
	{
		array_push($mypost,$r[0]);	
	}
	$q = NULL;$r = NULL;
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`type` = 2 ORDER BY `post`.`id` DESC");
	while($r = mysqli_fetch_array($q))
	{
		if(in_array($r[8],$mypost))	
		{
			$n++;
			$sm = true;	
			if($n < $pag)
			{
				continue;	
			}
			else
			{
				$sm = false;	
			}	
			echo  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);					
			if($n == (20 + $pag))
			{
				$sm = true;
				break;	
			}
		}		
	}
$total = 20 + $pag + 1;
$con->close_db_con($conc);
echo $sm?"<div id='show_more' align='center' onclick='_more_reposts(event,$total)'>Show more total[$total], numrow[$num], n[$n] , page[$pag]</div>":"";
?>