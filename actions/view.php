<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$owner = $_POST["owner"];
$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `id` FROM `users` WHERE user = '$owner' or id = '$owner'");
	$r = mysqli_fetch_array($q);
	if(mysqli_num_rows($q) != 1)
	{
			exit("<div class='m_s_g'>Invalid User<div>");
	}
	$uuid = $r[0];
$me = $_SESSION["user"];
$type = intval($_GET["type"]);
//echo($type." < = =type || user= =>".$uuid);
function getArt($uid)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `art`.`id`,`art`.`user`,`art`.`name`,`art`.`info`,`art`.`img1`,`art`.`img2`,`art`.`img3`,`art`.`date`,`users`.`user` FROM `art` INNER JOIN `users` ON `users`.`id` = `art`.`user` WHERE `art`.`user` = $uid");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	 echo "<table><tr>";
	 $n = 0;
	while($r = mysqli_fetch_array($q))
	{
			$n++;
			echo "<td><a href='./picture-$r[0]' onclick='return setURI(\"picture\",$r[0])' ><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;'  class='mpdiv' ><div style='background:url(".PTH."$r[5]) no-repeat center;' class='mpdiv' title='$r[3]' onmouseover='anim(event)' onmouseout='anim2(event)' onclick='playart(event)' aid='$r[0]'  owner='$r[8]' uid='$uid' art='.$r[6]' aname='$r[2]' adate='".gtime($r[7])."'></div></div></a></td>";
		echo $n % 6 == 0 ?"</tr><tr>":"";
           
	}
	echo"  </tr></table>";
	$con->close_db_con($conc);
	exit();
}

function getMusic($uid)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id= music.user WHERE music.user = $uid");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	$n = 0;
	echo "<table cellpadding='5'><tr>";
	while($r = mysqli_fetch_array($q))
	{
		$n++;
		echo "<td valign='middle'><a href='./music-$r[0]' onclick='return setURI(\"music\",$r[0])' ><div class='music_m' align='center' mid='$r[0]' title='$r[3]'  owner='$r[7]' uid='$uid' onclick='playmusic(event)' mname='$r[2]' info='$r[3]' music='$r[4]' mdate='".gtime($r[6])."'>$r[2]</div></a></td>";
		echo $n % 4 == 0 ?"</tr><tr>":"";		
	}
	echo "</tr></table>";
	$con->close_db_con($conc);
	exit();
}
function getVid($uid)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.user = $uid ");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	$n= 0;
	echo"<table><tr>";
	while($r = mysqli_fetch_array($q))
	{
		$n++;
		echo "<td ><a href='./video-$r[0]' onclick='return setURI(\"video\",$r[0])' ><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;height:120px;width:120px;padding:10px;'><div style='background:url(".PTH."/prev/$r[4]) left;' class='vid_prev' title='$r[3]' onclick='playvideo(event)' prev='$r[4]' vid='$r[0]' video='$r[5]' info='$r[3]' owner='$r[8]' uid='$uid' vidname='$r[2]' vdate='".gtime($r[7])."'>$r[2]<br/>$r[3]</div></div></a><br/></td>";	
		echo $n % 4 == 0 ?"</tr><tr>":"";	
	}
	
	echo "</tr></table>";
	$con->close_db_con($conc);
	exit();
}
switch ($type)
{
	case 0:	
	getArt($uuid);
	break;
	case 1:
	getMusic($uuid);
	break;
	case 2:
	getVid($uuid);	
	break;
	default:
	$con->close_db_con($conc);
		exit("<div class='m_s_g'>Invalid argument</div>");
	break;
}
$con->close_db_con($conc);
?>