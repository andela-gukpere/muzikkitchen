<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];

$id = $_POST["cid"];
if(isset($id))
{
    $con = new db();$conc = $con->c();
    $delmsg = mysqli_query($conc,"DELETE FROM `msg` WHERE `id` = $id AND `uid` = $uid");
    if($delmsg)
    {
        echo "The message has been deleted";
    }
    else
    {
        echo "Error deleting message";
    }
    mysqli_kill($conc,mysqli_thread_id($con->c()));
mysqli_close($con->c());
}
exit();
?>