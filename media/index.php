<?php
session_start();
$main = defined("PTH");
if(!$main)include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = intval($_SESSION["uid"]);
$owner = $uid;
$me = $_SESSION["user"];
$is_me = true;//$owner == $me?true:false;
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,name,loc,img1,img2,img3,web,date,tz,bio FROM users WHERE id = '$owner'");
if(mysqli_num_rows($q) == 0)
{
	$con->close_db_con($conc);
	exit("<div class='m_s_g'>This user does not exist $owner $user</div>");	
}
$r = mysqli_fetch_array($q);
?>
<table><tr><td valign="top">
	<div id="leftcolumn">
    <!--table cellpadding="10"><tr><td valign="top">
    <div class="profilepic" style="background:url(<?php echo $r[4]; ?>) center;" onmouseover="anim(event)" onmouseout="anim2(event)"></div></td><td valign="top"><div contenteditable="true" id="txtdiv"></div><br/><input type="button" value="POST" onclick="" name="post" class="button1" style="float:right;" /></td></tr></table-->
        <br/>
        <div id="tabs">
                	<ul>
            	<li><a href="#gallery" code="" onclick="tab_click(event,'gallery.php');" ondblclick="alert(this)">Gallery</a></li>
            	<li><a href="#muzik" code=""  onclick="tab_click(event,'muzik.php');">Music</a></li>
              	<li><a href="#videoz" code="" onclick="tab_click(event,'videoz.php');">Videos</a></li>
            </ul>
            <iframe name="frame" id="frame" width="100%" height="70" align="middle" src=""class="ifr"  allowtransparency></iframe>
                <div id="gallery" style="padding:0 15px 0 15px !important; background-color:transparent !important;"><div class="div_d"></div>
                </div>
            
                <div id="muzik" style="padding:0 15px 015px !important;background-color:transparent !important;"><div class="div_d"></div>
                </div>
                            
                <div id="videoz" style="padding:0 15px 0 15px !important;background-color:transparent !important;"><div class="div_d"></div>
                </div>
          
        </div>
        
    </div>
    </td><td valign="top">
    <div id="rightcolumn">
        	<?php if(!$main)$incp = "..";else ".";include("$incp/actions/right_column.php") ?>
    	</div>
    </td></tr></table>
    <input type="hidden" value="document.title= 'Muzik Kitchen | Media Manager';" id="eval_script" /> 
    <?php if($main){?>
    <script language="javascript">
		try
		{
			$(document).ready(function (){
			eval(document.getElementById("eval_script").value);
			tabFunc();
			processVars();
			});
		}
		catch(ev)
		{
			alert(ev);
		}
	</script>
    <?php }?>