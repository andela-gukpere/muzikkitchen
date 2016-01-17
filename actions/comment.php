<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = intval($_SESSION["uid"]);
$type = intval($_POST["type"]);
$owner = intval($_POST["owner"]);
$cid = intval($_POST["cid"]);
$id = intval($_POST["id"]);
$action = intval($_POST["action"]);
$post = _hstr_($_POST["post"],false);
$con = new db();$conc = $con->c();
switch($action)
{
	case 1:
	$q = mysqli_query($conc,"SELECT comment.id,comment.owner,comment.uid,comment.post,comment.date,users.user,users.name,users.img1 FROM comment INNER JOIN users ON comment.uid = users.id WHERE comment.cid = $cid AND comment.type =$type ORDER BY comment.id ASC");
	echo "<div style='font-size:12px;'>";
	while($r = mysqli_fetch_array($q))
	{
			$del = $uid == $r[1] || $uid == $r[2]?"&middot;<a href='#' onclick='return _delcom(event,$type,$r[0])'><span class='del'>delete</span></a>":"";	
		echo "<div class='comment_".$r[0]."' style='width:100%;'>
					<table width='100%'><tr>
					<td width='10%'><a href='".PTH."/$r[5]' onclick='return _pop(event,$r[2]);'><div class='ssmpdiv' style='background-image:url(".PTH."$r[7]);'></div></a></td>
					<td valign='top'><a href='".PTH."/$r[5]' onclick='return _pop(event,$r[2]);'>$r[5]</a>  <i style='_pn'>$r[6]</i><br/><span>$r[3]</span><div style='float:right;'><span class='del' title='".date("U",$r[4])."'>".gtime($r[4])."</span> $del</div></td></tr></table>
			  </div>";
	}
	echo $uid != 0?"
	<div class=''><div class ='comm'><table><tr><td valign='top'><div class='ssmpdiv'style='background-image:url(".PTH."".$_SESSION["img1"].");'></div></td><td><textarea id='txtcom_".$type."' placeholder='Comment...' rows='3' class='txt' onkeyup='gment(event)'></textarea><div class='pl2div' style='position:relative'></div><br /><input type='button' onclick='_com(event,$type,$cid,$owner);' style='float:right' class='button1' value='Comment'/></td></tr></table></div></div><a href='#' onclick='addCommentV(event)'><!--span class='__c'>Add a comment</span--></a></div></div>
	</div>":"";
	break;
	case 2:
		if($uid != 0)
		{
			$q = $con->insertInto("comment",array($type,$cid,$owner,$uid,$post,date("U")));	
			$plate = 9 + $type;
			if($uid != $owner)
			{
				$q = $con->insertInto("hist",array($plate,$owner,$uid,$cid,date("U")));
			}
			echo $q?1:2;
		}	
	break;
	case 3:
		$q = mysqli_query($conc,"DELETE FROM comment WHERE (uid = $uid OR owner=$uid) AND type=$type AND id=$id");	
		echo $q?1:2;
	break;
	default:
	
	break;
}
$con->close_db_con($conc);
?>