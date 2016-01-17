<?php
session_start();
include("../scripts/db.php");
$uid = $_SESSION["uid"];
if(!isset($_SESSION["user"],$_SESSION["p"]) || $uid == 0)
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}


$loc = $_POST["loc"];
$post = $_POST["post"];
$real_post = $post;
$post = _hstr_($post,false);
$client = strclean($_POST["client"]);
$id = intval($_POST["rid"]);
$type = intval($_POST["type"]);
function _Trend($str,$con)
{
	global $uid;
	$pos= stripos($str,"#");
	if( $pos !== false)
	{
		$preg = preg_split("/ /",$str,-1);
		foreach($preg as $s)
		{
			if(stristr($s,"#"))
			{
				$q  = mysqli_query($con,"SELECT id FROM trend WHERE trend LIKE '$s'");
				if(mysqli_num_rows($q) == 0)
				$qq = mysqli_query($con,"INSERT INTO trend Values (NULL, $uid,'$s',1,".date("U").")");
				else
				$qq = mysqli_query($con,"UPDate trend set tc=tc+1 WHERE trend LIKE '$s'");
			}
		}
	}
}

if(strlen($post) > 0)
{	
	$con = new db();$conc = $con->c();
	$q = $con->insertInto("post",array($uid,$post,date("U"),$client,$loc,$id,$type,$_SERVER['REMOTE_ADDR']));
	if($q)
	{
		switch ($type)
		{
			case 0:
			$v = _hstr_($real_post,1);
			$v = NULL;
			break;
			case 1:
			$q = mysqli_query($conc,"SELECT user FROM post WHERE id = $id");
			$r = mysqli_fetch_array($q);
			if($r[0] != $uid)
			{
				$q = $con->insertInto("hist",array(8,$r[0],$uid,$id,date("U")));
				s_mail($_SESSION["user"]," replied your <a href='http://muzikkitchen.com/?view=$id&t=$type'>feed</a><br/><div style='font-size:14px'><b><br/><br/>$real_post</b></div>",$r[0],$conc,"replied your feed");
				$r = NULL;
			}
			$q = NULL;
			break;
			case 2:
			$q = mysqli_query($conc,"SELECT user FROM post WHERE id = $id");
			$r = mysqli_fetch_array($q);
			if($r[0] != $uid)
			{
				$q = $con->insertInto("hist",array(9,$r[0],$uid,$id,date("U")));
				s_mail($_SESSION["user"]," refed your <a href='http://muzikkitchen.com/?view=$id&t=$type'>feed</a><br/><div style='font-size:14px'><b><br/><br/>$real_post</b></div>",$r[0],$conc,"refed your feed");
				
				$r = NULL;
			}
			$q = NULL;
			break;
			default:
			//go HArd or go HOme
			break;
		}
		echo 1;			
	}
	else
	{
		echo 2;	
	}
	_Trend($real_post,$conc);
}
else
{
	echo 2;	
	exit();
}
$con->close_db_con($conc);
$con = NULL;
?>