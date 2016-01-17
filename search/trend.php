<?php
session_start();
include("../scripts/db.php");
if(!isset($_SESSION["user"],$_SESSION["p"]))
{
	//exit("<div class='m_s_g'>Invalid Authentication<div>");
}

	$con = new db();$conc = $con->c();
	$uid = intval($_SESSION["uid"]);
	$page = intval($_POST["page"]);
	$pp = $page > 0?$page - 1:0;
		
	$search = $_REQUEST["s"];
	if($page == 0)
	{
	?>
    <table width="100%"><tr><td valign="top">
	<div  id="leftcolumn">
   
<?php
echo  "<Div align='center' class='ndiv' style='color:#336699;margin-bottom:10px;font-size:xx-large;' >Search results for <a title='click here to repeat search' href='./#!/trend=$search' onclick='return _st(event,\"$search\")' style='font-size:xx-large;' >&lsquo;<b>$search</b>&rsquo;</a></Div>";
	}
	else
	{
		echo "<div>";	
	}
	$q = mysqli_query($conc,"SELECT `post`.`id`,`post`.`user`,`post`.`post`,`post`.`date`,`users`.`img1`,`users`.`user`,`users`.`name`,`post`.`client`,`post`.`rid`,`post`.`type` FROM post INNER JOIN users ON (`post`.`user` = `users`.`id`) AND (`post`.`post` LIKE '%$search%') ORDER BY `post`.`id` DESC LIMIT $pp, 21");
	$num = mysqli_num_rows($q);
	$date = false;
	echo "<div class='ndiv' id='s_ch'>";
	while($r = mysqli_fetch_array($q))
	{
		$sm = true;
		if($num < 21)
		{
			$sm = false;	
		}
		$date = !$date ?$r[3]:$date;
			$var = "";		
			echo  post($r[0],$uid,$r[1],$r[5],$r[6],$r[4],$r[3],$r[2],$var,$r[8],$r[9],$r[7]);	

	}
	if($num == 0 && $pp == 0)
	{
		echo "<div align='center' class='m_s_g'>No feeds containing &lsquo;<b>$search</b>&rsquo;
  </div>
<br/>
	<div align='center' class='m_s_g'>There are search results for &lsquo;<b>$arg</b>&rsquo;
			</div>
			<div style='padding:10px;'>
			<div style='font-size:large;margin-bottom:30px;border-bottom:1px solid #336699;width:40%;' align='center'>Web Search</div>
					<a href='http://www.bing.com/search?q=".urlencode($search)."&pc=MUZIKK&form=MKKPBL' target='_blank'><li>Bing Search &lsquo;<b>$search</b>&rsquo;</li></a>
					<br/>
		<br/>
				<a href='http://www.google.com.ng/search?sclient=psy&hl=en&site=muzikkitchen.com&source=hp&q=".urlencode($search)."&btnG=Search' target='_blank'><li>Google Search &lsquo;<b>$search</b>&rsquo;</li></a>	
				
					
				</div>
		";
	}
	$total = 20 + $page + 1;
		echo "<input type='hidden' id='last_time' value='$date' />";	
	echo $sm?"<div id='show_more' title='show more' align='center' onclick='_more_st(event,\"$search\",$total)'></div>":"";
	
	$r = NULL;
	echo '</div>';
?>
</div>
<?php
if($page != 0){exit();}
?>
</td>

    
    	<?php if($_SESSION["mobile"] != 2){ 
		?>
        <td valign="top">
        <div id="rightcolumn">
        <?php
		include("../actions/right_column.php"); 
		?>
         </div>
    </td>
		<?php		
		}
		if(!isset($_REQUEST["s"]))
		{
			echo "<script>window.location = '../?search=$search .'</script>";
		}
		?>
   </tr></table>
   
        <input type="hidden" value="document.title= 'Muzik Kitchen | `#<?php echo $search; ?>`';" id="eval_script" /> 