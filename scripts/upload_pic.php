<?php

function upload_pic($img,$img_ext,$img_name,$x,$y,$mdir)
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
				   if($t_img == "gif" || $t_img == "png"){
					imagecolortransparent($new_img, imagecolorallocatealpha($new_img, 0, 0, 0, 127));
					imagealphablending($new_img, false);
					imagesavealpha($new_img, true);
					}
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
//               $mdir = "../profile_pic";
               $new_name = $mdir.md5($img_name." ".date("U")).$final_ext;
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
					return $new_name;
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