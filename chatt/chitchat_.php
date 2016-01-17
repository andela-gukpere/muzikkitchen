<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$uid = intval($_SESSION["uid"]);
$id = $_POST["id"];
if(isset($id))
{
    $con = new db();$conc = $con->c();
    $qu = mysqli_query($conc,"SELECT `chat`.`id`,`chat`.`u1`,`chat`.`u2`,`users`.`id`,`users`.`user`,`users`.`img1`,`users`.`bgcolor` FROM chat INNER JOIN `users` ON (`chat`.`u1` = `users`.`id` OR `chat`.`u2` = `users`.`id`) WHERE ((`chat`.`u1` = $uid AND `chat`.`u2` = `users`.`id`) OR (`chat`.`u2` = $uid AND `chat`.`u1` = `users`.`id`))  AND `chat`.`id` = $id");
   $qua = mysqli_fetch_array($qu);
					$em = $qua[3];
					//$u = array($qua[3],$qua[4],$qua[5]);
				//			$u = user($conc,"`user`,`img1`",$em);
    			$pname = $qua[4];
    				echo "<div style='width:100%;font-size:10px;'><div id='drag_div_$id' class='drg_div' style='background-color:".$color_array[$qua[6]]." !important;' color='".$color_array[$qua[6]]."'><table ><tr><td><a href='./$pname' onclick='return _pop(event,$em)' ><div class='ssmpdiv' style='background:url(".PTH."$qua[5]) no-repeat top left;' ></div></a></td><td><a href='./$em' class='_mn_' onclick='return _pop(event,$em)'>$pname</a> <span id='o$id' style='color:#888;font-size:9px;'></span><br/><input type='image' onclick='cchat($id)' class='hand' title='Clear chat history'  src='./img/mg/cl.png'/> <input type='image' src='./img/mg/opn.png' onclick='_locChat(event,false,$id)' title='Enable dragging of this window' style='display:none;' class='hand'/>$qua[7]</td></tr></table></div></div><div id='chat$id' class='cc_div'></div>";
		
	
    
	$con->close_db_con($conc);
}
exit();
?>
