<?php
session_start();
include("../scripts/db.php");
$uid = intval($_SESSION["uid"]);
if(!isset($_SESSION["user"],$_SESSION["p"]) || $uid == 0)
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$ff = array();
$page = intval($_POST["page"]);

$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT u2 FROM follow WHERE u1 = $uid");
while($r = mysqli_fetch_array($q))
{
	array_push($ff,$r[0]);	
}
$q = NULL;
$r = NULL;
//1 - var2 dining with var1
//2 - var2 dining back with var1
//3 - var2 undined with var1 ^_^  #boringFucker
//4 - var2 uploaded art
//5 - var2 uploaded music
//6 - var2 uploaded video
//7 - var2 likes var1's feed
//8 - var2 replied var1's feed
//9 - var2 refed var's feed
//10 - var2 comment var1's foto
//11 - var2 comment var1's music
//12 - var2 comment var1's vid
//inner joining var2 with users.id 2 save memory
//Ye$$ bo$$ :D
//heavy || light :: HEAVY==true
//prepared for the worst but still praying for the best;
//this script is a bitch i got code up her dress |>_<|;
//mySQL gon sleep, so PHP can rest;
//and http:\\muzikkitchen.com is my fucking addresss...(John);
$n = 0;
$bb =PTH;
if($_SESSION["mobile"] == 2)
{
//	$bb = "..";	
}
$res = "<div style='font-size:12px;'>";
if($page == 0)
{
	$q = mysqli_query($conc,"SELECT bday,id,user FROM users");
	while($r = mysqli_fetch_array($q))
	{
		list($m,$d,$y) = explode("/",$r[0]);
		if(date("n") == intval($m) && date("j") == intval($d))
		{
			if(in_array($r[1],$ff))
			{
			
			$res .= "<div><table  cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/bday.png' /></td><td><a href='".PTH."/$r[2]' onClick='return _pop(event,$r[1]);'>$r[2]</a>'s birthday is today</td><td class='del'>".date("jS F")."</td></tr></table></div>";
			}
		}	
	}
}
$q = NULL;
$r = NULL;
$q = mysqli_query($conc,"SELECT hist.type,hist.var1,hist.var2,hist.var3,users.user,hist.date FROM hist INNER JOIN users ON hist.var2 = users.id ORDER BY hist.date DESC");

while($r = mysqli_fetch_array($q))
{
	$sm = false;	
	if($r[1] == $uid || in_array($r[2],$ff))
	{		
		
		$type = $r[0];
		$var3 = $r[3];
		$user = $r[4];
		list($media,$id) = explode("::__::__::",$var3);
		switch ($type)
		{
			case 1:
			if($uid == $r[1])
				{
					$n++;
					if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table  cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/dine.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);' >$user</a> is dining with you</td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";	
				}
			break;
			case 2:
			if($uid == $r[1])
				{
					$n++;
					if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table  cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/dine.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);' >$user</a> is dining back with you</td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			break;
			case 3:
				if($uid == $r[1])
				{
					$n++;
					if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
					$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/dine.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> is no longer dining with you</td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			break;
			case 4:
			//art	
			$n++;	
			if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/pict.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> uploaded a new picture  <a onclick='hist_media($id,0);return setURI(\"picture\",$id)' href='".PTH."/picture-$id'>$media</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
			break;
			case 5:
			//music
			$n++;
			if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/music_.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> uploaded a new song  <a onclick='hist_media($id,1);return setURI(\"music\",$id)' href='".PTH."/music-$id'>$media</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
			break;
			case 6:
			//video
			$n++;
			if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/video_.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> uploaded a new video  <a onclick='hist_media($id,2);return setURI(\"video\",$id)' href='".PTH."/video-$id'>$media</a><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
			break;
			case 7:
			if($uid == $r[1] && $uid != $r[2])
				{
					$n++;
					if( $n < $page)
					{
						continue;
					}	
					else
					{
						$sm = false;	
					}	
			$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><div style='background-image:url(".$bb."/img/like.png);' class='like'></div></td><td><a href='".PTH."/$user'  onClick='return _pop(event,$r[2]);' >$user</a> likes your <a href='".PTH."/?view=$var3&type=0' onclick='return _op($var3,0)'>feed</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			
			break;
			case 8:
			if($uid == $r[1] && $uid != $r[2])
				{
					$n++;
					if( $n < $page)
					{
						continue;
					}	
					else
					{
						$sm = false;	
					}	
			$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/feed.png' /></td><td><a href='".PTH."/$user'  onClick='return _pop(event,$r[2]);' >$user</a> replied your <a href='".PTH."/?view=$var3&type=0' onclick='return _op($var3,0)'>feed</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			
			break;
			case 9:
			if($uid == $r[1] && $uid != $r[2])
				{
					$n++;
					if( $n < $page)
					{
						continue;
					}	
					else
					{
						$sm = false;	
					}	
			$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/feed.png' /></td><td><a href='".PTH."/$user'  onClick='return _pop(event,$r[2]);' >$user</a> refed your <a href='".PTH."/?view=$var3&type=0' onclick='return _op($var3,0)'>feed</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			
			break;
			case 10:
			//art	
				if($uid == $r[1])
				{
					$n++;	
					if( $n < $page)
					{
						continue;
					}	
					else
					{
						$sm = false;	
					}	
					$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/pict.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> commented on your <a href='#' onclick='hist_media($var3,0)'>photo</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
				}
			break;
			case 11:
			//music
			if($uid == $r[1])
			{
				$n++;
				if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}	
				$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/music_.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> commented on your <a href='#' onclick='hist_media($var3,1)'>song</a></td><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
			}
			break;
			case 12:
			//video
			if($uid == $r[1])
			{
			
				$n++;
				if( $n < $page)
				{
					continue;
				}	
				else
				{
					$sm = false;	
				}		
				$res .=	"<div><table cellspacing='5' cellpadding='3'><tr><td><img src='$bb/img/video_.png' /></td><td><a href='".PTH."/$user' onClick='return _pop(event,$r[2]);'  >$user</a> commented on your <a href='#' onclick='hist_media($var3,2)'>video</a><td><a  class='del' udate='$r[5]' title='".date('r',$r[5])."'>".gtime($r[5])."</a></td></tr></table></div>";
			}
			break;
			default:
				//*yimu*//
				
			break;			
		}
		if( $n < $page)
		{
			continue;
		}	
		else
		{
			$sm = false;	
		}
		if($n == (20 + $page))
		{
			$sm = true;
			break;	
		}
	}
}
$total = $page + 20 + 1;
$res .= $sm ?"<div id='show_more' align='center' onclick='_more_hist(event,$total)'></div>":"";	
$res .= $n == 0 ?"<div align='center' class='m_s_g'><i>There are no events in your plate</i></div>":"";
$res .= "</div>";
echo $res;
$q = NULL;
$r = NULL;
$con->close_db_con($conc);
?>

