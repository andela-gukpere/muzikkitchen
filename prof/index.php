<?php
session_start();
$dbfile  = "./scripts/db.php";
if(file_exists($dbfile))require_once($dbfile);
else require_once(".".$dbfile);
$owner = isset($_POST["owner"])?$_POST["owner"]:$owner;
$me = $_SESSION["uid"];
$is_me = $owner == $me?true:false;
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,name,loc,img1,img2,img3,web,date,tz,bio,user,edu,work,bday,status,status_,bgcolor,sex,bg FROM users WHERE user = '$owner' OR id = '$owner'");


$r = mysqli_fetch_array($q);
$fname = $r[10];
$fcolor = $r[16];
$is_me = $r[0] == $me?true:false;
if(mysqli_num_rows($q) == 0)
{
	$con->close_db_con($conc);

	exit("<div class='m_s_g' align='center' style='padding:100px;'>The user <a href='./?search=$owner'>&lsquo;$owner&rsquo;</a>  does not exist <Br/><br/>Search Muzik Kitchen for <a href='".PTH."/?search=$owner'>&lsquo;$owner&rsquo;</a> </div><input type='hidden' id='eval_script' value='//_st(null,\"$owner\")' />");	
}

?>
<table><tr><td valign="top">
	<div id="leftcolumn">
    <a href="<?php echo PTH; ?>/<?php echo $r[10];?>" onclick='return _pop(event,"<?php echo $r[10]; ?> ")'><h1 class="nameH1" style=' background-color:<?php echo $color_array[$fcolor]; ?>;'><?php echo $r[1] ?></h1></a>
    <table class="prof_table" id="prof_table" cellpadding="0" cellspacing="0" style="background: url(<?php echo PTH;echo strlen($r[18])<4?"/profile_bg/default.jpg":$r[18]; ?>);"><tr><td width="100%" valign="top">    <div id="detail" align="center"><a href='<?php echo ".".$r[5]?>' target="_blank"><img src='<?php echo PTH.$r[4]; ?>' style="box-shadow:5px 5px 10px #000;" /><div class="profilepic" style="background:url(<?php echo PTH.$r[4]; ?>) center no-repeat;" onmouseover="anim(event)" onmouseout="anim2(event)"></div></a>
          <h2><a href="<?php echo PTH; ?>/<?php echo $r[10];?>">@<?php echo $r[10]?></a></h2>
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
          if($r[0] == $me)
		  { ?>
            <div style="">
    <form method="post" target="bgf" action="<?php echo PTH; ?>/actions/uplbgimg.php" enctype="multipart/form-data"><input type="hidden" name="bgimg" />
    <label><input type="file" id="upl" name="upl" onchange="submit();uploading(true);" class="hdd_upl"/><div id="upldiv" style="background-color:transparent !important;"title="change background" onclick="if(navigator.userAgent.toString().indexOf('Firefox')>-1)$('#upl').click();" ></div></label></form><div  style="font-size:10px;border:1px solid #ccc; background-color:#eee; border-radius:2px;color:#444; display:none;width:200px;" id="upltxt" onmouseover="$(this).fadeOut(1000);"></div>
    <iframe height="0" width="0" frameborder="0" name="bgf"></iframe>
    </div>
    <?php }?>
        </div>
        
        
        </td></tr></table>
        <br/>
        <br />
        <div id="tabs" style="height:70%;">

        	<ul>
            	<li><a href="#main" id='_prof_' code="tab_click(null,'main.php?code=3')" onclick="tab_click(event,'main.php?code=3')">My Table</a></li>
	          	<li><a href="#mention"code="" onclick="tab_click(event,'mention.php?code=4')">Mentions</a></li>
               <li><a href="#like_"code="" onclick="tab_click(event,'like_.php?code=5')">Likes</a></li>
   	          	<li><a href="#following"code="" onclick="tab_click(event,'following.php')">Dining with</a></li>
                <li><a href="#followers"code="" onclick="tab_click(event,'followers.php')">Dining with me</a></li>
             	<li><a href="#gallery" code="" onclick="tab_vclick(event,'view.php?type=0')">Gallery</a></li>
            	<li><a href="#muzik" code=""  onclick="tab_vclick(event,'view.php?type=1')">Music</a></li>
              	<li><a href="#videoz" code="" onclick="tab_vclick(event,'view.php?type=2')">Videos</a></li>
            </ul>
            <div id="main"><div class="div_d">
			<?php $fid=$r[0]; if(isset($_GET["i"]))include("./actions/main.php"); ?>
            </div>

            </div>
            
            <div id="mention"><div class="div_d">  </div>
            </div>
            
            
            <div id="like_"><div class="div_d">  
            </div>
            </div>
             <div id="following" ><div class="div_d">  </div>
            </div>
            
             <div id="followers"><div class="div_d">  </div>
            </div>
            
            <div id="gallery"><div class="div_d">  </div>
            </div>
            
            
            <div id="muzik"><div class="div_d">  </div>
            </div>
            
            <div id="videoz"><div class="div_d">  </div>
            </div>
            <input type="hidden" id="owner" value="<?php  echo $fid;$pid = $fid?>" />
        </div>
    </div>
</td><td valign="top">
    <div id="rightcolumn">
    	    	<?php
				$rtfile = "./actions/right_column.php";
				if(file_exists($rtfile))include($rtfile);
				else include(".".$rtfile); ?>
    </div>
</td></tr></table>
    <input type="hidden" value="prof_color = '<?php echo $color_array[intval($fcolor)]; ?>';php_color = prof_color;$(document.body).animate({backgroundColor:prof_color},1000);is_playing();document.title = 'Muzik Kitchen | <?php echo $fname ?>';$('.b_p_s').html(_str($('.b_p_s').html()));" id="eval_script" /> 
    <?php if($noJx=="true" || isset($_GET["i"])){?>
	<script>
	$(document).ready(function(e) {
        try{
		    	eval($("#eval_script").val());
				tabFunc();
				$("#main .div_d").html(_str($("#main .div_d").html()));
				processVars();
		}
		catch(ee)
		{
			alert(ee);	
		}
    });

    </script>
    <?php } ;?>