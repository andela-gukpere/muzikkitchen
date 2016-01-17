<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		//exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];
$mob = $_POST["mobile"];
$arg = $_POST["s"];
$result = "<div class='sajax'>";
list($s1,$s2) = explode(" ",$arg,2);
if(isset($arg))
{
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT * FROM users WHERE user LIKE '%$arg%' or name LIKE '%$s1%' OR name LIKE '%s2%' OR name LIKE '%$arg%' LIMIT 0,10");
	while($r = mysqli_fetch_array($q))
	{
				$em = $rezz[0];
				$u = array($rezz[1],$rezz[2],$rezz[3]);
				$name = "$r[2] [$r[3]]";
				
				$name = str_replace($s1,"<_>".$s1."</_>",$name);
				$name = str_replace($s2,"<_>".$s2."</_>",$name);
				
				$name = str_replace(ucfirst($s1),"<_>".ucfirst($s1)."</_>",$name);
				$name = str_replace(ucfirst($s2),"<_>".ucfirst($s2)."</_>",$name);
				
				$name = str_replace(strtoupper($s1),"<_>".strtoupper($s1)."</_>",$name);
				$name = str_replace(strtoupper($s2),"<_>".strtoupper($s2)."</_>",$name);
				$bbb = "";
				$jax_ = "onclick='return _pop(event,$r[0])'  ";
				$bbb = ".";
				$url = "./";
				if(isset($mob))
				{
					//$url = "./?i=";
//					$bbb = "..";
					$jax_ = "onclick=''";
				}
		$result .= "<a href='$url$r[2]' $jax_ style='font-size:12px;color:#777'><span><table class='hz' width='100%'><tr><td><div class='ssmpdiv' style='background:url($bbb$r[7]) center no-repeat;'></div></td><td><a href='./$r[2]' $jax_ style='font-size:12px;color:#777'>$name</a></td></tr></table></span></a><br/>";		
	}
	function getArt($con,$s,$s1,$s2)
		{
	
		$q = mysqli_query($con,"SELECT  `art`.`id`,`art`.`user`,`art`.`name`,`art`.`info`,`art`.`img1`,`art`.`img2`,`art`.`img3`,`art`.`date`,`users`.`user` FROM `art` INNER JOIN `users` ON `users`.`id` = `art`.`user` WHERE art.name LIKE '%$s%' OR art.info LIKE '%$s%' LIMIT 0, 20");
		if(mysqli_num_rows($q) == 0)
		{
			return "";	
		}
		$n= 0;
		$ans = "<table><tr>";

		while($r = mysqli_fetch_array($q))
		{
			$n++;
			$ans .="<td><a href='./picture-$r[0]' onclick='return setURI(\"picture\",$r[0])' name='modal'><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;'  class='ssmpdiv' ><div style='background:url(".PTH."$r[4]) no-repeat center;' class='ssmpdiv' title='$r[3]' onmouseover='anim(event)' onmouseout='anim2(event)' aid='$r[0]' onclick='playart(event)' uid='$r[1]' owner='$r[8]' art='.$r[6]' aname='$r[2]' adate='".gtime($r[7])."'></div></div></a></td>";
			if($n % 4 == 0)
			{
				$ans .= "</tr><tr>"; 
			}
		
		}
		$ans .= "</tr></table>";
		return $ans;
	}
	
	function getMusic($con,$s,$s1,$s2)
	{
		$q = mysqli_query($con,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id= music.user WHERE `music`.`name` LIKE '%$s%' OR `music`.`info` LIKE '%$s%' LIMIT 0,10");
		if(mysqli_num_rows($q) == 0)
		{
			return "";	
		}
		while($r = mysqli_fetch_array($q))
		{
				$name = str_replace($s,"<_>".$s."</_>",$r[2]);
				$ans .=  "<a href='./music-$r[0]' onclick='return setURI(\"music\",$r[0])'><li name='modal' class='muzik_item' mid='$r[0]' title='$r[3]' onclick='playmusic(event)' mname='$r[2]' music='$r[4]' mdate='".gtime($r[6])."' owner='$r[7]' style='width:220px;' uid='$r[1]'>$name</li></a>";
			
		}
		return $ans;
	}
	function getVid($con,$s,$s1,$s2)
	{
		$q = mysqli_query($con,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.name LIKE '%$s%' OR videos.info LIKE '%$s%'  LIMIT 0 , 10 ");
		$ans = "";
		if(mysqli_num_rows($q) == 0)
		{
			return "";	
		}
		while($r = mysqli_fetch_array($q))
		{
			$name = str_replace($s,"<_>".$s."</_>",$r[2]);
			$ans .= "<a href='./video-$r[0]' onclick='return setURI(\"video\",$r[0])'><li class='vid_item' vid='$r[0]' title='$r[3]' onclick='playvideo(event)' prev='$r[4]' video='$r[5]' info='$r[3]' vidname='$r[2]' vdate='".gtime($r[7])."' owner='$r[8]' style='width:220px;' uid='$r[1]'>$name</li></a>";
			
		}
		return $ans;
	}
	$result .= !isset($mobi)?"<ul>".getArt($conc,$arg,$s1,$s2)."</ul>":"";	
	$result .= !isset($mobi)?"<ul>".getMusic($conc,$arg,$s1,$s2)."</ul>":"";	
	$result .= !isset($mobi)?"<ul>".getVid($conc,$arg,$s1,$s2)."</ul>":"";	
	$result = str_replace("<_>","<b class='j'>",$result);
	$result = str_replace("</_>","</b>",$result);
	echo $result."</div>";
	$con->close_db_con($conc);
}

?>
<a href="#!/trend=<?php echo $arg; ?>" id="no_no" onclick="return _st(event,'<?php echo $arg; ?>');" style="font-size:small;background:url("<?php echo PTH?>"/img/feed.png) left no-repeat;padding-left:20px;">Search for feeds containing &lsquo;<b><?php echo $arg; ?></b>&rsquo;</a>
