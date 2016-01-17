<?php
include("../scripts/db.php");
$con = new db();$conc = $con->c();
$id = 101212574;
$date = date("U") - 60 * 60 * 24 * 7;
$q = $con->query("users","id","id <> $id");

while($r = mysqli_fetch_array($q[1]))
{
	$qq = $con->query("follow","id","u1 = $r[0] AND u2 = $id");	
	if($qq[0] == 0)
	{
		$qqq = $con->insertInto("follow",array($r[0],$id,date("U")));		
	}
	$con->close_db_con($qq[2]);
}
echo "done";
$con->close_db_con($q[2]);
?>