<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = intval($_SESSION["uid"]);
if($uid != 0) 
{
    $con = new db();$conc = $con->c();
	mysqli_query($conc,"UPDATE `online` SET `date` = ".date("U")." WHERE `uid` = $uid");
	$tm = date("U") - 60 * 10;
    $all = mysqli_query($conc,"SELECT `uid`,`date` FROM `online` WHERE `date` > $tm  AND uid <> $uid ORDER BY `date` DESC");
	//echo mysqli_num_rows($all);
    $numr = 0;
	$result = '<div class="p_onl">';
    while($res = mysqli_fetch_array($all))
    {
		$t_diff = date("U") - $res[1];
		$status = ($t_diff > 60 * 3)?"<img src='./img/mg/of.png'/>":"<img src='./img/mg/on.png'/>";
		$query = mysqli_query($conc,"SELECT `chat`.`id`,`chat`.`u1`,`chat`.`u2`,`users`.`id`,`users`.`user`,`users`.`img1` FROM `chat` INNER JOIN `users` ON (`users`.`id` = `chat`.`u1` OR `users`.`id` = `chat`.`u2`) WHERE (`chat`.`u1` = $uid AND `chat`.`u2` = $res[0]) OR (`chat`.`u1` = $res[0] AND `chat`.`u2` = $uid)");
		if($query)
		{			
			
			while($rez = mysqli_fetch_array($query))
			{
				if($rez[3] != $uid)
				{	$em = $rez[3];
					$numr++;
					$u = array($rez[4],$rez[5]);
					$title ="$u[0]";
					$result .= "<a href='#' onclick='chatwith($em,".$rez[0].",true)'><table class='onl'><tr><td><div style='background:url(".PTH."$u[1]) no-repeat center;width:20px;height:20px;' class='ssmpdiv' title='$title'></div></td><td>$title</td><td>$status</td></tr></table></a>";
					break;
				}
			}
		}
    }
	$result .= "</div>";
    mysqli_kill($conc,mysqli_thread_id($con->c()));
	mysqli_close($con->c());
}
echo ($numr."___".$result);
$all = NULL;
$query = NULL;
$rez = NULL;
exit();
?>