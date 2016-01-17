<?php
include('../scripts/db.php');
session_start();
if(!isset($_SESSION["user"]))
{
	exit("<div class='m_s_g'>Invalid Authentication<div>");
}
$uid = intval($_SESSION["uid"]);
$u = $_POST["uid"]; 
 function mvcp($img,$h,$w,$user,$img_ext)
  {
	   $f_img = substr($img_ext,-4,4);
	   $t_img = substr($img_ext,-3,3);
	   $final_ext;
	   $image = false;
	   if($f_img=="jpeg")
	   {
			$image = imagecreatefromjpeg($img);
			$final_ext = ".jpg";
			$t = 1;
	   }
	   else if($t_img=="gif")
	   {
		   $image = imagecreatefromgif($img);
		   $final_ext = ".gif";
		   $t = 2;
	   }
	   else if($t_img=="png")
	   {
			$image = imagecreatefrompng($img);
		   $final_ext = ".png";
		   $t = 3;
	   }
	   else
	   {
		   $img_old = false;
		   $t= false;
	   }
	if(!$image)return array("false","invalid image file");
	$filename= $img;
	list($ww,$hh) = getimagesize($filename);
	if($ww < 630 && $ww < $hh) return array(false,"Invalid image dimensions <I>it should be @ least 630 pixels width and 320 pixels high and the width must be greater than the height</i>");
  
	$y = intval(($hh / $ww) * 630);
   
	$crop = imagecreatetruecolor(630,320);
	//$y = $hh - $h;
	//$x = ($ww - $w)/ 2;
	imagecopyresampled($crop, $image, 0, 0,0,0,630,$y,$ww,$hh);
//	imagecopy($crop, $image, 0, 0, 0, 0,$ww,$hh);
	$newn= "/profile_bg/bg-$user".$final_ext;
	$fi = false;
	switch ($t)
	{
		case 1:
		$fi = imagejpeg($crop,"..".$newn,100);
		break;
		case 2:
		$fi = imagegif($crop,"..".$newn);
		break;
		case 3:
		$fi = imagepng($crop,"..".$newn);
		break;
		default:
		$fi=false;
	}
	//imagedestroy($image);
	//imagedestroy($crop);
	if(!$fi)
	{
		return array("false","Error saving picture");	
	}	
	return array("true",$newn);
  }
  $img = $_FILES["upl"]["tmp_name"];
  if(isset($_POST["bgimg"]) && is_uploaded_file($img))
  {
		$fa = array();
		$bg = (array)(mvcp($img,320,630,uniqid($uid."-"),$_FILES["upl"]["type"]));	  	
		if($bg[0])
		{
			$con=new db();
			$r = $con->fromTable("users","bg","id=$uid");
			if(strlen($r[0]) > 5 && !stristr($r[0],"default"))@unlink("..".$r[0]);
			$st = $bg[1];
			
			$q = $con->update("users","bg='$st'","id=$uid");	
			if($q)
			{
				echo "<script>
				parent._$('prof_table').style.backgroundImage = '';
				parent.$('.prof_table').fadeTo(200,0.5,function(){
					parent.$('.prof_table').fadeTo(500,1);
					parent._$('prof_table').style.backgroundImage = 'url(".PTH."$st)';
					});

				</script>";
			}
			else
			{
				$msg = "$bg[0]:DB Error";	
			}
		}
		$msg = $bg[0]?"Background changed":$bg[1];
		echo "<script>parent.$('#upltxt').fadeIn('slow',function(){});parent.$('#upltxt').html('$msg');parent.window.uploading(false);</script>";
  }
  else
  {
		echo "error";  
  }
?>