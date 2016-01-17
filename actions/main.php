<?php
session_start();

$dbfile  = "./scripts/db.php";
if(file_exists($dbfile))require_once($dbfile);
else require_once(".".$dbfile);
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$uid = intval($_SESSION["uid"]);
	$query = $_POST["all"];
	$time = intval($_POST["time"]);
	$owner = intval($_POST["owner"]);
	$following = array();
	$like = array();
	$con = new db();$conc = $con->c();
	$pag = isset($_POST["page"])?intval($_POST["page"]):0;
	$n = 0;
//	$q = NULL;
	if($fid){$owner = $fid;}
		$following = array();
		$pp = ($pag > 0)?$pag - 1:0;
//	echo $_POST["code"];

	 if($_POST["code"] == "upd" && isset($time))
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
	 if($_GET["code"] == 2)
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
	else if($_GET["code"] == 3 || $fid)
	{
		$type = 3;	
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name` ,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`user` = $owner ORDER BY `post`.`id` DESC LIMIT $pp,21");
	}

	 if ($_GET["code"] == 4)
	{
		$type = 4;
		$owner = intval($_POST["owner"]) == 0?$uid:intval($_POST["owner"]);
		$search = $owner;
		if(is_int($owner))
		{
			$r = user($conc,"`user`",$owner);
			$search = $r[0]	;
			$r = NULL;
		}
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) AND (`post`.`post` LIKE '%@$search %') ORDER BY `post`.`id` DESC LIMIT $pp, 21");
	}
	if($_GET["code"] == 5)
	{
		$type = 5;
		$owner = intval($owner);
		$q = mysqli_query($conc,"SELECT `id` FROM `like` WHERE `uid` = $owner");	
		while($r = mysqli_fetch_array($q))
		{
			array_push($like,$r[0]);	
		}
		$q = NULL;
		$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) ORDER BY `post`.`id` DESC");
	}
			echo "<div>";
	$date = false;
	$num = mysqli_num_rows($q);
	while($r = mysqli_fetch_array($q))
		{			
			if(in_array($r[1],$following) || in_array($r[0],$like) || $type== 3 || $type == 4)
			{
				$n++;
				$var ="";
				$sm = true;	
				if($type == 2 || $type == 5)
				{
					if($n < $pag)
					{
						continue;	
					}
					else
					{
						$sm = false;	
					}
				}
				if(!$date)
				{
					$date = $r[3];	
				}
				if($type == 3 || $type == 4)
				{
					if($num < 20)
					{
						$sm = false;	
					}

				}
				$text =  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);	
				echo $type==1?"<div class='new_1'>":"";				
				echo $text;
				echo $type==1?"</div><br/>":"";
				if(($n == (20 + $pag)) && ($type == 2 || $type == 3 || $type == 4))
				{
					$sm = true;
					break;	
				}
			}
		}
		echo $n == 0 && $type != 1?"<div class='m_s_g'>You have no feeds.</a>":"";
//		echo $type == 1 && $date?"<hr/>":"";
		$date = $date?$date:$time;
		
			echo "<input type='hidden' value='$date' id='last_time' />";
		$total = 20 + $pag + 1;
	echo ($type!=1) && $sm?"<div id='show_more' align='center' onclick='_more(event,$type,$total)' title='show more'></div>":"";	
	//total[$total], numrow[$num], n[$n] , page[$pag] type[$type]
	echo "</div>";	
	if(!$fid)$con->close_db_con($conc);
?>
