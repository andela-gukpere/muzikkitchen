<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}    
$uid = intval($_SESSION["uid"]);
if($uid != 0 && isset($uid))
{	

	$n = 0;
	$con = new db();$conc = $con->c();
	$ff = array();
	$q = mysqli_query($conc,"SELECT u2 FROM follow WHERE u1 = $uid");
	while($r = mysqli_fetch_array($q))
	{
		array_push($ff,$r[0]);		
	}
	$q = mysqli_query($conc,"SELECT bday,id,user FROM users");
	while($r = mysqli_fetch_array($q))
	{
		list($m,$d,$y) = explode("/",$r[0]);
		if(date("n") == intval($m) && date("j") == intval($d))
		{
			if(in_array($r[1],$ff))
			{
				$n++;
			}
		}
	}
	$q = NULL;
	$r = NULL;
	$q = mysqli_query($conc,"SELECT date FROM online WHERE uid = $uid");
	$r = mysqli_fetch_array($q);
	$t = intval($r[0]) - 60 * 20;
	$q = mysqli_query($conc,"SELECT type,var1,var2,var3 FROM hist WHERE date > $t");
	
	while($r = mysqli_fetch_array($q))
	{
		if($r[1] == $uid || in_array($r[2],$ff))
		{
			//	if( $n < $page)
			//	{
			//		continue;
			//	}	
			//	else
			//	{
			//		$sm = false;	
			//	}
				$type = $r[0];
				$var3 = $r[3];
				$user = $r[4];
				switch ($type)
				{
					case 1:
					if($uid == $r[1])
						{
							$n++;						
						}
					break;
					case 2:
					if($uid == $r[1])
						{
							$n++;
					
						}
					break;
					case 3:
						if($uid == $r[1])
						{
							$n++;
							
						}
					break;
					case 4:
					//art	
					$n++;	
						
					break;
					case 5:
					//music
					$n++;
					
					break;
					case 6:
					//video
					$n++;
					
					break;
					case 7:
					if($uid == $r[1] && $uid != $r[2])
						{
							$n++;
						}	
					break;
					case 8:
					if($uid == $r[1] && $uid != $r[2])
						{
							$n++;
					
						}
					
					break;
					case 9:
						if($uid == $r[1] && $uid != $r[2])
						{
							$n++;					
						}					
					break;
					case 10:
						if($uid == $r[1])
						{
							$n++;
							
						}
					break;
					case 11:
						if($uid == $r[1])
						{
							$n++;
							
						}
					break;
					case 12:
						if($uid == $r[1])
						{
							$n++;
							
						}
					break;
					default:
						//*yimu*//
						
					break;			
				}			
		}
		else continue;
	}
	$n = $n > 0 ?$n:"";
	echo $n;	
	$_SESSION["plate_num"] = $n;
	$r = NULL;
	$q = NULL; 
	$con->close_db_con($conc);
	exit();
}
?>