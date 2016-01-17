<?php
if(intval($uid) == 0) exit();
$msg_to = strclean($_GET["to"]);
if(!$con){$con = new db();}
$msg_r = $con->query("users","id","user='$msg_to' or id='$msg_to'");
if($msg_r[0]==1)
{
	$msg_rr = mysqli_fetch_array($msg_r[1]);
?>

 <div id="compose" class="scolumn">
                <table class="wp" style="width:100%;padding:40px 40px 40px 40px;">
                    <tr>
                        <td></td> 
                        <td>To : <input type="text" style="text-decoration:underline;"  value="<?php echo $msg_to; ?>"disabled="disabled" class="txt"  />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" id="txtto" value="<?php echo $msg_rr[0] ?>"/></td></tr><tr><td></td><td>Subject</td>
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
        <script language="javascript">$(document).ready(function(e) {
            showLoad(false);
        }); </script>
        <?php
}
else
{
	echo "<div class='m_s_g'>Invalid user</div>";	
}
$con->close_db_con($msg_r[2]);
?>