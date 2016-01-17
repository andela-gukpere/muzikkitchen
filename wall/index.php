<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"])|| !isset($_SESSION["user"]))
{
	//print_r($_SESSION);
		exit("<br/><div class='m_s_g'>Invalid Authentication<div>");
}
$owner = $_POST["owner"];

$me = $_SESSION["user"];

$uid = $_SESSION["uid"];
$owner = $uid;//strlen($owner) > 0?$owner:
$is_me = true;
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,name,loc,img1,img2,img3,web,date,tz,bio,user,np FROM users WHERE id = $uid");
if(mysqli_num_rows($q) == 0)
{
	$con->close_db_con($conc);
	exit("<div class='m_s_g'>This user does not exist $owner $user</div>");	
}
$r = mysqli_fetch_array($q);
?>
<table  ><tr><td valign="top">
	<div id="leftcolumn">
    <table  class="ndiv" cellpadding="15" width="630px"><tr><td valign="top" width="100%"><b>225</b><br/><textarea contenteditable="true"  placeholder="What's Cooking?" spellcheck="true" onblur="if(value.length < 50)$(this).animate({height:'16px'},250);" onfocus="$(this).animate({height:'60px'},250);" onkeydown="" onkeyup="gment(event);fixlength(event);" id="txtdiv"></textarea><div class="pl2div" style="top:180px;"></div><br/><input type="button" class="button1" value="Add Media" onclick="get_media(event);" style="float:left;" /> <input type="button" value="Feed" onclick="_post(event)" name="post" class="button1" style="float:right;" /><form enctype="multipart/form-data" action="./actions/gallery.php" method="post" target="mframe"  style="float:left;">
    <input type="hidden" name="add" value="1" /><input type="hidden" name="quick" value="1" />
     <label for="upl" ><input type="file" id="upl" value="Upload pic" class="hdd_upl"title="attach image" name="upl" onchange="submit();uploading(true);_$('txtdiv').disabled=true;" /><div 
 onclick="if(navigator.userAgent.toString().indexOf('Firefox')>-1)$('#upl').click();
 "    id="upldiv" class="button1" title="select 'n' upload photo"></div></label>  </form></td></tr></table><iframe  onload="_$('txtdiv').disabled=false;" name="mframe" style="display:none;" height="0" width="0" frameborder="0"></iframe>
        <br/>
        <div id="tabs" >

        	<ul>
            	<li><a href="#main" id='_main_' code="tab_click(null,'main.php?code=2')"  onclick="tab_click(event,'main.php?code=2')">My Table</a></li>
	          	<li><a href="#mention"code="" onclick="tab_click(event,'mention.php?code=4')">Mentions</a></li>
   	          	<li><a href="#reposts"code="" onclick="tab_click(event,'reposts.php')">Refeeds</a></li>
               <li><a href="#plate" code="" title="double click to referesh" onclick="tab_vclick(event,'plate.php');platetab()">My plate </a><div  class="num" style="left:0px;"><span id="_platen" style="background-color:#fff;padding: 0 2px 0px 0;"></span></div></li>                
             	<li><a href="#gallery" code="" onclick="tab_vclick(event,'view.php?type=0')">Gallery</a></li>
            	<li><a href="#muzik" code=""  onclick="tab_vclick(event,'view.php?type=1')">Music</a></li>
              	<li><a href="#videoz" code="" onclick="tab_vclick(event,'view.php?type=2')">Videos</a></li>

              	<!--li><a href="#vote" code="" onclick="tab_vclick(event,'vote.php?type=2')">Voting and Polls</a></li-->                
            </ul>
            
            <div id="main" "><div class="div_d"> 
            </div>
				
            </div>
            
            <div id="mention"><div class="div_d">  
            </div>
            
            </div>

            <div id="reposts"><div class="div_d"> 
            </div>            

            </div>
            
            
            <div id="plate"><div class="div_d">
            </div>            

            </div>
            
            <div id="gallery"><div class="div_d">  
            </div>
            
            </div>
                        
            <div id="muzik"><div class="div_d">  </div>

            </div>
            
            <div id="videoz"><div class="div_d">  </div>
            </div>
            
            <div id="vote"><div class="div_d"></div>
            </div>
        </div>
     </div>
    </td><td valign="top">
    <div id="rightcolumn">
    	<?php include("../actions/right_column.php"); ?>
        
    </div>
    </td></tr></table>
<input type="hidden" id="owner" value="<?php echo $owner; ?>"/>
    <input type="hidden" value="document.title = 'Muzik Kitchen | <?php echo $_SESSION["user"]; ?>';" id="eval_script" />