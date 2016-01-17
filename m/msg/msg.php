<div id="m_t_b">
<?php 

$id = $_GET["inb"];
if(isset($id) && $id !="")
{
 	$con = new db();$conc = $con->c();
 	$subjres = mysqli_query($conc,"SELECT `subj`,`u1` FROM `msg_subj` WHERE `id` = $id AND (`u1`=$uid OR `u2` = $uid)");
	
 	$subj = mysqli_fetch_array($subjres);
 	$result = "<div style='margin-left:10px;padding:15px;width:100%;' class='wp'><span style='color:#BBB;font-size:25px;'>".$subj[0]."</span><table cellspacing='5' width='90%' >";
	
	$lastview = mysqli_query($conc,"SELECT `uid` FROM `msg` WHERE `cid` = $id ORDER BY `id` DESC");
	$ltv = mysqli_fetch_array($lastview);
	if($ltv[0] != $uid)
	{
		$old = mysqli_query($conc,"UPDATE `msg` SET `new` = 0 WHERE `cid` = $id");
	}
	$msgs = mysqli_query($conc,"SELECT `msg`.`id`,`msg`.`uid`,`msg`.`msg`,`msg`.`date`,`users`.`user`,`users`.`name`,`users`.`img1` FROM `msg` inner join `users` on (`msg`.`uid` = `users`.`id`)WHERE `msg`.`cid` = $id ORDER BY `msg`.`id` ASC");
	if($msgs && $subjres)
	{
		echo("<a href='#' onclick='gmsgs();'>&laquo;&larr;Go Back</a><br/><br/>");
		$num = mysqli_num_rows($msgs);
		if($num==0)
		{
			echo("<center style='color:#888888;font-size:18px'><i> No messages </i></center>");
		}
		while($res = mysqli_fetch_array($msgs))
		{
			$del = $res[1]==$uid?"<a href='#'class='del' onclick='delmsg(".$res[0].")'><b>&middot;</b> Delete</a>":"";
			$vart = gtime($res[3]);
			$u = array($res[4],$res[5],$res[6]);//users($conc,"`fname`,`lname`,`img_m`",$res["email"]);
			$flname = "$u[0] <i>$u[1]</i>";
			$result .= "<tr><td style='width:70px' valign='top'><a href='./".$res[4]."'><div class='smpdiv' style='background:url(./$u[2]) top left no-repeat;' title='$flname'></div></a></td><td valign='top'><span style='color:#888;'>$flname</span><br/><span style='color:#444444;'>".$res[2]."</span> $del<br/><span style='font-size:10px;color:#777777;'>".$vart."</span></td></tr>";
		}
		
	}
		$uu = ($_SESSION["img1"]);
		$con->close_db_con($conc);
		$result .= "</table><div><div class ='comm'><table width='100%'><tr><td valign='top'><div class='smpdiv'style='background:url(./$uu) no-repeat top left;' ></div></td><td width='80%'><textarea id='txtamsg' rows='1' onfocus='rows=2' ></textarea><br /><input type='button' onclick='sendmsg($id,event)' style='float:right' class='button1' value='Send Message'/></td></tr></table></div></div></div></div>";
		echo $result;
}
?>
</div>
<script>
$("#m_t_b").html(_str(document.getElementById("m_t_b").innerHTML));
</script>