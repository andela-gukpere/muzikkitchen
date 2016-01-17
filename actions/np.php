<?php

session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];
$con = new db();$conc = $con->c();
$type = $_POST["type"];
$id = $_POST["id"];
$owner = $_POST["owner"];
if(isset($id,$type))
{	
	if($type!=0)$q = mysqli_query($conc,"UPDATE users SET np = '$id"."__"."$type', npdate=".date("U")." WHERE id = $uid;");
	@$con->close_db_con($conc);
	@$con->insertInto("num_plays",array($id,$type,$uid,date("U")));
//	if($type == 1)					$con->update("music","play = play + 1","id = $id");
//	if($type == 2)					$con->update("videos","play = play + 1","id = $id");
//	if($type == 0)					$con->update("art","play = play + 1","id = $id");
	exit();
}
else if(isset($owner))
{
	$q = mysqli_query($conc,"SELECT np,npdate FROM users WHERE id = $owner ");
	$r = mysqli_fetch_array($q);
	$q = NULL;
	if($r[0] == "")
	{
		exit();
	}	
	list($id,$type) = explode("__",$r[0]);
	if($type == 1)
	{
					$q = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id= music.user WHERE music.id = $id");
					$rr = mysqli_fetch_array($q);
					
						$res = "<a href='#!/music=$rr[0]' name='modal'><span class='muzik_item' title='$rr[3]' mid='$rr[0]' onclick='playmusic(event)' mname='$rr[2]' info='$rr[3]' music='$rr[4]' mdate='".gtime($rr[6])."' uid='$rr[1]' owner='$rr[7]'>$rr[2]</span></a>";	
					
	}
	else
	{
			$q = mysqli_query($conc,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.id = '$id' ");
					$rrr = mysqli_fetch_array($q);
					
						$res =  "<a href='#!/video=$rrr[0]' name='modal'><span class='vid_item' title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]' info='$rrr[3]' vidname='$rrr[2]' vid='$rrr[0]' vdate='".gtime($rrr[7])."' uid='$rrr[1]' owner='$rrr[8]'>$rrr[2]</span></a>";	
					
	}
	$is_now =  date ("U") - $r[1] > 60 * 60 * 3?"Last played: ":"Now playing: "; 
	echo $is_now.$res;
}
$con->close_db_con($conc);
?>