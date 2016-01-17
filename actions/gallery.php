<?php 
session_start();
include("../scripts/db.php");
$uid = intval($_SESSION["uid"]);
if(!isset($_SESSION["user"],$_SESSION["p"]) && $uid != 0)
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$con = new db();$conc = $con->c();
$style = "style='font:20px verdana;text-align:center;color:#777;'";
if(isset($_POST["del"]))
{
	list($id,$img1,$img2,$img3) = explode("____",$_POST["vars"]);	

	if($id)
	{
		$q= mysqli_query($conc,"DELETE FROM art WHERE id = $id AND user = $uid");
		$qq= mysqli_query($conc,"DELETE FROM comment WHERE cid = $id AND type = 1");
		if($q && $qq)
		{
			unlink("..".$img1); unlink("..".$img2) ; unlink("..".$img3) ; unlink("../art/full_".substr($img3,5,strlen($img3)));
		}
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
	$upd = $con->update("art","name='$name', info ='$info'","id=$id");	
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
	if(is_uploaded_file($img))
	{
		$_50x50 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],50,50);
		$_100x100 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],100,100);
		$_300x300 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],500,400);
		if($_50x50 && $_100x100 && $_300x300)
		{
			$_big = "../art/full_".substr($_300x300,5,strlen($_300x300));
			copy($img,$_big);
			$name = ($_POST["name"]);
			$name = strlen($name) < 2 ?$_SESSION["user"]."'s art ".rand(10,999):$name;
			$name = _hstr_($name,false);
			$info = _hstr_($_POST["info"],false);
			$q = $con->insertInto("art",array($uid,$name,$info,$_50x50,$_100x100,$_300x300,date("U"),0));
			if($q)
			{
				$q = mysqli_query($conc,"SELECT id FROM art WHERE user = '$uid' AND name = '$name' AND img1 = '$_50x50'");
				$r = mysqli_fetch_array($q);
				$q = $con->insertInto("hist",array(4,0,$uid,$name."::__::__::".$r[0],date("U")));
				$q = NULL;
					$con->close_db_con($conc);
					if(isset($_POST["quick"])){
						
					exit("<script>parent.document.getElementById('txtdiv').value += '[art:$r[0] ]';parent.window.uploading(false);</script>");
						
					}
				exit("<div $style>$name has been successfully added. </div>");
			}
			else
			{
				unlink($_50x50);
				unlink($_100x100);
				unlink($_300x300);
				unlink($_big);
				$con->close_db_con($conc);
				exit("<div $style>Error adding $name</div>");
			}
		}
		else
		{
			if(is_file($_50x50)){
			unlink($_50x50);}
			
			if(is_file($_300x300)){
			unlink($_300x300);}
			
			if(is_file($_100x100)){
			unlink($_100x100);}
	$con->close_db_con($conc);
			exit("<div $style>Error with image upload</div>");	
		}
	}
	else
	{
			$con->close_db_con($conc);
		exit("<div $style>No file uploaded</div>");		
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
               $mdir = "../art";
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
					return str_replace("..","",$new_name);
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
<h1 align="center" class="mh1">Add picture</h1>
<form method="post" target="frame" action="<?php echo PTH; ?>/actions/gallery.php" enctype="multipart/form-data">
<table class="prof_table">
<tr><td>Name</td><td><input type="text" class="txt"  name="name" /></td></tr>
<tr><td>Info</td><td><textarea class="txt"  name="info" onkeyup="gment(event)" ></textarea><div class="pl2div" style="top:280px;"></div></td></tr>
<tr><td>Picture</td><td><input type="file" class="button1"  name="upl" /></td></tr>
<tr><td></td><td><input type="submit" class="button1"  name="add" value="Submit" onclick="ifr_done(1)" /></td></tr>
</table>
</form>
<h1 class="mh1" align="center">Edit picture</h1>

<div id="a_edit">
<table class="prof_table" >
<tr>
<?php
	$con = new db();$conc = $con->c();
	$q = mysqli_query($conc,"SELECT `id`,`name`,`img1`,`info`,`img2`,`img3` FROM art WHERE user = '$uid' ORDER BY date DESC");
	$i=0;
	if(mysqli_num_rows($q) == 0)
	{
				echo "<td class='m_s_g' align='center' style='padding:50px;'>No Content added yet.</td>";	
	}
	while($r = mysqli_fetch_array($q))
	{
		$i++;
		echo xtra_space("<td><input type='image' src='".PTH."$r[2]'  value='$r[1]' title='$r[3]' onclick='edit_content(1,$r[0],\"p_info_$r[0]\")' /><div id='p_info_$r[0]' class='_hd'>$r[0]____$r[2]____$r[4]____$r[5]____$r[1]____$r[3]</div></td>");
		if($i % 8 == 0)
		{
			echo "</tr><tr>";	
		}
	}

?>
</tr>

</table> 
</div>