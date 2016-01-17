<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}    
$uid = intval($_SESSION["uid"]);
if($uid != 0 && isset($uid))
{
    $con = new db();$conc = $con->c();
    $num = 0;
    $subjres = mysqli_query($conc,"SELECT `id` FROM `msg_subj` WHERE `u1` = $uid OR `u2` = $uid");
    if($subjres)
    {
        while($sb = mysqli_fetch_array($subjres))
        {
            $msg = mysqli_query($conc,"SELECT `new`,`uid` FROM `msg` WHERE `new` = 1 AND `cid` = ".$sb[0]." ORDER BY `id` DESC");
            if($msg)
            {
                $ltv = mysqli_fetch_array($msg);
                $numr = mysqli_num_rows($msg);
                if($numr > 0 && $ltv[1] != $uid)
                {
                    $num = $num + $numr;
                }
            }
        }
    }
	$num = $num > 0?$num:"";	
	$subjres = NULL;
	$sb = NULL;
	echo $num;
	$_SESSION["msg_num"] = $num;
}

mysqli_kill($conc,mysqli_thread_id($con->c()));
mysqli_close($con->c());
exit();
?>