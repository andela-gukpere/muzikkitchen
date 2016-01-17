<?php
function requireonce_($file)
{
	if(file_exists($file)){require_once($file);return;}
	if(file_exists(".".$file)){require(".".$file);return;}
	if(file_exists("..".$file)){require("..".$file);return;}
	return false;
}
requireonce_("./scripts/db.php");
session_start();
$r = "";
$ismobile = ($_SESSION["mobile"]);

if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	//exit("<div class='m_s_g'>Invalid Authentication<div>");
}
	$title = "";
	$con = new db();
	$conc = $con->c();
	$uid = intval($_SESSION["uid"]);
	$pid = 0;
	//$page = intval($_POST["page"]);
	$mediaID = ($_REQUEST["mediaID"]);
	if(stristr($mediaID,"-"))
	{
		list($x0,$mediaID) = explode("-",$mediaID);	
	}
	$mediaID = intval($mediaID);
	$type= intval($_REQUEST["type"]);
	//echo $mediaID."<br>";
	//print_r($_GET);
	$user = "";
	$texttype=  array("","picture","music","video");

$shr = $ismobile==2?"":"<p><g:plusone annotation=\"inline\"></g:plusone></p>".'<p><a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="en" data-size="large" data-count="none">Tweet</a>
'."</p>
<p>".'<div class="fb-like" data-href="http://'.$_SERVER['HTTP_HOST']."/".$texttype[$type].'-'.$mediaID.'" data-send="true" data-layout="button_count" data-width="300" data-show-faces="true" data-font="trebuchet ms"></div>'."</p>";
$width = $ismobile==2?"style='width:100%'":"";

echo "<div><table><tr><td valign='top' $width ><div class='ndiv' id='leftcolumn' ".($ismobile==2?"":"style='padding:10px;'").">";
	switch($type)
	{
		case 1:
				$q = mysqli_query($conc,"SELECT art.id,art.user,art.name,art.info,art.img1,art.img2,art.img3,art.date,users.user,art.play FROM art INNER JOIN users ON users.id = art.user WHERE art.id = $mediaID");
				
				$rr = mysqli_fetch_array($q);
				$title = $rr[2];
				$pid = $rr[1];
				$n = mysqli_num_rows($q);
				if($n == 1)
				{
					$user = $rr[8];
					echo '<span style="font-size:x-large;text-shadow:0 0 2px #333;">'.$rr[2].' '.mediaplaycount(0,$mediaID).'</span><br/><span style="font-size:20px;text-shadow:0 0 2px #333;">'.$rr[3].'</span>'."<div align='center'class='main_art' style='background:url(".PTH."/img/load/ml.gif) no-repeat center;'>
					<a href='".PTH."/art/full_".substr($rr[6],5,strlen($rr[6]))."' target='_blank'>
					<img src='.$rr[6]' aid='$rr[0]' onmouseover='anim(event)' onmouseout='anim2(event)' /></a></div><div class='subdiv'><P>Uploaded by <a href='".PTH."/$rr[8]' onclick='return _pop(event,\"$rr[8]\");'>$rr[8]</a></P></div> $shr	<input type='hidden'  id='upid' value='$rr[1]'><i class='del'>".gtime($rr[7])."</i><div id='comdiv'></div>";
					$qq = mysqli_query($conc,"SELECT art.id,art.user,art.name,art.info,art.img1,art.img2,art.img3,art.date,users.user FROM art INNER JOIN users ON users.id = art.user WHERE art.user = $pid AND art.id <> $rr[0]");
					
					echo "<table cellpadding='10' ><tr>";
					$i= 0;
					if(mysqli_num_rows($qq) > 0)
					{
						echo "<div style='margin-top:20px;font-size:20px;'>Other pictures by <a href='".PTH."/$rr[8]' onclick='return _pop(event,\"$rr[8]\");'>$rr[8]</a></div>";	
					}
					while($rr = mysqli_fetch_array($qq))
					{
						$i++;
						echo "<td><a href='".PTH."/picture-$rr[0]' onclick='return setURI(\"picture\",$rr[0])'><div style='background-image:url(".PTH."$rr[4])' class='ssmpdiv' onclick='_gomedia($rr[0],$type);' onmouseover='anim(event)' onmouseout='anim2(event)' ></div></a></td>";		
						echo $i % 10 == 0?"</tr><tr>":"";
					}
					echo "</tr></table>";
				}
				else
				{
					echo "<div class='m_s_g' style='padding:50px;'>The picture you tried to access is not available.</div>";	
				}
		break;
		case 2:				
				
				$q = mysqli_query($conc,"SELECT  music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user,music.play,users.bgcolor FROM music INNER JOIN users ON users.id = music.user WHERE music.id = $mediaID; ");
				if(mysqli_num_rows($q) == 1)
				{
					$rr = mysqli_fetch_array($q);
					global $color_array;
					$profcolor = $color_array[$rr[9]];
					$profcolor = str_replace("#","",$profcolor);
					$title = $rr[2];
					$mid = $rr[0];
					$user = $rr[7];
					$qq = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id = music.user WHERE music.user = $rr[1] AND music.id <> $rr[0] ORDER BY rand(); ");
					$music_array = array();
					$mtitle = array();
					$endres = "";
					$musics= "";
					$mtitles= "";
					$endres = "<table><tr>";
					if(mysqli_num_rows($qq) > 0)
					{
						$endres .= "<div style='margin-top:20px;font-size:20px;'>Other songs by <a href='".PTH."/$rr[8]' onclick='return _pop(event,\"$rr[7]\");'>$rr[7]</a></div>";	
					}
					$i = 0;
					while($rrr = mysqli_fetch_array($qq))
					{
						$i++;
						if($rrr[0] == $rr[0])continue;
						$musics .="|".PTH."/music/".$rrr[4];
						$mtitles .= "|".$rrr[2];
						$endres .= "<td><a href='".PTH."/music-$rrr[0]' onclick='return setURI(\"music\",$rrr[0]);'><div onclick='_gomedia($rrr[0],$type)' mdate='".gtime($rr[6])."' class='music_m' >$rrr[2]</div></a></td>";
						$endres.= $i % 4 == 0?"</tr><tr>":"";
					}
					$endres .= "</tr></table>";

					$musicsrc = $ismobile == 2?'<audio height="30" loop="loop" width="auto" autoplay id="myaudio" preload="auto" autobuffer src="'.PTH.'/music/'.$rr[4].'" controls><source src="'.PTH.'/music/'.$rr[4].'" ></source></audio>':'<div class="player" style="padding:10px;"><object type="application/x-shockwave-flash" data="'.PTH.'/player/player_mp3_multi.swf" width="500" height="120">    <param name="movie" value="'.PTH.'/player/player_mp3_multi.swf" />                   <param name="FlashVars" value="mp3='.PTH.'/music/'.$rr[4].$musics.'&amp;title='.$rr[2].$mtitles.'&amp;autoplay=1&amp;bgcolor1='.$profcolor.'&amp;bgcolor2='.$profcolor.'&amp;buttoncolor=ffffff&amp;buttonovercolor='.$profcolor.'&amp;width=450&amp;showvolume=1&amp;showinfo=0&amp;sliderovercolor='.$profcolor.'&amp;showplaylistnumbers=1&amp;textcolor='.$profcolor.'&amp;&amp;repeat=1&amp;shuffle=0&amp;height=100" /> </object>            </div> ';
					$res = "<div><a style='font-size:x-large;padding:0 30px 0 70px;' href='".PTH."'/music-$rr[0]' title='$rr[3]' class='music_m' onclick='_gomedia($rr[0],$type);' >$rr[2] ".mediaplaycount(1,$mediaID)."</a></div>
					".'<br/><span style="font-size:20px;text-shadow:0 0 2px #333;">'.$rr[3].'</span>'."
					$shr <input type='hidden'  id='upid' value='$rr[1]'>
					".$musicsrc."
					<div class='subdiv'><P>Uploaded by <a href='".PTH."/$rr[7]' onclick='return _pop(event,\"$rr[7]\");'>$rr[7]</a></P>					<i class='del'>".gtime($rr[6])."</i><div id='comdiv'></div>";	
					echo $res."".$endres."</div>";
				}
				else
				{
					echo "<div class='m_s_g' style='padding:50px;'>The song you tried to access is not available.</div>";		
				}
		break;
		case 3:
			$q = mysqli_query($conc,"SELECT  videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.id = $mediaID ");
			if(mysqli_num_rows($q) == 1)
			{
					$rrr = mysqli_fetch_array($q);
					$title = $rrr[2];
					$user = $rrr[8];
					$vidoessrc = $ismobile==2?'<div><video autoplay="autoplay" controls="controls" poster="'.PTH.'/prev/'.$rrr[4].'" src="'.PTH.'/video/'.$rrr[5].'" title="video may not play on your device"><source src="'.PTH.'/video/'.$rrr[5].'" ></source></video></div>':'<div style="width: 550px; height: 400px;" id="mediaplayer_wrapper"><object tabindex="0" name="mediaplayer" id="mediaplayer" bgcolor="#000000" data="'.PTH.'/player/player.swf" type="application/x-shockwave-flash" height="400" width="550"><param value="true" name="allowfullscreen"><param name="Movie" value="'.PTH.'/player/player.swf" /><param name="Src" value="'.PTH.'/player/player.swf"><param value="always" name="allowscriptaccess"><param value="true" name="seamlesstabbing"><param value="opaque" name="wmode"><param value="id=mediaplayer&amp;file=..%2Fvideo%2F'.$rrr[5].'&amp;image=.%2Fprev%2F'.$rrr[4].'&amp;controlbar.position=over&amp;title='.$rrr[2].'&amp;author=muzikkitchen.com&amp;description='.$rrr[3].'&amp;date='.gtime($rrr[7]).'" name="flashvars"><embed src="'.PTH.'/players/player.swf" height="400" width="550" /></object></div>';
					echo '<span style="font-size:x-large;text-shadow:0 0 2px #333;">'.$rrr[2].' '.mediaplaycount(2,$mediaID).'</span><br/><span style="font-size:20px;text-shadow:0 0 2px #333;">'.$rrr[3].'</span>'.$vidoessrc;//<a href='#!/video=$rrr[0]'><li title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]' vidname='$rrr[2]' vid='$rrr[0]' vdate='".gtime($rrr[7])."' owner='$rrr[8]' uid='$rrr[1]' class='vid_item' >$rrr[2]</li></a>
						echo "$shr <input type='hidden'  id='upid' value='$rrr[1]'>
						<div class='subdiv'><P>Uploaded by <a href='".PTH."/$rrr[8]' onclick='return _pop(event,\"$rrr[8]\");'>$rrr[8]</a></P></div><i class='del'>".gtime($rrr[7])."</i>
						<div id='comdiv'></div>";
					$q = mysqli_query($conc,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.user = $rrr[1] ");
				if(mysqli_num_rows($q) > 1)
				{
					echo "<div style='margin-top:20px;font-size:20px;'>Other videos by <a href='".PTH."/$rrr[8]' onclick='return _pop(event,\"$rrr[8]\");'>$rrr[8]</a></div>";	
				}
				$n= 0;
				echo"<table><tr>";
				while($r = mysqli_fetch_array($q))
				{
					$n++;
					if($rrr[0] == $r[0])continue;
					echo "<td ><a href='".PTH."/video-$r[0]' name='modal' onclick='return setURI(\"video\",$r[0])'><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;height:120px;width:120px;padding:10px;'><div style='background:url(".PTH."/prev/$r[4]) left;' class='vid_prev' title='$r[3]' onclick='_gomedia($r[0],$type)'>$r[2]<br/>$r[3]</div></div></a><br/></td>";	
					echo $n % 4 == 0 ?"</tr><tr>":"";	
				}
				
				echo "</tr></table>";	
			}
			else
			{
				echo "<div class='m_s_g' style='padding:50px;'>The video you tried to access is not available.</div>";		
			}
		break;
	}
echo"</div></td><td valign='top'><div id='rightcolumn'>";
if(!$ismobile){
requireonce_("./actions/right_column.php");
requireonce_("./right_column.php");
}

echo"</div></td></tr></table></div>";
?>

<input type="hidden" id="eval_script" value="now_playing(<?php echo intval($type - 1); ?>,<?php echo $mediaID; ?>);document.title='Muzik Kitchen | <?php echo strclean($title); ?>'

" />
<?php if($ismobile==2 || isset($_GET["media"])){ ?>
<script language="javascript">
$(document).ready(function(e) {
    try{
		$(".subdiv").html(_str($(".subdiv").html()));
		var uid = document.getElementById("upid").value;
		var div = new createCommentDiv(<?php echo "'".$_GET["mediaID"]."','".$_GET["type"]."','$owner'"; ?>);
		document.getElementById("comdiv").appendChild(div);
		eval(document.getElementById("eval_script").value);
		_share_media();
		}
		catch(e)
		{
			alert(e+"errr");
		}

});
</script>
<?php
}
?>