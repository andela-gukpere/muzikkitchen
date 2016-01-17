<div id="m_t_b">
<?php
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$con = new db();$conc = $con->c();
	$uid = intval($_SESSION["uid"]);
	$id = intval($_GET["view"]);
	$type = intval($_GET["type"]);
	if($type == 0)
	{
		$query = "(`post`.`id` = $id OR `post`.`rid` = $id)";
	}
	else if($type == 1)
	{
		$query = "(`post`.`id` = $id) OR (`post`.`rid` = $id AND `post`.`type` = $type)";
	}
	else if ($type == 2)
	{
		$query = "(`post`.`id` = $id) OR (`post`.`rid` = $id AND `post`.`type` = $type)";
	}
	else
	{
		$con->close_db_con($conc);
		exit();	
	}
	
	$owner = intval($_POST["owner"]) == 0?$uid:intval($_POST["owner"]);
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) WHERE $query ORDER BY `post`.`id` DESC");
	echo "<input type='hidden' id='last_time' value='".date("U")."' />";	
	while($r = mysqli_fetch_array($q))
	{
			$var = "";	
			echo  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);	
	}
	if(mysqli_num_rows($q) == 0)
	{
		echo "<span class='m_s_g'>This post is no longer available</span>";
	}
	$con->close_db_con($conc);
?>
</div>
<script>
$("#m_t_b").html(_str($("#m_t_b").html()));
</script>