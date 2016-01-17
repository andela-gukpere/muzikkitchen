<?php 
session_start();
include("../scripts/db.php");
$style = "style='font:20px verdana;text-align:center;color:#777;'";
$user = $_SESSION["uid"];
if(!isset($_SESSION["user"],$_SESSION["p"]) && $user != 0)
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}

$con = new db();$conc = $con->c();
if(isset($_POST["del"]))
{
	list($id,$vid,$img) = explode("____",$_POST["vars"]);	

	$q= mysqli_query($conc,"DELETE FROM videos WHERE id = $id AND user = $user");
	$qq= mysqli_query($conc,"DELETE FROM comment WHERE cid = $id AND type = 3");
	if($q)
	{
		@unlink("../video/".$vid);
		if(!strstr($img,DEF_VID_IMG))
		{
			 @unlink("../prev/".$img);
		}
		$con->close_db_con($conc);
		exit("<div $style>Successfully Deleted.</div>");	
	}
	else
	{
		$con->close_db_con($conc);
		exit("<div $style>Error deleting video.</div>");	
	}
	
}
if(isset($_POST["upd"]))
{
	$id = intval($_POST["id"]);
	$name = strclean($_POST["name"]);
	$info = strclean($_POST["info"]);
	$upd = $con->update("videos","name='$name', info ='$info'","id=$id");	
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
	$img = $_FILES["upl"]["tmp_name"];
	$video  = $_FILES["vid"]["tmp_name"];
	if(is_uploaded_file($video) && preg_match('/mp4|avi|mpeg|3gp|mkv|flv|mov/', extension($_FILES["vid"]["name"])))
	{
		$_300x300 = is_uploaded_file($img)?upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],300,300):DEF_VID_IMG;		
		$vid = md5($video." ".date("U")).rand(0,9).extension($_FILES["vid"]["name"]);
		if($_300x300 && copy($video,"../video/$vid"))
		{
			$name = strclean($_POST["name"]);
			$name = strlen($name) < 2 ?$_SESSION["user"]."'s video ".rand(10,999):$name;
			$name = _hstr_($name,false);
			$info = _hstr_($_POST["info"],false);
			$q = $con->insertInto("videos",array($user,$name,$info,$_300x300,$vid,1,date("U"),0));
			if($q)
			{
				$q = mysqli_query($conc,"SELECT id FROM videos WHERE user = '$user' AND name = '$name' AND vid = '$vid'");
				$r = mysqli_fetch_array($q);
				$q = $con->insertInto("hist",array(6,0,$user,$name."::__::__::".$r[0],date("U")));
				$q = NULL;
				$con->close_db_con($conc);
				exit("<div $style>$name has been successfully added.</div>");
			}
			else
			{
				if(is_file("../prev/".$_300x300) && strstr($_300x300,DEF_VID_IMG) < 0)
				{unlink("../prev/".$_300x300);}
				if(is_file("../video/$vid"))
				{unlink("../video/$vid");}
				$con->close_db_con($conc);
				exit("<div $style>Error adding $name</div>");
			}
		}
		else
		{
			if(is_file("../prev/".$_300x300) && strstr($_300x300,DEF_VID_IMG) < 0)
			{unlink("../prev/".$_300x300);}
			if(is_file("../video/$vid"))
			{unlink("../video/$vid");}
			$con->close_db_con($conc);
			exit("<div $style>Error with upload</div>");	
		}
	}
	else
	{
			$con->close_db_con($conc);
		exit("<div $style>Error with upload. Please select a video and a depicting picture.</div>");	
	}	
}
	function upload_pic($img,$img_ext,$img_name,$x,$y)
    {
        $img_name .= strval(rand(0,1000000));
        if(is_uploaded_file($img))
        {
           $f_img = substr($img_ext,-4,4);
           $t_img = substr($img_ext,-3,3);
           $final_ext;
           $img_old;
           if($f_img=="jpeg")
           {
                $img_old = imagecreatefromjpeg($img);
                $final_ext = ".jpg";
				$t = 1;
           }
           else if($t_img=="gif")
           {
               $img_old = imagecreatefromgif($img);
               $final_ext = ".gif";
			   $t = 2;
           }
           else if($t_img=="png")
           {
                 $img_old = imagecreatefrompng($img);
               $final_ext = ".png";
			   $t = 3;
           }
           else
           {
               $img_old = false;
			   $t= false;
           }
           if($img_old && $t)
           {
               list($xx, $yy) = getimagesize($img);
               $newx;
               $newy;
               if($xx < $x && $yy < $y)
               {
                   $newx = $xx;
                   $newy = $yy;
               }
			   else if($xx > $yy)
               {
                   $newx = $x;
                   $newy = intval(($yy / $xx) * $x);
               }
               else
               {
                   $newy = $y;
                   $newx = intval(($xx / $yy) * $y);
               }
               try
               {
                   $new_img = imagecreatetruecolor($newx,$newy);
                  if(!$new_img);
                   {
                      //throw new Exception("could not save");    
                   }
                   imagecopyresampled($new_img,$img_old,0,0,0,0,$newx,$newy,$xx,$yy);
               }
               catch(Exception $err)
               {
                   echo $err->getMessage();
                   return false;
               }
               $mdir = "../prev";
               $new_name = $mdir."/".md5($img_name." ".date("U")).$final_ext;
               if(!is_dir($mdir))
               {
                   mkdir($mdir);
               }
             switch($t)
			  {
				  case 1:
					  if(imagejpeg($new_img,$new_name,100))
					  {
						$p = true;  
					  }
				  break;
					case 2:
						if(imagegif($new_img,$new_name))
						{
							$p = true;	
						}
					break;
					case 3:
						if(imagepng($new_img,$new_name))
						{
							$p = true;	
						}
					break;
					default:
						return false;
					break;
			  }
			  imagedestroy($img_old);
  			  imagedestroy($new_img);
				if($p)
				{
					return md5($img_name." ".date("U")).$final_ext;
				}
				else
				{
					return false;
				}
		   }
		   else
		   {
				return false;   
		   }
        }
		else
		{
			return false;	
		}
  }
?>

<h1 align="center" class="mh1">Add video</h1>
<form method="post" target="frame" action="./actions/videoz.php" enctype="multipart/form-data">
<table cellpadding="3" class="prof_table">
<tr><td>Name</td><td><input type="text" class="txt"  name="name" /></td></tr>
<tr><td>Info</td><td><textarea class="txt"  name="info" onkeyup="gment(event)" ></textarea><div class="pl2div" style='position:relative'></div></td></tr>
<tr><td>Video<br/>(MP4 preferred)</td><td><input type="file" class="button1"  name="vid" /></td></tr>
<tr><td>Video Preview<br/><i style="font:10px Verdana;">(a picture showing a<Br/>preview of the video<br/> its should be &lt;1MB)</i></td><td><input type="file" class="button1"  name="upl" /></td></tr>
<tr><td></td><td><input type="submit" class="button1"  name="add" value="Upload" onclick="ifr_done(3)" /></td></tr>
</table>
</form>

<h1 align="center" class="mh1">Edit videos</h1>

<div id="v_edit">
<table cellpadding="5" class="prof_table">
<tr>
<?php
	$q = mysqli_query($conc,"SELECT `id`,`name`,`vid`,`pict`,`info` FROM videos WHERE user = $user ORDER BY date DESC");
	$i = 0;
	if(mysqli_num_rows($q) == 0)
	{
				echo "<td class='m_s_g' align='center' style='padding:50px;'>No Content added yet.</td>";	
	}
	while($r = mysqli_fetch_array($q))
	{
		$i++;
		echo xtra_space("<td><div style='background:url(".PTH."/prev/$r[3]) left;' class='vid_prev' value='$r[1]'  title='$r[4]' onclick='edit_content(3,$r[0],\"v_info_$r[0]\")'>$r[1]<br/>$r[4]</div><div class='_hd' id='v_info_$r[0]'>$r[0]____$r[2]____$r[3]____$r[1]____$r[4]</div></td>");
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
