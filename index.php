<?php
$httphost=$_SERVER['HTTP_HOST'];
if(!stristr($httphost,"www")&&!stristr($httphost,"localhost"))
{header('HTTP/1.1 301 Moved Permanently');header("location://www.".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);}
session_start();
if(isset($_GET["logout"]))
{
	session_destroy();	
	setcookie("pm",NULL,time()-60*60,"/");	
	setcookie("um",NULL,time()-60*60,"/");
	header("location: ./");
}
require_once("./scripts/db.php");
$__str = $_SERVER['REQUEST_URI'];
$__st = preg_split('-/-',$__str);
$o_o_o = $__st[count($__st) - 1];

//exit($o_o_o."43434 ".stripos($o_o_o,"__")." ");
if(!stristr($o_o_o,"picture-")&&!stristr($o_o_o,"music-")&&!stristr($o_o_o,"video-"))
{
	if(!is_dir($o_o_o) && !is_file($o_o_o) && !valid_name($o_o_o) && stripos($o_o_o,"?") === false)
	{
		header("status:500",false,500);	
		exit();
	}
}
header("Content-Type: text/html");
header("keywords:Social website,Muzik kitchen, Muzikkitchen,Music Kitchen, Social, Web, Chat, Upload,Music Picture,Videos, Nigerian. ");
header("Description: Muzik Kitchen is a social website, it allows peeps share, exchange and relate. It also supports upcoming artists and potential celebs to display their talents with music, picture and video upload. Join in on the fun :D .");
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)) || isset($_GET["force_mobile"])){
	if(!isset($_GET["force_web"]))
	{
		$_SESSION["mobile"] = 2;
		if(isset($_SESSION["user"],$_SESSION["p"]) && $_SESSION["uid"] != 0)
		{
			require("mindex.php");
			exit();	
		}
		require("./m/index.php");
		exit();
	}
	else
	{		
		$_SESSION["mobile"] = false;		
	}
}
if(($_GET["user_auth"]) == 1 && $_GET["ht"]==2)
{
	$str = $_SERVER['REQUEST_URI'];
	$st = preg_split('-/-',$str);
	if((($_SESSION["mobile"]) == 2 || isset($_GET["force_mobile"]) )&& !isset($_GET["force_web"]))
	{
		require("mindex.php");
		exit();
	}
	require("hindex.php");
	exit();
}
$captch = "Enter the Captha in the text Box to your right";
$user = trim($_POST["user"]);

$email = strtolower(trim($_POST["email"]));

if(isset($_SESSION["user"],$_SESSION["p"]) && $_SESSION["uid"] != 0)
{
	if(($_SESSION["mobile"]) == 2 && !isset($_GET["force_web"]))
	{
		require("mindex.php");
		exit();
	}
	require("hindex.php");
		exit();
}
if(isset($_GET["search"]))
{
	require("hindex.php");
		exit();
}
if($_SESSION["new_login"] == 2)
{
	$_SESSION["new_login"] = false;
	if(($_SESSION["mobile"]) == 2)
		{
				require("mindex.php");
				exit();
		}
		require("hindex.php");
		exit();	
}

function login2($user,$pass)
{
	$con = new db();$conc = $con->c();
	$kcook = intval($_POST["remember"]);
	$q = mysqli_query($conc,"SELECT `id`,`user`,`name`,`email`,`img1`,`img2`,`img3`,`bgcolor` FROM `users` WHERE (`user` = '$user' OR `email` ='$user') AND pass = '$pass'");
	if(mysqli_num_rows($q) == 1)
	{
		$r = mysqli_fetch_array($q);
		setcookie("u",$r[1],time()+52*60*60*24*7,"/");
		$_SESSION["uid"] = $r[0];
		$_SESSION["user"] = $r[1];
		$_SESSION["name"] = $r[2];
		$_SESSION["email"] = $r[3];
		$_SESSION["p"] = $pass;
		$_SESSION["color"] = $r[7];
		$_SESSION["img1"] = $r[4];
		$_SESSION["img2"] = $r[5];
		$_SESSION["img3"] = $r[6];
		$_SESSION["ula"] = md5("$r[1] $pass $r[0]");		
		$con->close_db_con($conc);
		if(!valid_name($_SESSION["user"]))
		{
			$_SESSION["set_user"] = "Please correct your username remove symbols, characters or spaces, and should be less than 20 characters";
			header("location: ./?settings");
		}
		else
		{
			if($kcook == 1)
			{
				setcookie("um",$r[1],time()+52*60*60*24*7,"/");
				setcookie("pm",$pass,time()+52*60*60*24*7,"/");	
			}			
			return true;
		}
	}else
	{
		return false;
	}	
}
if(isset($_POST["login"]))
{
	$pass = sha1($_POST["pass"]);
	if(login2($user,$pass))
	{
		$_SESSION["new_login"] = 2;
		header("location: ./");
	}
	else
	{
			$ress = "The username/email doesn't match the password provided";	
	}
}

if(isset($_COOKIE["um"]) && isset($_COOKIE["pm"]))
{
	if(login2($_COOKIE["um"],$_COOKIE["pm"]))
	{
		$_SESSION["new_login"] = 2;
		header("location: ./");
	}
	else
	{
		$ress = "";	
	}
}

if(isset($_POST["add"]))
{
			$con = new db();$conc = $con->c();
			$cont = true;
			$q = mysqli_query($conc,"SELECT `id` FROM users WHERE email = '$email'");
			if(mysqli_num_rows($q) == 1)
			{
				$cont = false;
				session_destroy();
				$res = "That email address is already registered";	
			}
			$q = NULL;
	if($cont)
	{
		$_70x70 = "/img/d70.png";

		$_150x150 = "/img/d150.png";
		$_500x500 = "/img/d500.png";
		$user ="";
		$name = "";
		
		list($unm,$_rubbish_text_yimu) = explode("@",$email);
		$user = $unm."_".rand(100,999);
		if(strlen($user) > 25)
		{
			$user = substr($user,0,strlen($user) - 4);	
		}
		$name =  ucfirst($unm);
		$tz = $_POST["tz"];
		$lang = "en";
		$loc = "";
		$info = "";
		$bio = "";
		$pass = sha1($_POST["pass"]);
		$q = $con->insertInto("users",array($email,$user,$name,$pass,$bio,$loc,$_70x70,$_150x150,$_500x500,$tz,$lang,"",0,date("U"),"","","1","","","","","","","","",DEF_BG_IMG));
		if($q)
		{
			$qq = mysqli_query($conc,"SELECT * FROM `users` WHERE user = '$user'");
			$r = mysqli_fetch_array($qq);
			$q2 = $con->insertInto("online",array($r[0],date("U")));
			$_SESSION["user"] = $user;
			setcookie("u",$user,time()+52*60*60*24*7);
			$_SESSION["uid"]  = $r[0];
			$_SESSION["name"] = $name;
			$_SESSION["user"] = $r[2];
			$_SESSION["email"] = $r[1];
			$_SESSION["p"] = $r[4];
			$_SESSION["img1"] = $_70x70;
			$_SESSION["img2"] = $_150x150;
			$_SESSION["img3"] = $_500x500;
			$_SESSION["ula"] = md5("$user $r[4] $r[0]");
			$_SESSION["new_user"] = "YES";
			s_mail($user," Welcome to <a href='http://muzikkitchen.com/'>Muzik Kitchen</a><br/><div style='font-size:14px'><b><br/>Your temporal user name is $r[2], you can always change it, as well as other info, in <a href='http://muzikkitchen.com/#!/settings'>your account settings</a>.<br/><br/>Enjoy</b></div>",$r[0],$conc,"Welcome");
			$con->insertInto("follow",array($r[0],101212574,date("U")));		
			$con->close_db_con($conc);
			header("location: ./getting_started/");
		}
		else
		{			
			$res = "Registration Failed. Please try again in a minute";
		}
		$con->close_db_con($conc);
	}
	else
	{
		//$captch = "<b style='color:red'>Invalid Captcha Value, Please try again</b>";	
	}
}
//$rand = substr(md5(rand(-9000,2000)),0,7);
//$_SESSION["cpt"] = $rand;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript" >
var pr = window.location.toString();
if(pr.indexOf("#!/") > 0)
{
	var loc = pr.replace("#!/","?search#!/");
	window.location = loc;
}
</script>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="distribution" content="global" />
<meta name="audience" content="all" />
<meta NAME="rating" content="General"/>
<meta http-equiv="description" content="Muzik Kitchen is a social website, it allows peeps share, exchange and relate. It also supports upcoming artists and potential celebs to display their talents with music, picture and video upload. Join in on the fun :D ."  />
<meta http-equiv="keywords" content="Social website,Muzik kitchen, Muzikkitchen,Music Kitchen, Social, Web, Chat, Upload,Music Picture,Videos, Nigerian,Social, site, friends, pals, groups, chat, meet-up, share,family, photos"  />
<title>Muzik Kitchen</title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<script src="./scripts/jquery.js" type="text/javascript"></script>
<script src="./scripts/gb.js" type="text/javascript"></script>

<style type="text/css" >

body{
	background:#0f0f0f url(./img/watermark.png) repeat fixed;
	margin:0 auto;
/*	background:#000 url(./img/back.jpg) top no-repeat;*/
}
#header{
	color:#fff;	
	margin:0px auto;
background:url(./img/logo_home.png) no-repeat center;
	height:180px; width:180px;
}
#containers{
	width:500px;
	height:280px;
	z-index:10;
	margin:0px auto;
	background:#fff url(./img/container_home.jpg) right no-repeat;
	padding:25px;	
	border-radius:5px;
		
box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-webkit-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-moz-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
}
.footer{padding-top:20px; margin-bottom:0px; color:#777; background-color:#fff; margin-top:80px;		filter:opacity:90;
	opacity:0.9; z-index:1;

	filter: Alpha(opacity="90");
	box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-webkit-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-moz-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
}
.foot
{
color:#ddd;font-size:10px !important; margin-top:80px; padding:20px;
background-color:#111;	
}
.foot a
{
	font-size:10px;	
	color:#888;
}
.signup{
		margin:0 auto;
		width:213px;
		padding:10px;
		background:#09C;
		border:1px solid #192514;
		border-radius:5px;
		text-align:center;
		cursor:pointer;
		font-size:18px;
		color:#222;
		text-shadow:0 1px 0 rgba(255,255,255,0.5);
		
		box-shadow:inset 0px -4px 0px rgba(255,255,255,0.2), 0px 3px 0px rgba(0,0,0,0.2);
		-webkit-box-shadow:inset 0px -4px 0px rgba(255,255,255,0.2), 0px 3px 0px rgba(0,0,0,0.2);
		-moz-box-shadow:inset 0px -4px 0px rgba(255,255,255,0.2), 0px 3px 0px rgba(0,0,0,0.2);
	}
	.signup:active, .signup:hover{
		color:#999;
		background-color:#fff;
	}
/*#container2{
	width:500px;
	border-radius:5px 5px 0 0;
	background:#fff;
	bottom:0;
	left:50%;
	
	padding:10px;
	
	
}
*/
#new_m{
	width:99%;
	background:#fff;
	display:none;
	
	padding:10px;
	
}
.logindiv
{
	color:#444;
	padding:10px;
	 background-color:#fff;
	 border-radius:0 0 0 10px;
position:fixed;top:0px; right:0px; 
	
box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-webkit-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);
		-moz-box-shadow:inset 0px -14px 0px rgba(255,255,255,0.2),inset 0px 30px 30px rgba(0,0,0,0.2);	
}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31303642-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div class="logindiv">
<form action="./" method="post" name="lgform" >
<table cellpadding="0" cellspacing="2">
   <!-- #if [IE]><tr><td>Username/Email:</td><td>Password:</td></tr><!-- #endif-->
    <tr>
    <td><input type="text" class="txt" style="width:150px;" value="<?php echo isset($_POST["user"])?$_POST["user"]:$_COOKIE["u"]; ?>"  name="user" placeholder="username or email" title="username or email" /></td>
    <td><input type="password"style="width:150px;" title="password" class="txt" placeholder="password"  name="pass" /><input type="hidden"  name="login" value="" /></td>
    </tr>
    <tr><td style="font-size:10px" valign="top" ><label style="cursor:pointer;"><table><tr><td><input type="checkbox" value="1" name="remember"/></td><td valign="top"><span>Remember me</span></td></tr></table></label></td><td><a href="./forgot_password.php" style="font-size:10px;">Forgot password?</a><input class="button1" style="float:right;" value="SIGN IN" type="submit" /></td></tr>
    <tr><td style="font-size:10px" colspan="2"><i style="color:red;"><?php echo $ress; ?></i></td></tr>
    </table>
    
    </form>
    </div>
    <div id="header" ></div>
	<div id="containers"> 
<img src="./img/sign.png">
<form method="post" name="regform" action="./" enctype="multipart/form-data" id="form1" onsubmit="return subm();" >
<table cellspacing="10" style="font-size:10px;">
<tr><td width="100"></td><td id="err"><?php echo $res; ?></td><Td></Td></tr>
<tr><td>Email</td><td><input type="text" class="txt" placeholder="email"  name="email" value="<?php echo isset($_GET["reg_email"])?$_GET["reg_email"]:$email;?>" id="email" onblur="chkmail()" /><Br /><span id="emm"></span></td></tr>
<tr><td>Password</td><td><input type="password" placeholder="password" class="txt" id="p1"  name="pass"  /><Br/><span id="pww"></span></td></tr>
<tr><td>Re-enter Password</td><td><input placeholder="re-enter password" type="password" class="txt" id="p2" onblur="chkp()" name="rpass" /><br /><span id="pw"></span></td></tr>
<tr style="display:none;"><td>Country</td><td><select class="signin" id="user_time_zone" name="tz">
<?php
//include("./scripts/country.php");
?>
</select></td></tr>
<!--tr ><td style="font-size:10px" width="100"><table ><tr><td><?php
	/*$rand_name = rand(2,12);
	$cimg = imagecreatetruecolor(rand(30,40),70);

	imagefill($cimg,0,0,0x1b637b);

		imagestringup($cimg,30,rand(2,12),65,$rand,255122120);
			imagedashedline($cimg,0,15,30,40,255122120);
//imagettftext($cimg,30,50,14,76,255122122,"./class/mtd.ttf",$rand);
	imagejpeg($cimg,"./img/capt/$rand_name.jpg",70);
	imagedestroy($cimg);
	
	print ("<img src='./img/capt/$rand_name.jpg' />");	*/?></td><td valign="top" style="font-size:10px;"><?php //echo $captch;?></td></tr></table></td><td><input placeholder="enter captcha here" type="text" class="txt" name="cpt" /><br/><br/-->
    <tr><td></td><td><input type="submit" class="signup" value="SIGN UP" /><br/><input type="hidden"  name="add" value="Join" /> </td></tr>
</table>
</form>

    </div>

     <!--div  id="new_m" align="center">
<div style="text-shadow: -1px 1px 0px rgba(0,0,0,0.2), 0px 0px 0px rgba(255,255,255,0.2) !important;font:30px Tahoma, Geneva, sans-serif;color:#bbb" align="center">New Members</div><marquee loop="99" align="middle" id="div_body" onMouseOver="this.stop();" onMouseOut="this.start();"></marquee></div-->
    <script>
	function MainGet(){
		
			
			$.post("./actions/getnew.php",{all:true,limit:6},function (data){
				
				
				$("#div_body").html(data);
				});
			
			
	}
	
$(document).ready(function (){
//MainGet();
//sel_country(".");
});
	</script>
<?php  //include('./scripts/footer.php');?>
    <div align="center" class="foot"><a href='./?force_mobile'>Mobile Site</a> | <a href='./getting_started'>Getting Started</a> | Developed by <a href="http://godson.com.ng">Godson Ukpere</a> | <a href='./tos' target="_blank" >Terms of Use</a> | <a href='./tos' target="_blank" >Trademarks</a> | <a href='./tos' target="_blank" >Privacy Statement</a>
&copy; <?php echo date("Y")  ?> Muzikkitchen LTD Corporation. All Right Reserved.
</div>
</body>
</html>