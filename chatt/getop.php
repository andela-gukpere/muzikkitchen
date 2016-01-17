<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$uid = intval($_SESSION["uid"]);
    $con = new db();$conc = $con->c();
    $chk = mysqli_query($conc,"SELECT `u2`,`cid` FROM `open_chat` WHERE `u1` = $uid");
    if($chk)
    {
        while($res = mysqli_fetch_array($chk))
        {
            echo "__c".$res[0]."_".$res[1];
        }
    }
    $con->close_db_con($conc);
exit();
?>
    