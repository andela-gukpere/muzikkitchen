<?php
$uid = intval($_SESSION["uid"]);	
$pid = $pid == 0 ?(strlen($r[0]) > 4?$r[0]:$uid):$pid;
$pname = strlen($r[10]) > 4?$r[10]:$_SESSION["user"];
if(!$conc){$con = new db;$conc = $con->c();}
$tag_tag = isFollowing($conc,$uid,$pid)?"title='undine with $pname' class='unff'":"title='dine with $pname' class='ff'";
?>
<div id="panel"  <?php echo $pid==0?"style='display:none;'":""; ?> align="center">

        	<!--a href="#" class="music" title="Music" onclick="return _music()"></a>

            <a href="#" class="video" title="Video" onclick="return _video()"></a>
           <a href="#" class="art" title="Pictures" onclick="return _art()"></a-->
       <?php echo $pid != $uid && $uid != 0?"<a href='#' $tag_tag onclick='return ff(event,$pid);' ></a> ":""; 
	    echo $pid != $uid && $uid != 0 && isFollowing($conc,$pid,$uid) ?'<a href="#" class="msg" title="Send Message" onclick="modal_msg(\''.$pid.'\',\''.$pname.'\')"></a>':"";
	  
	   ?>
        </div>
        <?php
		 /*
        <div id="music" onclick="$(this).fadeOut(500)">
        	<h2 style="border-bottom:1px solid #999;"><?php echo $pname?>'s Music</h2>
            <ul>
                <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date FROM music  WHERE music.user = $pid");
					while($rr = mysqli_fetch_array($q))
					{
						echo "<ahref='".PTH."/music-$rr[0]' onclick='return setURI(\"music\",$rr[0])' name='modal'><li class='muzik_item' title='$rr[3]' mid='$rr[0]' onclick='playmusic(event)' mname='$rr[2]' music='$rr[4]' mdate='".date("l jS F Y g:i:a",$rr[5])."' owner='$pname' uid='$pid'>$rr[2]</li></a>";	
					}
				?>
            </ul>
            
            <!--h2>Featured Music</h2><hr />
            <ul>  
            	
//					$q = NULL;
	//				$q = mysqli_query($conc,"SELECT music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id= music.user ORDER BY RAND() limit 0,5");
		//			while($rr = mysqli_fetch_array($q))
			//		{
				//		echo "<a href='#' ><li title='$rr[3]' mid='$rr[0]' onclick='playmusic(event)' mname='$rr[2]' info='$rr[3]' music='$rr[4]' mdate='".gtime($rr[5])."'>$rr[2]</li></a>";	
					//}
				
          
        </ul-->
        </div>
        
        <div id="video" onclick="$(this).fadeOut(500)">
        	<h2><?php echo $pname?>'s Video</h2><hr />
             <ul>
        <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT  videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date FROM `videos` WHERE videos.user =$pid");
					while($rrr = mysqli_fetch_array($q))
					{
						echo "<a href='".PTH."/video-$rrr[0]' onclick='return setURI(\"video\",$rrr[0])'  name='modal'><li class='vid_item' title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]'  vidname='$rrr[2]' vid='$rrr[0]' vdate='".gtime($rrr[7])."' owner='$pname' uid='$pid' >$rrr[2]</li></a>";	
					}
				?>
    </ul>
        </div>
        <div id="art" onclick="$(this).fadeOut(500)">
                	<h2><?php echo $pname?>'s ArtWork</h2><hr />
                    <table><tr>
         <?php
					 $n = 0;
					$q = NULL;
					$q = mysqli_query($conc,"SELECT `art`.`id`,`art`.`user`,`art`.`name`,`art`.`info`,`art`.`img1`,`art`.`img2`,`art`.`img3`,`art`.`date` FROM `art`  WHERE `art`.`user` = $pid");
					while($rr = mysqli_fetch_array($q))
					{
						$n++;
						echo "<td><a href='".PTH."/picture-$rr[0]' onclick='return setURI(\"picture\",$rr[0])' name='modal'><div class='ssmpdiv' style='height:40px;width:40px;background:url(".PTH."/img/load/ml.gif) no-repeat center;'   ><div style='background:url(".PTH."$rr[4]) no-repeat center;' class='ssmpdiv' title='$rr[3]' aid='$rr[0]' onmouseover='anim(event)' onmouseout='anim2(event)' onclick='playart(event)' art='".PTH."$rr[6]' aname='$rr[2]' adate='".gtime($rr[7])."' owner='$pname' uid='$pid'></div></div></a></td>";
							echo $n % 5 == 0 ?"</tr><tr>":"";
					}
				?>
                </tr></table>
        </div>
        <?php
		*/
		?>
        <div id="aside">
        <div class="title">Trending Topics</div>
            <div id="box" class="playlist">           
           	<div id="trend" style="padding:5px;">
            <p>People are talking about:</p>
            <p style="padding-left:10px;">
            	<?php
				$qt = mysqli_query($conc,"SELECT trend,tc FROM trend WHERE id > 0 ORDER BY tc DESC LIMIT 0 , 6");
				while($rt = mysqli_fetch_array($qt))
				echo"<a href='#!/trend=$rt[0]' title='$rt[1]'>$rt[0]</a><br/>";
				if(mysqli_num_rows($qt)==0)echo "Nothing Trending";
				$qt = NULL;$rt=NULL;
				?>
                </p>
             </div>
            </div>
 
        	<div class="title">Random Playlist</div>
            <div id="box" class="playlist">
            	<ul id="plid">
                <!--a href="#dialog"  id="nowplay" name="modal"><li>Now Playing : <B id='nowplaying'>Nothing</B></li></a-->
              
         
                 <?php
				 if(!$is_me){
				 	 echo '<marquee  onMouseOver="this.stop();" onMouseOut="this.start();" behavior="slide" direction="left" width="200" id="_np_"></marquee>';
				 }
					$q = NULL;
					$q = mysqli_query($conc,"SELECT  music.id,music.user,music.name,music.info,music.mp3,music.dl,music.date,users.user FROM music INNER JOIN users ON users.id = music.user ORDER BY RAND() DESC limit 0,10 ");
					while($rr = mysqli_fetch_array($q))
					{ 
						echo "<a href='".PTH."/music-$rr[0]' onclick='return setURI(\"music\",$rr[0])'><li title='$rr[3]' onclick='playmusic(event)' mid='$rr[0]' mname='$rr[2]' music='$rr[4]' mdate='".gtime($rr[6])."' owner='$rr[7]' uid='$rr[1]' class='muzik_item' >$rr[2]</li></a>";	
					}
					$q = NULL;
					$q = mysqli_query($conc,"SELECT  videos.id,videos.user,videos.name,videos.info,videos.pict,videos.vid,videos.dl,videos.date,users.user FROM `videos` INNER JOIN users ON users.id = videos.user ORDER BY videos.id DESC limit 0,5 ");
					while($rrr = mysqli_fetch_array($q))
					{
						echo "<a href='".PTH."/video-$rrr[0]' onclick='return setURI(\"video\",$rrr[0])'><li title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]' vidname='$rrr[2]' vid='$rrr[0]' vdate='".gtime($rrr[7])."' owner='$rrr[8]' uid='$rrr[1]' class='vid_item' >$rrr[2]</li></a>";	
					}
$con->close_db_con($conc);
				?>
                 </ul>
            
            </div>
            <div class="title">Dining with you</div>
            <div id="box" class="playlist">           
           	<div id="_dinewu">
            
             </div>
            </div>
            
            <div class="title">Peeps you may know</div>
            <div id="box" class="playlist">
           
            	<div id="_suggest" >
            
                </div>
            </div>
             
        </div>