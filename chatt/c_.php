<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

		$uid = intval($_SESSION["uid"]);
		$id = $_POST["id"];
		echo "<table class='cc_tabl'>";
		$id = trim($id);
		$file = "../chatt/room/$id.dat";
		if(is_file($file))
		{
			$cfile = fopen($file,"r");
			while($cont = fread($cfile,1024))
			{
				echo $cont;	
			}		
		}
		else
		{
			echo "<th><td><center style='margin-top:50px;font-size:18px;'><i>No chat history</i></center></td></th>";
		}
		echo "</table><input type='text'id='_zp$id' class='_zp'/>";
?>