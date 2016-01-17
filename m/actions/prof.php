<?php
$str = $_SERVER['REQUEST_URI'];
$st = preg_split('-/-',$str);
$owner = $_GET["i"];
$pid = $owner;

$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,name,loc,img1,img2,img3,web,date,tz,bio,user,edu,work,bday,status,status_,bgcolor,sex,bg FROM users WHERE user = '$pid' OR id = '$pid'");
$r = mysqli_fetch_array($q);
if(mysqli_num_rows($q) == 0)
{
		$con->close_db_con($conc);
	exit("invalid user");	
}
$tag_tag = isFollowing($conc,$uid,$r[0])?"title='undine with $pname' class='unff'":"title='dine with $pname' class='ff'";
?>
<div id="leftcolumn">
    <a href="./<?php echo $r[10];?>"><h1 class="nameH1" style="background-color:<?php echo $color_array[intval($r[16])];?>"><?php echo $r[1] ?></h1></a>
    <table class="prof_table" id="prof_table" cellpadding="0" cellspacing="0" style="background: url(.<?php echo $r[18] ?>);"><tr><td width="100%" valign="top">
    <div id="detail" align="center"><a href='.<?php echo $r[5]?>' target="_blank"><img src='.<?php echo $r[4]; ?>' /></a>
          <h2><a href="./<?php echo $r[10];?>">@<?php echo $r[10]?></a></h2>
         <Div class='b_p_s' align="center"> 
         <span id="fh"><i style="color:#bbb;">Feeds:</i><b style="text-decoration:blink;"> <?php echo numfeeds($conc,$r[0]);?></b></span>&nbsp;
        <span id="fh"><i style="color:#bbb;">Dinning with:</i> <?php echo numff($conc,$r[0],1);?></span>&nbsp;
         <span id="fh"><i style="color:#bbb;">Dinning with me:</i> <?php echo numff($conc,$r[0],2);?></span>&nbsp;
         <?php
		 $n = 0;
			function strlen_($attrib,$v)
			{
				if($attrib == "Quote")
				{
					$ls = "&lsquo;";
					$rs = "&rsquo;";
				}
				$n++;
				$v = trim($v);
				$br = $n % 3 ==0?"<br/>":"";
				return strlen($v) > 1?"<span><i style='color:#eee'>$attrib:</i> $ls$v$rs</span>&nbsp;$br":"";	
			}
			function bday_ ($bday)
			{
				if(preg_match('-(\d{2})/(\d{2})/(\d{4})-',$bday))
				{
					$months = array("","January","February","March","April","May","June","July","August","September","October","November","December");
					list($m,$d,$y)= explode("/",$bday);
					return $months[intval($m)]." ".intval($d);
				}
				else
				{
					return "";
				}
			}
			echo strlen_("Gender",$sex_array[$r[17]]);
			//echo strlen_("Education",$r[11]);
			echo strlen_("Work",$r[12]);
			echo strlen_("Birthday",bday_($r[13]));
			echo strlen_("Status",$status_array[intval($r[14])]." ".$r[15]);
			echo strlen_("<Br/>Quote",$r[9]);
			echo strlen_("Webpage","<a href='http://".urldecode($r[6])."' target='_blank'>".urldecode($r[6])."</a>");
			echo strlen_("<br/>Location",($r[2]." ".$r[8]));
            ?>
            
            <!--h2><i style="color:#bbb;">Joined :</i> <?php echo gtime($r[7]);?></h2-->
            </Div>

          <?php
		  
          if($r[0] == $uid)
		  { ?>
            <div style="">
    <form method="post" target="bgf" action="./actions/uplbgimg.php" enctype="multipart/form-data"><input type="hidden" name="bgimg" />
    <label><input type="file" id="upl" name="upl" onchange="submit();uploading(true);" class="hdd_upl"/>
    <div class="upldiv" id="sc_cs" style="background-color:transparent;float:left !important;"title="change background"  onclick="if(navigator.userAgent.toString().indexOf('Firefox')>-1)$('#upl').click();" ></div></label></form><div  style="font-size:10px;border:1px solid #ccc; background-color:#eee; border-radius:2px;color:#444; display:none;width:200px;" id="upltxt" onmouseover="$(this).fadeOut(1000);"></div>
    <iframe height="0" width="0" frameborder="0" name="bgf"></iframe>
    </div>
    <div style="margin-left:40% !important;">
    <?php }
		 echo $r[0] != $uid && $uid != 0?"<a href='#' onclick='return ff(event,$r[0]);' ><div $tag_tag></div></a> ":""; 
 echo $pid != $uid && $uid != 0 && isFollowing($conc,$r[0],$uid) ?'<a href="./?to='.urlencode($pid).'&sendmsg&msg" title="Send Message"><div class="msg" ></div></a>':"";
	?>
    </div>
        </div> </table>
        
    
       <div align="center" class="mndiv"><ul class="menu">
    <li>
    <a href="./" class="se" onclick="_active(event);">Back Home</a>
    </li>
    <li>
    <a href="#sc_cs" onclick="gposts(4,'m_t_b');_active(event);">Mentions</a>
    </li>
    <li>
    <a href="#sc_cs" onclick="dine_(1);_active(event);">Dining With</a>
    </li>
    <li>
    <a href="#sc_cs" onclick="dine_(2);_active(event);">Dining With me</a>
    </li>
    <li>
    <a href="#sc_cs" onclick="gposts(5,'m_t_b');_active(event);">Likes</a>
    </li>
    <li>
    <a href="#sc_cs" onclick="gposts(6,'m_t_b');_active(event);">Refeeds</a>
    </li>
    </ul></div>
       <div id="m_t_b">
       <?php include_once("./actions/load.php"); ?>
       </div>
       <input type="hidden" id="owner"  value="<?php echo $r[0] ?>"/>
       <script> 
	   prof_color = "<?php echo $color_array[$r[16]];?>";
	   gposts(3,"m_t_b");
	   var detail = document.getElementById("detail");
	  
	   detail.innerHTML = _str(detail.innerHTML);
		document.title = "Muzik Kitchen | <?php  echo $r[10]?>";
	   document.body.style.backgroundColor = "<?php echo $color_array[intval($r[16])]; ?>";
       </script>
            