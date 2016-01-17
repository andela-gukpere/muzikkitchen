<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$type = intval($_POST["type"]);
$id = $_POST["id"];
function getArt($id)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT  `art`.`id`,`art`.`user`,`art`.`name`,`art`.`info`,`art`.`img1`,`art`.`img2`,`art`.`img3`,`art`.`date`,`users`.`user` FROM `art` INNER JOIN `users` ON `users`.`id` = `art`.`user` WHERE `art`.`id` = $id");
	if(mysqli_num_rows($q) == 0)
	{
		//echo "<div class='m_s_g'>Sorry, this picture cannot be found.</div>";	
		echo "({status:false,msg:'Sorry, this picture cannot be found'})";
	}
	else
	{
		$r = mysqli_fetch_array($q);
	//	echo "<a href='#!/picture=$r[0]' name='modal'><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;'  class='mpdiv' ><div style='background:url(".PTH."$r[5]);' class='mpdiv' title='$r[3]' onmouseover='anim(event)' onmouseout='anim2(event)' onclick='playart(event);$(\"#pwindow\").fadeOut(500);' uid='$r[1]' owner='$r[8]' aid='$r[0]' art='.$r[6]' aname='$r[2]' adate='".gtime($r[7])."'></div></div></a>";
	
echo "({status:true,type:1,class:'mpdiv',title:'$r[3]',uid:'$r[1]',owner:'$r[8]',aid:'$r[0]',art:'".PTH."$r[6]',aname:'$r[2]',adate:'".gtime($r[7])."'})";
	}
	$con->close_db_con($conc);
	exit();
}

function getMusic($id)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id= music.user WHERE music.id = $id");
	if(mysqli_num_rows($q) == 0)
	{
		echo "({status:false,msg:'Sorry, this song cannot be found'})";
	//	echo "<div class='m_s_g'>Sorry, this song cannot be found.</div>";	
	}
	else
	{
		$r = mysqli_fetch_array($q);
		echo ("({status:true,type:2,class:'music_m',title:'".xtra_space($r[3])."',uid:'$r[1]',owner:'$r[7]',mid:'$r[0]',music:'$r[4]',mname:'$r[2]',mdate:'".gtime($r[6])."'});");
		//echo "<a href='#!/music=$r[0]'><div align='center' class='music_m' mid='$r[0]' title='$r[3]' onclick='playmusic(event);$(\"#pwindow\").fadeOut(500);' mname='$r[2]' info='$r[3]' music='$r[4]' mdate='".gtime($r[6])."' owner='$r[7]' uid='$r[1]'>$r[2]<div></a>";	
		
	}
	$con->close_db_con($conc);
	exit();
}
function getVid($id)
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.id = $id ");
	if(mysqli_num_rows($q) == 0)
	{
		echo "({status:false,msg:'Sorry, this video cannot be found'})";
		//echo "<div class='m_s_g'>Sorry, this video cannot be found.</div>";	
	}
	else
	{
		$n= 0;
		$r = mysqli_fetch_array($q);
		echo "({status:true,type:3,class:'vid_prev',title:'$r[3]',uid:'$r[1]',owner:'$r[8]',vid:'$r[0]',video:'$r[5]',prev:'$r[4]',vname:'$r[2]',vdate:'".gtime($r[7])."'})";
		//echo"<table><tr>";
		
		//echo "<a href='#!/video=$r[0]'><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;' ><div vid='$r[0]' style='background:url(".PTH."/prev/$r[4]) no-repeat center;' class='vid_prev' title='$r[3]' onclick='playvideo(event);$(\"#pwindow\").fadeOut(500);' prev='$r[4]' video='$r[5]' info='$r[3]' vidname='$r[2]' vdate='".gtime($r[7])."' owner='$r[8]' uid='$r[1]'>$r[2]<br/>$r[3]</div></div></a>";	
	}
	$con->close_db_con($conc);
	exit();
}
switch ($type)
{
	case 0:	
	getArt($id);
	break;
	case 1:
	getMusic($id);
	break;
	case 2:
	getVid($id);	
	break;
	default:
	exit("({status:false,msg:'Invalid arguments'})");
	break;
}
?>