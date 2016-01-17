<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = intval($_SESSION["uid"]);
$u = $_POST["uid"]; 
if(ctype_digit($u)&& $u == 0){exit ("<div style='padding:30px;'><a href='".PTH."/' style='font-size:20px;'>Join Muzik Kitchen</a></div>");}
if($u == $uid || $u == $_SESSION["user"])
{
//	exit();	
}
if(isset($u) && strlen($u) > 4)
{
	$u = strclean($u);
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT id,user,name,img1,sex,bio,bg,bgcolor,web FROM users WHERE id = '$u' OR user = '$u'");
	if(mysqli_num_rows($q) == 0)
	{
			$con->close_db_con($conc);
		exit("<div class='m_s_g' align='center'>This user '$u' doest not exist.</div>");	
	}
	$r = mysqli_fetch_array($q);
	$q = NULL;
	$q = mysqli_query($conc,"SELECT * FROM follow WHERE u1 = $r[0]");
	$ff = mysqli_num_rows($q);
	$feeds = numfeeds($conc,$r[0]);
	$q = NULL;
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name` ,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE `post`.`user` = $r[0] ORDER BY `post`.`id` DESC LIMIT 0,3");
	while($rr = mysqli_fetch_array($q))
	{
		$post .=  post($rr[0],$uid,$rr[1],$rr[5],$rr[6],$rr[4],$rr[3],$rr[2],"pop",$rr[8],$rr[9],$rr[7]);		
	}	
	$q = NULL;
	$q = mysqli_query($conc,"SELECT * FROM follow WHERE u2 = $r[0]");
	$ffl = mysqli_num_rows($q);
	$sex = intval($r[4]) > 0?"<br/>Sex: <b>".$sex_array[$r[4]]."</b>":"";
	$bio = strlen($r[5])>0?"<br/>Quote: <b>&lsquo;$r[5]&rsquo;</b>":"";
	$url = strlen($r[7])>0?"Website: <b><a href='http://$r[8]'>$r[8]</a></b>":"";
	$r[6]=strlen($r[6])>3?$r[6]:"/profile_bg/default.jpg";
	$tag_tag = isFollowing($conc,$uid,$r[0])?"title='undine with $r[1]' class='unff'":"title='dine with $r[1]' class='ff'";
	$follow = $uid != $r[0] && $uid != 0?"<img height='32' width='32' src='".PTH."/img/spacer.gif'  $tag_tag onclick='return ff(event,$r[0]);'  /> ":"";
	$smsg = $r[0] != $uid && $uid != 0 && isFollowing($conc,$r[0],$uid) ?"<img height='32' width='32' src='".PTH."/img/spacer.gif' class='msg' title='Send Message' onclick='modal_msg($r[0],\"$r[1]\")' />":"";
	echo "<div style='border-radius:5px;border:4px solid ".$color_array[$r[7]].";'><table align='center' style='background-image:url(".PTH."$r[6]);border-bottom:2px solid ".$color_array[$r[7]].";' width='100%' cellpadding=0 cellspacing=2 border=0 class='userwindiv'>
	<tr><td valign='top' align='center'><a href='".PTH."/$r[1]' onclick='return _o(event,\"$r[1]\");'><div style='background:url(".PTH."$r[3]) center no-repeat;display:none' class='smpdiv'></div><img src='".PTH."$r[3]' title='$r[2]' /></a><br/><a href='".PTH."/$r[1]' onclick='return _o(event,\"$r[1]\");'>$r[1]</a><br/><b>$r[2]</b><br/>Feeds:<b>$feeds</b> Dining with me:<b>$ffl</b> Dining With:<b>$ff</b>$sex $url $bio<br/>$follow $smsg</td></tr>
	</table>
	<div class='userwindiv_'>
		".$post."
	</div>
	<input type='hidden' value='' id='eval_pop' />
	</div>
	____id:$r[0]";
		
		
}
$con->close_db_con($conc);
?>