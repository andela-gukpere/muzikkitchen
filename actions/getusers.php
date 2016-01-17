<table cellpadding="5"><tr>
<?php
include("../scripts/db.php");

	$limit = intval($_POST["limit"]);

	if(isset($limit))
	{
		$con = new db();$conc = $con->c();
		$i = 0;
		$q  = mysqli_query($conc,"SELECT * FROM prof LIMIT 0 , $limit");
		while($r = mysqli_fetch_array($q))
		{
			$i++;
			echo "<td><a href='".PTH."/$r[1]' title='$r[3]'><div style='background:#000 url(".PTH."$r[4]) no-repeat center;' class='mpd'>$r[3]</div></a></td>";
			if($i % 3== 0)
			{
				echo "<tr></tr>";	
			}
		}		
		mysqli_close($con->c());
	}
?>
</tr></table>