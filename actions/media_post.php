<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];


function getArt($con,$uid)
{	
	$q = mysqli_query($con,"SELECT * FROM `art` WHERE user = $uid");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	echo "<Table><tr>";
	$n = 0;
	while($r = mysqli_fetch_array($q))
	{
		$n++;
		echo "<td><a href='#' class='media_p'><div  type='art' tid='$r[0]' onclick='media_post(event,2)' style='background:url(".PTH."$r[4]);height:30px;width:30px;' owner = '' title='$r[3]'></div></a></td>";     
		echo $n % 5 == 0?"</tr><tr>":"";
	}
		echo "</tr></Table>";
}
function getMusic($con,$uid)
{
	$q = mysqli_query($con,"SELECT * FROM `music` WHERE user = $uid");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	while($r = mysqli_fetch_array($q))
	{
			echo "<a href='#' class='media_p' type='music' onclick='media_post(event,1)' title='$r[3]' tid='$r[0]'>$r[2]</a><br/>";	
	}	
}
function getVid($con,$uid)
{
	$q = mysqli_query($con,"SELECT * FROM `videos`WHERE user = $uid ");
	if(mysqli_num_rows($q) == 0)
	{
		echo "<div class='m_s_g'>No content has been added yet</div>";	
	}
	while($r = mysqli_fetch_array($q))
	{
		echo "<a href='#' class='media_p' type='video' onclick='media_post(event,1)' title='$r[3]' tid='$r[0]'>$r[2]</a><br/>";			
	}
}
$con = new db();$conc = $con->c();
echo "<div style='height:200px;overflow-y:scroll;'><B>Your Art</b><hr/>";getArt($conc,$uid);
echo "<b>Your Music</b><hr/>";getMusic($conc,$uid);
echo "<b>Your Videos</b><hr/>";getVid($conc,$uid);
echo "</div>";
$con->close_db_con($conc);
?>