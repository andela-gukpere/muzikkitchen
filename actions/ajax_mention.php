<?php
session_start();

include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];
$arg = $_POST["s"];

list($s1,$s2) = explode(" ",$arg,2);
if(isset($arg))
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `follow`.`u2`,`users`.`id`,`users`.`user`,`users`.`name`,`users`.`img1` FROM follow INNER JOIN users ON `follow`.`u2` = `users`.`id` WHERE `follow`.`u1` = $uid AND `users`.`id` <> $uid AND (`users`.`user` LIKE '%$arg%' or `users`.`name` LIKE '%$s1%' OR `users`.`name` LIKE '%s2%' OR `users`.`user` LIKE '%$arg%')  LIMIT 0,10");
	while($r = mysqli_fetch_array($q))
	{
			$name = "$r[2] [$r[3]]";
				
			//	$name = str_replace($s1,"<_>".$s1."</_>",$name);
			//	$name = str_replace($s2,"<_>".$s2."</_>",$name);
				
			//	$name = str_replace(ucfirst($s1),"<_>".ucfirst($s1)."</_>",$name);
		//		$name = str_replace(ucfirst($s2),"<_>".ucfirst($s2)."</_>",$name);
				
		//		$name = str_replace(strtoupper($s1),"<_>".strtoupper($s1)."</_>",$name);
		//		$name = str_replace(strtoupper($s2),"<_>".strtoupper($s2)."</_>",$name);
				
		$result .= "<a href='".PTH."/$r[0]' class='_pl2' onclick='return _ment_(event,\"$r[2]\",\"$arg\")'>$name</a><br/><br/>";		
	}	
	//$result = str_replace("<_>","<b class='j'>",$result);
	//$result = str_replace("</_>","</b>",$result);
	echo $result;
	$con->close_db_con($conc);
}
?>