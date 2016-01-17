<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
    
$uid = $_SESSION["uid"];
if($uid)
{

    $con = new db();
	$conc = $con->c();
    $qq = mysqli_query($conc,"SELECT * FROM `msg_subj` WHERE `u1` = '$uid' OR `u2` ='$uid' ORDER BY `id` DESC");
    if($qq)
    {
        $result = "<div class='wp'><div style='width:550px;margin-left:10px;padding:30px 35px 35px 35px;'><table style='width:100%;'>";
        $numr = mysqli_num_rows($qq);
        if($numr==0)
		{
		    die("<center class='m_s_g'><i>You have no messages in your inbox</i></center>");
		}
        while($inf = mysqli_fetch_assoc($qq))
        {
            $chknew = mysqli_query($conc,"SELECT `id`,`uid` FROM `msg` WHERE `cid` = ".$inf["id"]." AND `new`=1 ORDER BY `id` DESC ");
            $num = mysqli_num_rows($chknew);
            $ltv = mysqli_fetch_array($chknew);
            if($num > 0 && $ltv[1] != $uid)
            {
                $style = "style='background-color:".$color_array[intval($_SESSION["color"])].";color:#fff;'";
                $newm = "<img src='./img/mg/ne.png' />";
            }
            else
            {
                $style = '';
                $newm = "<img src='".PTH."/img/mg/min.png' />";
            }
            $em = ($inf["u1"] == $uid)?$inf["u2"]:$inf["u1"];
			$u = user($conc,"user,img1",$em);
            $flname = "$u[0]";
            $vart = gtime($inf["date"]);
            $result .= "<tr><td><a class='inb_a' href='#' onclick='shwmsg(".$inf["id"].")'><span><table class='inb' $style><tr><td>$newm</td><td style='width:100px;'><div class='smpdiv' style='background:url(".PTH."$u[1]) no-repeat top left;' ></div></td><td style='width:400px;'><a href='./$em' target='_new' >$flname</a><br />".$inf["subj"]."<br/><span class='tt'>".$vart."</span></td></tr></table></span></a></td><td style='width:100px;'><a href='#'class='del' onclick='delconv(".$inf["id"].",event)'><div class='delete' title='delete'></div></td></tr>";
       }
        $result .= "</table></div></div>";
    }
   
    echo $result;
	$con->close_db_con($conc);
}

exit();
?>