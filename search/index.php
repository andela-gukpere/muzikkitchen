<?php
session_start();
$dbfile  = "./scripts/db.php";
if(file_exists($dbfile))require_once($dbfile);
else require_once(".".$dbfile);
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = $_SESSION["uid"];
$mobile = $_POST["mobile"];
$arg = strclean($_REQUEST["s"]);
if(!isset($_REQUEST['s']))
{
	$arg = strclean($_REQUEST["search"]);
}
list($s1,$s2) = explode(" ",$arg,2);
$page = intval($_POST["page"]);
$pp = $page > 0 ? $page - 1:0;
	$url = PTH."/";
		$b = PTH;
	function getArt($con,$s,$s1,$s2)
		{
	
		$q = mysqli_query($con,"SELECT  `art`.`id`,`art`.`user`,`art`.`name`,`art`.`info`,`art`.`img1`,`art`.`img2`,`art`.`img3`,`art`.`date`,`users`.`user` FROM `art` INNER JOIN `users` ON `users`.`id` = `art`.`user` WHERE art.name LIKE '%$s%' OR art.info LIKE '%$s%' LIMIT 0, 20");
		if(mysqli_num_rows($q) == 0)
		{
			return "<div class='m_s_g'>No content available</div>";	
		}
		$n= 0;
		$ans = "<table><tr>";

		while($r = mysqli_fetch_array($q))
		{
			$n++;
			$ans .="<td><a href='".PTH."/picture-$r[0]' onclick='return setURI(\"picture\",$r[0])' name='modal'><div style='background:url(".PTH."/img/load/ml.gif) no-repeat center;'  class='ssmpdiv' ><div style='background:url(".PTH."$r[4]) no-repeat center;' class='ssmpdiv' title='$r[3]' onmouseover='anim(event)' onmouseout='anim2(event)' aid='$r[0]' onclick='playart(event)' uid='$r[1]' owner='$r[8]' art='".PTH."$r[6]' aname='$r[2]' adate='".gtime($r[7])."'></div></div></a></td>";
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
			return "<div class='m_s_g'>No content found</div>";	
		}
		while($r = mysqli_fetch_array($q))
		{
			$ans .=  "<a href='".PTH."/music-$r[0]' onclick='return setURI(\"music\",$r[0])'><li class='muzik_item' mid='$r[0]' title='$r[3]' onclick='playmusic(event)' mname='$r[2]' music='$r[4]' mdate='".gtime($r[6])."' owner='$r[7]' uid='$r[1]'>$r[2]</li></a>";
			
		}
		return $ans;
	}
	function getVid($con,$s,$s1,$s2)
	{
		$q = mysqli_query($con,"SELECT videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user WHERE videos.name LIKE '%$s%' OR videos.info LIKE '%$s%'  LIMIT 0 , 10 ");
		if(mysqli_num_rows($q) == 0)
		{
			return "<div class='m_s_g'>No content found</div>";	
		}
		$ans = "";
		while($r = mysqli_fetch_array($q))
		{
			$ans .= "<a href='".PTH."/video-$r[0]' onclick='return setURI(\"video\",$r[0])'><li class='vid_item' vid='$r[0]' title='$r[3]' onclick='playvideo(event)' prev='$r[4]' video='$r[5]' info='$r[3]' vidname='$r[2]' vdate='".gtime($r[7])."' owner='$r[8]' uid='$r[1]'>$r[2]</li></a>";
			
		}
		return $ans;
	}
if($page == 0)
{
?>
<div style='margin-top:10px; padding:10px 0 0 0;overflow:hidden;'>
<div class="ndiv" style="font-size:xx-large;color:#336699;margin-bottom:20px" align="center">Search results for '<b><?php echo $arg; ?></b>'
<br/><a href="#!/trend=<?php echo $arg; ?>" onclick="return _st(event,'<?php echo $arg; ?>');" style="font-size:small;background:url(<?php echo $b ?>/img/feed.png) left no-repeat;padding-left:20px;">Search for feeds containing &lsquo;<b><?php echo $arg; ?></b>&rsquo;</a>
</div>

<?php	
}
if(isset($arg))
{
		$res = "";
		$ress="";
		$con = new db();$conc = $con->c();
		$q = mysqli_query($conc,"SELECT * FROM users WHERE user LIKE '%$s1%' OR user LIKE '%s2%' OR user LIKE '%$arg%' or name LIKE '%$s1%' OR name LIKE '%s2%' OR name LIKE '%$arg%' ORDER BY user ASC LIMIT $pp, 21");
		if(mysqli_num_rows($q) == 0)
		{
			$ress= "<div align='center' class='m_s_g'>There are search results for &lsquo;<b>$arg</b>&rsquo;
			</div>
			<div style='padding:10px;'>
			<div style='font-size:large;margin-bottom:30px;border-bottom:1px solid #336699;width:40%;' align='center'>Web Search</div>
			<a href='http://www.bing.com/search?q=".urlencode($arg)."&pc=MUZIKK&form=MKKPBL' target='_blank'><li>Bing Search &lsquo;<b>$arg</b>&rsquo;</li></a> 
		<br/>
		<br/>
				<a href='http://www.google.com.ng/search?sclient=psy&hl=en&site=muzikkitchen.com&source=hp&q=".urlencode($arg)."&btnG=Search' target='_blank'><li>Google Search &lsquo;<b>$arg</b>&rsquo;</li></a>
			</div>
			";	
		}
				
		while($r = mysqli_fetch_array($q))
		{
			if(isset($mobile))
			{
			//	$url = "./?i=";
				$ajax_op = "";
				$pic_class = "class='smpdiv'";
				$bb = PTH.$r[7];
			}
			else
			{
			
				$ajax_op = "onClick='return _pop(event,\"$r[0]\");'";	
				$pic_class = "class='mpdiv' ";
					$bb = PTH.$r[8];
			}

			$tag_tag = isFollowing($conc,$uid,$r[0])?"title='undine with $r[2]' class='unff'":"title='dine with $r[2]' class='ff'";
			$ff = $r[0] != $uid?"<img height='32' width='32' src='$b/img/spacer.gif'  $tag_tag onclick='return ff(event,$r[0]);'  />":"";
			if($_SESSION["uid"] == 0)
			{
				$ff = "";	
			}
			$res .= "<table class='post'><tr><td width='90%'><a href='$url$r[2]' $ajax_op ><div><table><tr><td><div $pic_class style='background-image:url($bb)'></div></td><td valign='top'>$r[2]<Br/><i>$r[3]</i><br/><i>$r[5]</i></td></tr></table></div></a></td><td>$ff</td></tr></table>";		
		}		
		$num = mysqli_num_rows($q);
		$q = NULL;$r = NULL;
		if($num < 21)
		{
			$sm = false;	
		}
		else
		{
			$sm = true;	
		}
		$total = 20 + $page + 1;
		$res .= $sm ?"<div id='show_more' align='center' onclick='_more_search(event,\"$arg\",$total)' title='show more'></div>":"";
		if($page != 0 || isset($mobile))
		{
			echo $res;
			?>
            <div id="aside">	
           	 <I>Media results for &rsquo;<b><?php echo $arg; ?></b>&lsquo;</I><br/><br/>
            <div class="title">Art</div>
	            <div id="box" align="center">
    	        <?php 
       		     echo getArt($conc,$arg,$s1,$s2);
       		     ?>
        	    </div>
            <br />
            <div class="title">Music</div><Br />
            	<div id="box" class="playlist" >
                    <ul id="plid">
                    <?php 
                    echo getMusic($conc,$arg,$s1,$s2);
                    ?>
                    </ul>
                </div>
            <br />
            <div class="title">Videos</div><br />
                <div id="box" class="playlist" >
                <ul>
                    <?php 
                    echo getVid($conc,$arg,$s1,$s2);
                    ?>
                </ul>
                </div>
           </div>
			<?php
			echo $ress;
			$con->close_db_con($conc);
			exit();	
		}
		
}
else
{
	exit();	
}
?>

<table><tr><td valign="top">
<div id="leftcolumn" style="padding:0px !important;" ><div class="ndiv" id="s_ch"><?php echo $res.$ress; ?></div></div></td><td valign="top"><div id="rightcolumn">
<div id="aside">
           	 <div class="ndiv">Media results for &rsquo;<b><?php echo $arg; ?></b>&lsquo;</div><br/>
<div class="title">Art</div>
<div id="box" align="center">
<?php 
echo getArt($conc,$arg,$s1,$s2);
?>
</div>
<div class="title">
Music</div>
<div id="box" class="playlist" >
<ul id="plid">
<?php 
echo getMusic($conc,$arg,$s1,$s2);
?>
</ul>
</div>

<div class="title">
Videos</div>
<div id="box" class="playlist" >
<ul>
<?php 
echo getVid($conc,$arg,$s1,$s2);
$con->close_db_con($conc);
?>
</ul>
</div>

</div></div></td></tr></table>
</div>
    <input type="hidden" value="document.title= 'Muzik Kitchen | Search `<?php echo $arg ?>`';processVars();" id="eval_script" /> 