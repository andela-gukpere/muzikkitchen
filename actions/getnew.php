<table cellpadding="5"><tr>
<?php
include("../scripts/db.php");

	$limit = intval($_POST["limit"]);

	if(isset($limit))
	{
		$con = new db();$conc = $con->c();
		$i = 0;
		$q  = mysqli_query($conc,"SELECT * FROM users ORDER BY id DESC");
		while($r = mysqli_fetch_array($q))
		{
			$i++;			
			$img = substr($r[7],1,strlen($r[7]));
			echo "<td><a target='_blank' href='".PTH."/$r[0]' title='$r[3]' style='color:#fff;text-shadow:2px #444;'><div style='background:#000 url(".PTH."$img) no-repeat center;' class='smpdiv' ></div></a></td>";
			
			if($i % 15== 0)
			{
				//echo "<tr></tr>";	
			}
			
			if($i==30)
			{
				break;	
			}
		}		
		mysqli_close($con->c());
	}
?>
</tr></table>