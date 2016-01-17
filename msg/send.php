<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
    
$uid = $_SESSION["uid"];
$msg = _hstr_($_POST["msg"],false);
$subj = strclean($_POST["subj"]);
$to = $_POST["u2"];
$id  = $_POST["id"];

if(isset($msg) && $msg!="")
{
    if($uid == $to)
    {
        die("You cannot send a message to yourself");
        exit;
    }
    $con = new db();$conc = $con->c();
    if(isset($subj) && !isset($id) && isset($to) && $to !="")
    {
        if($subj == "")
        {
            $subj = "No Subject";
        }
       
        $qq = mysqli_query($conc,"INSERT INTO `msg_subj` VALUES(NULL,'$uid','$to','$subj','".date("U")."')");
        $getid  = mysqli_query($conc,"SELECT `id` FROM `msg_subj` WHERE `u1` = '$uid' AND `u2`='$to' AND `subj` = '$subj'");
        $nid = mysqli_fetch_array($getid);
        if($getid && $qq)
        {
            sendmsg($conc,$nid[0],$uid,$to,$msg);
        }
        else
        {
            echo 2;
        }
    }
    else if(isset($id))
    {
        echo $id;
        sendmsg($conc,$id,$uid,$to,$msg);
    }
    mysqli_kill($conc,mysqli_thread_id($con->c()));
mysqli_close($con->c());
	exit();
}
else
{
    echo "You message did not meet up with certain requirements!<br/>Select a user and type text!";
}
function sendmsg($conc,$mid,$uid,$to,$msg)
{
    $mq = mysqli_query($conc,"INSERT INTO `msg` VALUES(NULL ,$mid,1,'$uid','$msg','".date("U")."')");
    if($mq)
    {
		s_mail($_SESSION["user"]," sent you a <a href='http://muzikkitchen.com/#!/msg/'>Message</a><br/><div style='font-size:14px'><b><br/><br/>$msg</b></div>",$to,$conc,"sent you a message");
		if($_SESSION["mobile"] == 2)
		{		
			echo $mid;
		}
		else
		echo 1;//"<center><b>Message wast sent</b></center>";
    }
    else
    {
        echo 2;//"Error sending message";
    }
}
exit();
?>