<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = $_SESSION["uid"];
$nm = $_POST["nm"];
$string = strclean($_POST["s"]);
$string = str_replace("_","",$string);
list($s1,$s2) = explode(" ",$string,2);
if($s2 == "" || !$s2)
{
    $s2 = $s1;
}
if( isset($string))
{
    $con = new db();$conc = $con->c();
    $users = mysqli_query($conc,"SELECT `id`,`user`,`name` FROM `users` WHERE `name` LIKE '%$string%' OR `user` LIKE '%$string%' OR `email` LIKE '$string' OR `name` LIKE '$s1' OR `name` LIKE '%$s1%' OR `user` LIKE '%$s2%' OR `user` LIKE '%$s1%' OR `name` LIKE '%$s2%' ORDER BY `user` ASC LIMIT 0 , 10");
	$n = 0;
	$result = "<input type='hidden' id='_hedin' value='' />";
	
	while($q = mysqli_fetch_array($users))
	{
		$pals = mysqli_query($conc,"SELECT `u1` FROM `follow` WHERE (`u1` ='$q[0]' AND `u2` ='$uid')");
		$bool = false;
		if($nm == 1)
		{
			$bool = ($q[0] == $user);
		}
		if(mysqli_num_rows($pals) == 1 || $bool)
		{
			$n++;
			$name = "$q[1] [$q[2]]";
			$fn = $name;
			$name = str_replace($s1,"<_>$s1</_>",$name);
			$name = str_replace($s2,"<_>$s2</_>",$name);
			
			$name = str_replace(ucfirst($s1),"<_>".ucfirst($s1)."</_>",$name);
			$name = str_replace(ucfirst($s2),"<_>".ucfirst($s2)."</_>",$name);
			
			$name = str_replace(strtolower($s1),"<_>".strtolower($s1)."</_>",$name);
			$name = str_replace(strtolower($s2),"<_>".strtolower($s2)."</_>",$name);
			
			$result .="<div class='_pl' onclick='_set_(event)' title='$fn'>$name</div><input type='hidden' value='$q[0]' />";
		}
	}
	mysqli_kill($conc,mysqli_thread_id($con->c()));
	mysqli_close($con->c());
	if($n == 0)
	{
		echo ("No match Found");	
	}
	$result = str_replace("<_>","<b>",$result);
	$result = str_replace("</_>","</b>",$result);
	echo $result;
	exit();
}
?>