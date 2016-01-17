<?php
session_start();
$main = defined("PTH");
if(!$main)include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$con = new db();$conc = $con->c();;
$uid = $_SESSION["uid"];
?>
 <!--a href="../atom/?ref=<?php echo $user?>" target="_blank" class='rssbtt'><span><img src="../img/mg/rss.png" /></span></a-->
<div>
    <table><tr><td valign="top"><div id="leftcolumn">
    <div id="tabs">
    <ul>
    <li><a href="#inboxm" code="" >inbox</a></li>
    <!--li><a href="#msgnot" code="getnots();" onclick="//tab_click(event)">profile message alerts</a></li--><li><a href="#compose"><span><b style="color:#f88;">+</b> compose</span></a></li>
        </ul>
        <div id="inboxm">
            <div id='inbox_m' runat="server">
            <br /><br /><br /><br /><br /><center> <img alt='please wait' src="../img/load/w.gif" /></center>
            </div>
        </div>
        <!--div id="msgnot">
            <div id="msg_not" class="wp" style="padding:40px 40px 40px 40px;"><br /><br /><br /><br /><br /><center> <img alt='please wait' src="../img/load/w.gif" />             </center></div>
        </div-->
        <div id="compose">
                <table class="wp" style="width:100%;padding:40px 40px 40px 40px;">
                    <tr>
                        <td></td>
                        <td>To : <input type="text" style="text-decoration:underline;" class="txt" onkeyup="_msg_plst(event)" /><div id="divppp" style="margin-left:22px;" class='_plst'> 
							<div align="center">Type Name in search Box Above and select Name here</div>
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" id="txtto"/></td></tr><tr><td></td><td>Subject</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="text" id="txt_subj"class="txt" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><textarea class="txt" id="txtEd" onkeyup="gment(event)" style="height:78px;width:350px;"></textarea><div class="pl2div" style='position:relative'></div></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                           <input type="button" class="button1" value="Send Message" onclick="sendNew()" /></td>
                    </tr>
                </table>
        </div>
    </div>
    <input type="hidden" id="eval_script" value="getInbox();document.title= 'Muzik Kitchen | Messages';processVars();"/>
    </div></td><td valign="top"><div id="rightcolumn"><?php 
	$pth = $main?".":"..";
	 include("$pth/actions/right_column.php") ?></div></td></tr></table>
</div>
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