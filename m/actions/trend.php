<?php
session_start();
require_once("../../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	//exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$con = new db();$conc = $con->c();
	$page = intval($_POST["page"]);
	$pp = $page > 0?$page - 1:0;
	$uid = intval($_SESSION["uid"]);
	$search = $_REQUEST["str"];
	?>
      <div id="m_t_b">
   
<?php
echo $page ==0? "<a href='../home/?str=$search#trend' onclick='return _st(event,\"$search\")' style='font-size:30px;'>'#$search'</a>":"";
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) AND (`post`.`post` LIKE '%$search%') ORDER BY `post`.`id` DESC LIMIT $pp,21");
	$num = mysqli_num_rows($q);
	while($r = mysqli_fetch_array($q))
	{
		$sm = true;
		if($num < 20)
		{
			$sm = false;	
		}
			$var = "";		
			echo  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);	

	}
	$total = 20 + $page + 1;

	echo "<input type='hidden' id='last_time' value='".date("U")."' />";	
	echo $sm?"<div id='show_more' align='center' onclick='_more_st(event,\"$search\",$total)'></div>":"";
	$con->close_db_con($conc);
	$r = NULL;
?>
</div>
<script>
try{
	
	$("#m_t_b").html(_str($("#m_t_b").html()));
}
catch(_userless)
{
	
}
</script>