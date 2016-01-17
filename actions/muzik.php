<?php 
session_start();
include("../scripts/db.php");
$user = intval($_SESSION["uid"]);
if(!isset($_SESSION["user"],$_SESSION["p"]) && $user != 0)
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$con = new db();$conc = $con->c();
$style = "style='font:20px verdana;text-align:center;color:#777;'";
if(isset($_POST["del"]))
{
	list($id,$mp3,$owner) = explode("____",$_POST["vars"]);	
	$q= mysqli_query($conc,"DELETE FROM music WHERE id = $id AND user = $user");
	$qq= mysqli_query($conc,"DELETE FROM comment WHERE cid = $id AND type = 2");
	if($owner == 1){unlink("../music/".$mp3);}
	if($q)
	{		
		$con->close_db_con($conc);
		exit("<div $style>Successfully Deleted.</div>");	
	}
	else
	{
		$con->close_db_con($conc);
		exit("<div $style>Incomplete Deletion</div>");	
	}
	
}

if(isset($_POST["upd"]))
{
	$id = intval($_POST["id"]);
	$name = strclean($_POST["name"]);
	$info = strclean($_POST["info"]);
	$upd = $con->update("music","name='$name', info ='$info'","id=$id");	
	if($upd)
	{
		exit("<div $style>Successfully updated $name</div>");	
	}
	else
	{
		exit("<div $style>Error updating $name</div>");	
	}
}
if(isset($_POST["add"]))
{
	$music = $_FILES["mp3"]["tmp_name"];	
	if(is_uploaded_file($music))
	{
		$type = extension($_FILES["mp3"]["name"]);
		if($type!= ".mp3" && $_FILES["mp3"]["type"] != "audio/mpeg")
		{
			exit("<div $style>".$_FILES["mp3"]["type"]."'$type' formats are not supoorted, please upload mp3 only</div>");	
		}
		$mp3 = md5($music." ".date("U")).rand(0,9).$type;
		$cp = copy($music,"../music/$mp3");
		if($cp)
		{
			$name = ($_POST["name"]);
			$name = strlen($name) < 2 ?$_SESSION["user"]."'s music-".rand(10,999):$name;
			$name = _hstr_($name,false);
			$info = _hstr_($_POST["info"],false);
			$q = $con->insertInto("music",array($user,$name,$info,$mp3,1,date("U"),0));
			if($q)
			{
				$q = mysqli_query($conc,"SELECT id FROM music WHERE user = '$user' AND name = '$name' AND mp3 = '$mp3'");
				$r = mysqli_fetch_array($q);
				$q = $con->insertInto("hist",array(5,0,$user,$name."::__::__::".$r[0],date("U")));
				$q = NULL;
				$con->close_db_con($conc);
				exit("<div $style>$name has been successfully added.</div>");
			}
			else
			{
				$con->close_db_con($conc);
				unlink("../music/$mp3");
				exit("<div $style>Error adding $name</div>");
			}
		}
		else
		{
			$con->close_db_con($conc);
			exit("<div $style>Error with muzik upload</div>");	
		}
	}
	else
	{
		$con->close_db_con($conc);
		exit ("<div $style>No file uploaded</div>");
	}
}
?>
<h1 align="center" class="mh1">Add music</h1>
<form method="post" target="frame" action="<?php echo PTH; ?>/actions/muzik.php" enctype="multipart/form-data">
<table cellpadding="10" class="prof_table">
<tr><td>Name</td><td><input type="text" class="txt"  name="name" /></td></tr>
<tr><td>Info</td><td><textarea class="txt"  name="info" onkeyup="gment(event)" ></textarea><div class="pl2div" style="top:280px;"></div></td></tr>
<tr><td>Music File<Br/>(MP3 preferred)</td><td><input type="file" class="button1"  name="mp3" /></td></tr>
<tr><td></td><td><input type="submit" class="button1"  name="add" value="Submit" onclick="ifr_done(2)" /></td></tr>
</table>
</form>

<h1 class="mh1" align="center">Edit music</h1>

<div id="m_edit" >
<table class="prof_table">
<tr>
<?php
	$q = mysqli_query($conc,"SELECT `id`,`name`,`mp3`,`info` FROM music WHERE user = $user ORDER BY date DESC");
	$i=0;
	if(mysqli_num_rows($q) == 0)
	{
		echo "<td class='m_s_g' align='center' style='padding:30px;'>No Content added yet.</td>";	
	}
	while($r = mysqli_fetch_array($q))
	{
		
		$i++;//title='$r[3]'
		echo xtra_space("<td><div align='center' class='music_m'  style='font-size:12px;'  
		onclick='edit_content(2,$r[0],\"m_info_$r[0]\");' >$r[1]</div><div class='_hd' id='m_info_$r[0]'>$r[0]____$r[2]____$r[1]____$r[3]</div></td>");
		if($i % 4 == 0)
		{
			echo "</tr><tr>";	
		}
	}
$con->close_db_con($conc);
?>
</tr>

</table> 
</div>