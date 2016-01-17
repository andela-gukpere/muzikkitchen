<?php
include("../scripts/db.php");
$con = new db();
$conc = $con->c();
header("Content-Type: text/xml");
$user = md5($_POST["user"]);
echo ("<?xml version='1.0' encoding='utf-8' ?><bubble uid='$user'>");
$action = $_POST["action"];
$p = sha1($_POST["p"]);
$id = $_POST["id"];
$time = $_POST["time"];

$msg =  _hstr_(strclean($_POST["msg"]),false);		
switch($action)
{
	case 1:

		$q = mysqli_query($conc,"SELECT * FROM `users` WHERE `em` = '$user' AND `pass` = '$p' ");
		$r = mysqli_fetch_assoc($q);
		if(mysqli_num_rows($q) == 1)
		{
			echo "<name>".$r["fname"]." ".$r["lname"]."</name>";
			echo "<img>".str_replace("../","http://localhost/bubble/",$r["img_m"])."</img>";
		}
		else
		{
			echo "<error>Invalid Credentials</error>";
		}		
	break;
	case 2:
		$q = mysqli_query($conc,"SELECT `email`,`femail`,`id` FROM `pals` WHERE `email` = '$user' OR `femail` = '$user' ");
		$q2 = mysqli_query($conc,"UPDATE `chat_online` SET `time` = ".date("U")." WHERE `email` = '$user'");
		while($r = mysqli_fetch_array($q))
		{
			$em = $r[0] == $user?$r[1]:$r[0];
			$tm = date("U") - 60 * 10;
			$q2 = mysqli_query($conc,"SELECT `email` FROM `chat_online` WHERE `email` = '$em' AND `time` > $tm");
			while($r2 = mysqli_fetch_array($q2))
			{
				$u = users($conc,"`fname`,`lname`,`img_m`",$em);
				echo "<user uid='$em' id='$r[2]'><name>$u[0] $u[1]</name><img>".str_replace("../","http://localhost/bubble/",$u[2])."</img></user>";
			}
		}
	break;
	case 3:
		getChatMsg($id,$user,$msg,$con->c());
	break;
	case 4:
		
	break;
	default:
		echo "<error>params errors</error>";;	
	break;	
}

echo "</bubble>";
$con->close_db_con($conc);
function getChatMsg($id,$user,$msg,$con)
{		
		$msg_len = strlen($msg);
		$file = "../chatt/rooms/$id.dat";
		if($msg_len > 0)
		{
			$u = users($con,"`fname`",$user);
			$out_name = "$u[0]";
			$time  = intval($_POST["time"]) / 1000;
			$h = date("h");
			$m = date("m");
			$time = date("h<b>:</b>m a");//"$h<b>:</b>$m";
			$fullmsg = "\n<tr><td><b>$out_name</b>: <span>$msg</span> <span class='tt'>$time</span></tr></td>";
			if(is_file($file)){	$cfile = fopen($file,"a");}else{$cfile = fopen($file,"w");}
			fwrite($cfile,$fullmsg);
			fclose($cfile);
		}
		
		if(is_file($file))
		{
			$cfile = fopen($file,"r");
			while($cont = fread($cfile,1024))
			{
				$result .=  $cont;	
			}	
			fclose($cfile);
			$result = str_replace("<tr>","",$result);
			$result = str_replace("<td>","",$result);
			$result = str_replace("</td>","",$result);
			$result = str_replace("</tr>","",$result);
			$result = str_replace("</b>","",$result);	
			$result = str_replace("<b>","",$result);
			$result = str_replace("&","&amp;",$result);
			$result = str_replace("</span>","",$result);
			$result = str_replace("<span>","",$result);
			$result = str_replace("<span class='tt'>","",$result);
			$result = html_entity_decode($result);
			echo "<msg>$result</msg>";
		}
		else
		{
			echo "<msg>No chat History $id</msg>";	
		}
}
?>