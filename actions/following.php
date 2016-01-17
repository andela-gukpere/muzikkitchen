<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = intval($_SESSION["uid"]);
$owner = intval($_POST["owner"]) != 0?intval($_POST["owner"]):$uid;
$con = new db();$conc = $con->c();
$n = 0;
$pag = intval($_POST["page"]);
$pp = ($pag > 0)?$pag - 1:0;
$q = mysqli_query($conc,"SELECT `follow`.`id`,`follow`.`u1`,`follow`.`u2`,`users`.`user`,`users`.`name`,`users`.`bio`,`users`.`img1` FROM `follow` INNER JOIN `users` ON (`follow`.`u2` = `users`.`id`) WHERE `follow`.`u1` = $owner ORDER BY follow.id DESC  LIMIT $pp,21");
$num = mysqli_num_rows($q);
if($num < 21)
	{
		$sm = false;	
	}
	else
	{
		$sm = true;	
	}
while($r = mysqli_fetch_array($q))
{
	$n++;
	$del = "";
	$bb = PTH;
	$url = PTH."/";
	if($_SESSION["mobile"] == 2)
			{
				//$bb = "..";
					//$url = "./?i=";
			}
	$del = isFollowing($conc,$uid,$r[2])?"<img height='32' width='32' src='$bb/img/spacer.gif'  onclick='ff(event,$r[2]);' title='undine with $r[3]' class='unff' />":"<img height='32' width='32' src='$bb/img/spacer.gif'  onclick='ff(event,$r[2]);' title='dine with $r[3]' class='ff' />";
	
	$del = $uid == $r[2] || $_SESSION["uid"] == 0?"":$del;
	echo "<table class='post'><tr><td width='90%'><a href='$url$r[3]' onclick='return _pop(event,$r[2])'><div><table><tr><td><div class='smpdiv' style='background:url($bb$r[6]) no-repeat center;'></div></td><td valign='top'>$r[3]<br/><b>$r[4]</b><br/>$r[5]</td></tr></table></div></a></td><td>$del</td></tr></table>";

}
echo $n == 0?"<div class='m_s_g'>You have no friends.</a>":"";
$type = "following.php";
$total = 20 + $pag + 1;
if($sm){echo "<div id='show_more' align='center' onclick='_vmore(event,\"$type\",$total)' title='show more'></div>";}//total[$total], numrow[$num], n[$n] , page[$pag]
$con->close_db_con($conc);
?>