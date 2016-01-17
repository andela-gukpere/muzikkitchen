<?php
session_start();
include("../scripts/db.php");
$pid = intval($_REQUEST["pid"]);

if($pid !=0)
{
	$con = new db();
	$r  = $con->fromTable("art","img1,img2,img3","id=$pid");
	$imgfull = "/art/full_".substr($r[2],5,strlen($r[2]));
	exit("({small:'$r[0]',medium:'$r[1]',large:'$r[2]',original:'$imgfull'})");
}

?>