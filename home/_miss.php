<?php
include("../scripts/db.php");
$con = new db();$conc = $con->c();
//101212136
$date = date("U") - 60 * 60 * 24 * 7;
$q = $con->query("online","uid,date","date < $date");
$i = 0;
while($r = mysqli_fetch_array($q[1]))
{
	$i++;
	s_mail("","We miss you here at <a href='http://www.muzikkitchen.com/'>Muzik Kitchen</a><br/><div style='font-size:14px'><b><br/><br/>We miss you! We haven't seen you in a while and wanted to remind you that Muzik Kitchen is still here for you!</b><br/><br/>We look forward to having you back with us! Do let us know if you need any other information by emailing to <a href='mailto:info@muzikkitchen.com'>info@muzikkitchen.com</a></div>",$r[0],$q[2],"We Miss You!!");
	//echo "$r[0] We miss you here at <a href='http://muzikkitchen.com/'>Muzik Kitchen</a><br/><div style='font-size:14px'><b><br/><br/>We miss you! We haven't seen you in a while and wanted to remind you that Muzik Kitchen is still here for you!</b><br/><br/>We look forward to having you back with us! Do let us know if you need any other information by emailing to <a href='mailto:info@muzikkitchen.com'>info@muzikkitchen.com</a></div><br/>";
}
$con->close_db_con($q[2]);
echo $i." sly guys";
?>