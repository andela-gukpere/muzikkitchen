<?php
session_start();
$style = "style='font:20px verdana;text-align:center;color:#777;'";
$main = defined("PTH");
if(!$main)include("../scripts/db.php");
$pth = $main?".":"..";
include("../scripts/upload_pic.php");
$user = $_SESSION["user"];
$aut = $_POST["aut"];
$uid = $_SESSION["uid"];
//print_r($_SESSION);
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT `id`, `pass`, `user`,`email`,`loc`,`tz`,`lang`,`name`,`img1`,`img2`,`img3`,`bio`,`name`,`web`,`protect`,`edu`,`work`,`bday`,`status`,`status_`,`sex` FROM users WHERE  id = $uid");
//id`, `pass`, `user`,`email`,`loc`,`tz`,`lang`,`name`,`img1`,`img2`,`img3`,`bio`,`name`,`web`,`protect`,`edu`,`work`,`bday`,`status`,`status2`,`sex`
//0		1		2		3		4	  5		6		7	8		9		10   11    12		13   	14	   15	16		17		18		19  20
$r = mysqli_fetch_array($q);
if(mysqli_num_rows($q) == 1)
{
	
	$user_auth = md5("$r[2] $r[1] $r[0]");
	if(!isset($_SESSION["uid"]) || $_SESSION["uid"]==0)//$aut != $user_auth || $_SESSION["user"] != $user)
	{
		$con->close_db_con($conc);
		echo "<div class='m_s_g'>Ooppss!. Invalid authentication please re-login. $r[2] $r[1] $r[0] $user_auth</div>";
		exit();
	}
}
else
{
	$con->close_db_con($conc);
		echo "<div class='m_s_g'>Ooppss!. Invalid authentication please re-login. $r[2] $r[1] $r[0] $user_auth</div>";
		exit();

}


if(isset($_POST["profile"]))
{
		$q = NULL;
		$name = strclean($_POST["name"]);
		$loc = strclean($_POST["loc"]);
		$bio = _hstr_($_POST["bio"],false);
		$web = urlencode($_POST["web"]);
		$work = strclean($_POST["work"]);
		$edu = strclean($_POST["edu"]);
		$bday = ($_POST["bday"]);
		$sex = intval($_POST["sex"]);
	//	if(!preg_match('-(\d{2})/(\d{2})/(\d{4})-',$bday))
	//	{
	//		exit("<div $style>Your birthday should be in this format {MM/DD/YYYY}</div>");
	//	}
		$status = strclean($_POST["status"]);
		$status2 = $status == 4? _hstr_($_POST["status_"],2):"";
		list($img1,$img2,$img3) = explode("____",$_POST["imgs"]);
		$img = $_FILES["upl"]["tmp_name"];
		if(is_uploaded_file($img))
		{
			$mdir = "$pth/profile_pic/";
			$_50x50 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],70,70,$mdir);
			$_150x150 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],150,150,$mdir);
			$_400x400 = upload_pic($img,$_FILES["upl"]["type"],$_FILES["upl"]["tmp_name"],500,500,$mdir);
			
			$_50x50 = str_replace($pth,"",$_50x50);
			$_150x150 = str_replace($pth,"",$_150x150);
			$_400x400 = str_replace($pth,"",$_400x400);
			
			
			if($_50x50 && $_150x150 && $_400x400)
			{
				$q= mysqli_query($conc,"SELECT img1,img2,img3 FROM users WHERE id=$uid");
				$r = NULL;
				$r = mysqli_fetch_array($q);
				if(!stristr($r[0],"/img/"))
				{
					 unlink($pth.$r[0]); 
					 unlink($pth.$r[1]);
					 unlink($pth.$r[2]);
				}
				$r = NULL;
				$q = NULL;
				$q = mysqli_query($conc,"UPDATE users SET name= '$name', web = '$web', bio = '$bio', loc = '$loc',img1='$_50x50',img2='$_150x150',img3='$_400x400',edu='$edu',work='$work',status ='$status',status_ = '$status2',bday='$bday',sex='$sex' WHERE id = $uid");
				if($q)
				{	
					$_SESSION["img1"]  = $_50x50;
					$_SESSION["img2"]  = $_150x150;
					$_SESSION["img3"]  = $_400x400;
					echo "<div $style >Your profile has been successfully updated. Photo also changed.</div><script>							  
					try{
					var img  = parent.document.getElementById('uimg');

					var href  = parent.document.getElementById('img_href');
					img.src = '".PTH."$_50x50';
					href.href = '".PTH."$_400x400';
					var file_upl  = parent.document.getElementById('upl');
					//file_upl.setAttribute('value','');

					//alert(file_upl.value);
					}
					catch(sds)
					{
						alert(sds);	
					}
					</script>";	
				}
				else
				{
					unlink($_50x50);unlink($_150x150);unlink($_400x400);
					echo "<div $style >Ooppss, something went wrong. Please try again.</div>";												
				}
			}
			else
			{
				echo "<div $style >Ooppss, something went wrong with the picture upload. Try uploading a smaller photo.</div>";	
			}
		}
		else
		{
			$q = mysqli_query($conc,"UPDATE users SET name= '$name', web = '$web', bio = '$bio', loc = '$loc',edu='$edu',work='$work',status ='$status',status_ = '$status2',bday='$bday',sex='$sex' WHERE id = $uid");
			if($q)
			{
				echo "<div $style >Your profile has been successfully updated</div>";	
			}
			else
			{
				echo "<div $style >Ooppss, something went wrong. Please try again.</div>";	
			}	
		}
		$con->close_db_con($conc);
		exit();
}

if(isset($_POST["account"]))
{
		$q = NULL;

		$email = $_POST["email"];
				$usern = ($_POST["usern"]);
		if(!valid_name($usern))
		{
			echo "<div $style>'<b>$usern</b>' contains unsupported characters or spaces, and should be less than 20 chars. Please try again.</div>";
			exit();
		}
		$q = mysqli_query($conc,"SELECT id FROM users WHERE user = '$usern'");
		if(mysqli_num_rows($q) != 0 && $_SESSION["user"] != $usern)
		{
			echo "<div $style>Sorry that username is already taken</div>";
			$con->close_db_con($conc);
			exit();
		}
				
		$lang = $_POST["lang"];
		$protect = $_POST["protect"] == "on"?1:0;
		$tz = $_POST["tz"];
		if($usern != $_SESSION["user"])
		{
			$_SESSION["user"] = $usern;
			$red = "<script>setTimeout(function (){window.open('$pth/?settings','_parent');},200);</script><br/><div></div>";
		}
		$q = mysqli_query($conc,"UPDATE users SET user='$usern' , email='$email', lang= '$lang' ,tz = '$tz',protect='$protect' WHERE id = $uid");
		if($q)
		{
			setcookie("u",$usern,time()+52*60*60*24*7);	
			echo "<div $style >Your account information has been successfully updated</div>$red";	
		}
		else
		{
			echo "<div $style >Ooppss, something went wrong. Please try again.</div>";	
		}
		$con->close_db_con($conc);
		exit();
}

if(isset($_POST["pass"]))
{
		$q = NULL;
		$opass = sha1($_POST["opass"]);
		$rnpass = sha1($_POST["rnpass"]);
		$npass = sha1($_POST["npass"]);
		if($rnpass != $npass)
		{
			echo "<div $style >Passwords do not match</div>";
			exit();
		}	
		//echo "$opass | $npass | $uid";
		$q  = mysqli_query($conc,"SELECT `id` FROM users WHERE pass = '$opass' AND id = $uid");
		if(mysqli_num_rows($q) != 1)
		{
			$con->close_db_con($conc);
			echo "<div $style >Thats the wrong old password</div>";	
			exit();
		}
		$r = mysqli_fetch_array($q);
		$q = NULL;
		$q = mysqli_query($conc,"UPDATE users SET pass = '$npass' WHERE pass = '$opass' AND id = $r[0]" );
		if($q)
		{
			$_SESSION["p"] = $npass;
			s_mail($_SESSION["user"],"You changed your password recently to ".$_POST["npass"],$_SESSION["uid"],$conc,"Password change notification");
			echo "<div $style >Your password has been successfully changed.</div>";/*Please relogin <script language='javascript'>window.open('../?logout','_parent');</script>";	*/
		}
		else
		{				
			echo "<div $style >Ooppss, something went wrong. Please try again.</div>";	
		}	
		$con->close_db_con($conc);
		exit();
}

?>


<div id="tabs" style="width:630px;font-size:12px;">
<b style="color:red;"><?php echo isset($_SESSION["set_user"])?$_SESSION["set_user"]:""; ?></b>
	<ul>
    <li><a href="#profile" onclick="">Profile Information</a></li>  
    	
    <li><a href="#custom">Customize</a></li>
      	 <li><a href="#account">Account information</a></li>
      	<li><a href="#password">Password</a></li>
    </ul>
        <iframe  name="frame" width="100%" height="60" src="" onload="uploading(false);scrollIntoView(false);" class="ifr"  allowtransparency="true"></iframe>

    <div id="account">
    	<form action="./settings/" method="post" enctype="multipart/form-data" id="form1" onsubmit="chkmail();uploading(fdf);return fdf;" target="frame">
    	<table cellpadding="10" cellspacing="10">	
          	<tr><td>Username<br/><i style="font-size:10px;">*no spaces.. <br/>it will be trimmed</i></td><td><input type="text" class="txt" name="usern" onblur="chkname(event)"  value="<?php echo $r[2]; ?>"/></td><td></td></tr>
            <tr><td>Email</td><td><input type="text" class="txt" name="email" id="email" onblur="chkmail();" value="<?php echo $r[3]; ?>"/></td><td id="emm"></td></tr>
            <tr><td>Language</td><td>
            <select class="txt" name="lang" onchange="fdf=true;">
			<?php
				foreach ($lang_array as $k=>$lang)
				{
					$sel = $k == $r[6]?"selected = 'selected'":"";
					echo "<option label='$lang' value='$k' $sel>$lang</option>";	
				}
			?>
          </select>
</td></tr>
<tr><td>Country</td><td><select class="txt" id="user_time_zone" onchange="fdf=true;" name="tz"><?php
include("$pth/scripts/country.php");

?></select></td></tr>
<!--tr ><td>Lock</td><td><input onchange="fdf=true;" type="checkbox" name="protect" value="on" <?php echo intval($r[14])== 1?"checked='checked'":""; ?> /> <i style="font:10px Verdana;">(If you check this box. People will require<br/>your permission to access your profile)</i></td></tr-->
             <tr><td></td><td><input type="submit" name="account" onclick="uploading(true)" value="Update" class="button1" /><input type="hidden" name="aut" value="<?php echo $aut;?>" /><input type="hidden" name="user" value="<?php echo $user;?>" /></td></tr>
        </table>
    </form>
    </div>
     <div id="password">
     <form action="./settings/" method="post"  id="form1" onsubmit="uploading(chkp());return chkp();" target="frame">
    	<table cellpadding="10" cellspacing="15">
        	<tr>
            	<td>Old Password</td><td><input type="password" name="opass" value=""  class="txt"/></td>
            </tr>
            <tr>
            	<td>New Password</td><td><input id="p1" type="password" name="npass" value=""  class="txt"/></td><td id="pww"></td>
            </tr>
            <tr>
            	<td>Renter New<br/>Password</td><td><input id="p2" type="password" name="rnpass" value=""  class="txt"/></td><td id="pw"></td>
            </tr>
            <tr><td></td><td><input type="submit" name="pass" value="Change Password" onclick="uploading(true)"class="button1" /><input type="hidden" name="aut" value="<?php echo $aut;?>" /><input type="hidden" name="user" value="<?php echo $user;?>" /></td></tr>
        </table>
        </form>
    </div>
    <div id="custom" style="min-height:400px;">
    <div align="center" style="font-size:20px; color:#888;" id="color_div"></div>
    <table cellspacing="10" cellpadding="10"><tr>
    <?php
    	$i = 0;
		foreach($color_array as $k=>$col)
		{
			$i++;
			echo "<Td><div class='scolor' style='background-color:$col;height:100px;width:100px;' onclick='_sav_color($k)' onmouseover='_prev_color(event,\"$col\",1)' ></div></td>";	
			if($i % 4 == 0)
			{
				echo "</tr><tr>";
			}//onmouseout = '_prev_color(event,\"$col\",2)'
		}
    ?>
    </tr></table>
    </div>
     <div id="profile"  >
    <form action="./settings/" style="padding-left:10px;" method="post" enctype="multipart/form-data" id="form1" onsubmit="uploading(fdf);return fdf;" target="frame">
    	<table cellpadding="2" cellspacing="2">
        <tr><td>Change Photo</td><td><table><tr><td><a id="img_href" href="<?php echo PTH.$r[10] ?>" target="_blank"><img id="uimg" src="<?php echo PTH.$r[8] ?>" style="border-radius:10px;" /></a></td><td><label for="upl"><input type="file" id="upl" name="upl"  style="visibility:hidden;" onchange="fdf = true;parentNode.childNodes[1].innerHTML='New image selected'"/><div class="button1" style="width:100px !important;" onclick="
if(navigator.userAgent.toString().indexOf('Firefox')>-1)$('#upl').click();
 " >Select image</div></label></td></tr></table></td></tr>
        	<tr><td>Name</td><td><input type="text" class="txt" name="name" onblur="chkname(event);" value="<?php echo $r[12]; ?>" /><br/><span style="color:red;" id="unn"></span></td><td></td></tr>
            <tr><td>Location</td><td><input type="text" class="txt"  onchange="fdf = true;"  name="loc" value="<?php echo $r[4]; ?>" /></td></tr>
           <tr><td>Web (http://)</td><td><input type="text"  onchange="fdf = true;"  class="txt" name="web" value="<?php echo urldecode($r[13]); ?>" /></td></tr>
           <tr><td>Gender</td><td><select class="txt" name="sex" onchange="fdf = true;" ><?php 
					   foreach($sex_array as $s=>$k)
					   {
						   $enab = "";
						   if($r[20] == $s)
						   {
								$enab = "selected='selected'";   
						   }
						   echo "<option value='$s' label='$k' $enab>$k</option>";
					   }
				   
					   ?></select></td></tr>
           <tr><td>Education</td><td><input type="text" class="txt" onchange="fdf = true;" name="edu" value="<?php echo $r[15]; ?>" /></td></tr>
           <tr><td>Work</td><td><input type="text" class="txt" onchange="fdf = true;" name="work" value="<?php echo $r[16]; ?>" /></td></tr>
           <tr><td>Birthday</td><td><input id="date" maxlength="10" type="text" onclick="" class="txt" style="width:100px;" onchange="fdf = true;" name="bday" value="<?php echo $r[17]; ?>" placeholder="MM-DD-YYYY" /></td></tr>
                       <tr><td>Status</td><td><select class="txt" onchange="rSh(event)" name="status" style="width:120px;"><?php 
					   foreach($status_array as $s=>$k)
					   {
						   $enab = "";
						   if($r[18] == $s)
						   {
								$enab = "selected='selected'";   
						   }
						   echo "<option value='$s' label='$k' $enab>$k</option>";
						   
					   }					   
					   ?></select><input type="text" class="txt" onchange="fdf = true;" name="status_" onkeyup="gment(event)" style="font-size:10px;width:80px;<?php echo $r[18]!=4?"display:none;":""; ?>" value=" <?php echo str_replace(" _","",$r[19]);?>" /><div class="pl2div" style='position:relative'></div></td></tr>
		   	<tr><td>Quote</td><td><textarea rows="4" class="txt" onchange="fdf = true;" name="bio" onkeyup="gment(event)" ><?php echo xtra_space($r[11]); ?></textarea><div class="pl2div" style='position:relative'></div></td></tr>
             <tr><td></td><td><input type="submit" name="profile" value="Update" class="button1" onclick="uploading(true)" /><input type="hidden" name="aut" value="<?php echo $aut;?>" /><input type="hidden" name="user" value="<?php echo $user;?>" /></td></tr>
        </table>
    </form>
    </div>
</div>
<?php
$con->close_db_con($conc);
?>
<input type="hidden" value="get_s('<?php echo $r[5] ?>');$('#settings_tabs').tabs();document.title= 'Muzik Kitchen | Settings';$('#date').datepicker({ yearRange: '1970:2010' });processVars();" id="eval_script" /> 

 <?php if($main){?>
    <script language="javascript">
		try
		{
			$(document).ready(function (){
			eval(document.getElementById("eval_script").value);
			});
		}
		catch(ev)
		{
			alert(ev);
		}
	</script>
    <?php }?>