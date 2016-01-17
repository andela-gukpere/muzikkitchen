<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
//$owner = $_POST["owner"];
$uid = $_SESSION["uid"];

$id= $_POST["id"];

if(isset($id))
{
    $con = new db();$conc = $con->c();
    $delsubj = mysqli_query($conc,"DELETE FROM `msg_subj` WHERE (u1 = $uid OR u2 = $uid ) AND `id` = $id");
    if($delsubj)
    {
        $delmsgs = mysqli_query($conc,"DELETE FROM `msg` WHERE `cid` = $id");
        if($delmsgs)
        {
            echo "Conversation Deleted !";
        }
        else
        {
            echo "Error Occured";
        }
    
    }
	else
	{
		echo "Error Deleting conversation";	
	}
    mysqli_kill($conc,mysqli_thread_id($con->c()));
	mysqli_close($con->c());
}
else
{
	echo "Please repeat delete process<br/>Error Occured";	
}
exit();
?>