<?php
session_start();
include("../../scripts/db.php");
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = intval($_SESSION["uid"]);
$owner = intval($_POST["owner"])!=0?intval($_POST["owner"]):$uid;

	$page = isset($_POST["page"])?intval($_POST["page"]):0;
			$pp = ($page > 0)?$page - 1:0;
$type = intval($_POST["type"]);
$following = array();
$like = array();
$mypost= array();
$con = new db();$conc = $con->c();
	$time = intval($_POST["time"]);
 if($type==1 && isset($time))
	{
		$type = 1;	
		$q = mysqli_query($conc,"SELECT u2 FROM follow WHERE u1 = $uid");	
		array_push($following,$uid);
		while($r = mysqli_fetch_array($q))
		{
			array_push($following,$r[0]);
		}
		$r = NULL;
		$q = NULL;

		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`date` > '$time' ORDER BY `post`.`id` DESC");
	}
if($type == 2)
{	
	$type = 2;
		$q = mysqli_query($conc,"SELECT u2 FROM follow WHERE u1 = $uid");
		array_push($following,$uid);
		while($r = mysqli_fetch_array($q))
		{
				array_push($following,$r[0]);
		}
		$r = NULL;
		$q = NULL;

		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) ORDER BY `post`.`id` DESC");
}
if($type == 3)
	{
		$type = 3;	
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name` ,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`user` = $owner ORDER BY `post`.`id` DESC LIMIT $pp,16");
	}
if ($type == 4)
	{
		$type = 4;
		$search = user($conc,'`user`',$owner);
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) AND (`post`.`post` LIKE '%@$search[0] %') ORDER BY `post`.`id` DESC LIMIT $pp, 16");
	}
	if($type == 5)
	{
		$type = 5;
		$q = mysqli_query($conc,"SELECT `id` FROM `like` WHERE `uid` = $owner");	
		while($r = mysqli_fetch_array($q))
		{
			array_push($like,$r[0]);	
		}
		$q = NULL;
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) ORDER BY `post`.`id` DESC");
	}
if($type == 6)
{
	$type = 6;
	$q = mysqli_query($conc,"SELECT `id` FROM post WHERE user = $owner");
	while($r = mysqli_fetch_array($q))
	{
		array_push($mypost,$r[0]);	
	}
	$q = NULL;$r = NULL;
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`type` = 2 ORDER BY `post`.`id` DESC");	
}

	$n = 0;
	if(!$q){	$con->close_db_con($conc);
	exit();}
	$num = mysqli_num_rows($q);
	$date = false;
		echo '<div style="background-color:#fff">';
		$p=0;
while($r = mysqli_fetch_array($q))
{
	$n++;
	if(!$date)
	{
		$date = $r[3];	
	}
	if($type == 2 )
	{
		
		if(!in_array($r[1],$following) )
		{
			continue;	
		}
		
	}
	if($type == 5)
	{
		
		if(!in_array($r[0],$like))
		{
			continue;	
		}
	}
	
	if($type == 6)
	{
		if(!in_array($r[8],$mypost))
		{
			continue;	
		}
	}
	
		$sm = true;	
		if($type == 2 || $type == 5 || $type == 6)
		{
			if($n < $page)
			{
				continue;	
			}
			else
			{
				$sm = false;	
			}
		}
	if($type == 3 || $type == 4)
	{
		if($num < 15)
		{
			$sm = false;	
		}
	}
				$text =  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);	
				$p++;
				echo $type==1?"<div class='new_1'>":"";				
				echo $text;
				echo $type==1?"</div>":"";		
		if(($n == (15 + $page)) && ($type == 2 || $type == 5 ||  $type == 6))
				{
					$sm = true;
					break;	
				}
				if($p == 15)
				{
					$sm = true;
					break;	
				}
}
echo $type == 1 && $date?"<hr/>":"";
$date = $date?$date:$time;
echo "<input type='hidden' value='$date' id='last_time' />";
$total = 15 + $page + 1;
	echo ($type!=1) && $sm?"<div id='show_more' align='center' onclick='_more(event,$type,$total)'></div>":"";	
	$con->close_db_con($conc);echo "</div>";
?>