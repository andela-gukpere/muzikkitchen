<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["uid"],$_SESSION["user"]))
{
		exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$uid = $_SESSION["uid"];
function strfix ($input)
{
    $input = str_replace(" ","",$input);
    $input = str_replace("_","",$input);
    $input = str_replace("<","",$input);
    $input = str_replace(">","",$input);
    $input = str_replace("'","",$input);
    $input = str_replace(";","",$input);
    $input = str_replace("-","",$input);
    $input = str_replace("/","",$input);
    $input = str_replace(":","",$input);
    $input = str_replace("=","",$input);
	$input = str_replace("tr","",$input);
	$input = str_replace("td","",$input);
    return $input;
}
    $con   = new db();
	$conc = $con->c();
    $pals = mysqli_query($conc,"SELECT `id`,`u1`,`u2` FROM `chat` WHERE `u1`=$uid or `u2`=$uid ");
    if($pals)
    {
        while($pal = mysqli_fetch_array($pals))
        {
            $em = $pal[1]==$uid?$pal[2]:$pal[1];
			$id = trim($pal[0]);
			$file = "../chatt/room/$id.dat";
			if(is_file($file))
			{
				$cf = fopen($file,"r");
				$conte = fread($cf,filesize($file));
				$chh = strfix($conte);
				$intv = strlen($chh);
				echo $em.":$intv=".$id."__::__";
			}
			else
			{
				echo $em.":0=".$id."__::__";
			}
        }
    }
    mysqli_kill($conc,mysqli_thread_id($con->c()));
mysqli_close($con->c());
exit();
?>