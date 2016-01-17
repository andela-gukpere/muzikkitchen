<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = $_SESSION["uid"];
$user = $_POST["user"];
$id = $_POST["id"];
$me = $uid;
if(isset($id) && isset($user) && $user!="")
{    
   $con = new db();$conc = $con->c();
   $chk = mysqli_query($conc,"SELECT `id` FROM `open_chat` WHERE `u1` = $me AND `u2`=$user");
   if(mysqli_num_rows($chk) == 0)
   {
     $q =  $con->insertInto("open_chat",array($id,$me,$user,date("U")));
	 echo $q?"yess":"no";
	 echo "$id $user $me";
   }
   // setcookie($id,"__c".$user."_".$id."__c",time()+52*60*60*24*7);
   //setcookie($id,$id."44",time()+(52 * 3600 * 24 * 7 *3));
   mysqli_kill($conc,mysqli_thread_id($con->c()));
   mysqli_close($con->c());
}
exit();
?>