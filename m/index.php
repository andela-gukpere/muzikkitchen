<?php
session_start();
if(!$useragent)
{
	header("location: ../");	
}
require_once("./scripts/db.php");
$captch = "Enter the Captha in the text Box to your right";
$user = trim($_POST["user"]);
$email = strtolower(trim($_POST["email"]));
if(isset($_GET["logout"]))
{	
	setcookie("p","",time()-60*60);	
	session_destroy();	
}
if(($_GET["user_auth"]) == 1 && $_GET["ht"]==2)
{
	$str = $_SERVER['REQUEST_URI'];
	$st = preg_split('-/-',$str);
	require("./mindex.php");
	exit();
}
if(isset($_SESSION["user"],$_SESSION["p"]) && $_SESSION["uid"] != 0)
{
	require("./mindex.php");
	exit();
}
function login($user,$pass)
{
	$con = new db();$conc = $con->c();
	$kcook = intval($_POST["remember"]);
	$q = mysqli_query($conc,"SELECT `id`,`user`,`name`,`email`,`img1`,`img2`,`img3`,`bgcolor` FROM `users` WHERE (`user` = '$user' OR `email` ='$user') AND pass = '$pass'");
	if(mysqli_num_rows($q) == 1)
	{
		$r = mysqli_fetch_array($q);
		setcookie("u",$r[1],time()+52*60*60*24*7);
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
		if($kcook == 1)
		{
			setcookie("u",$r[1],time()+2*60*60*24*7);
			setcookie("p",$pass,time()+2*60*60*24*7);	
		}
		return true;
	}
	else
	{
		return false;
	}
		
}
if(isset($_POST["login"]))
{
	$pass = sha1($_POST["pass"]);
	if(login($user,$pass))
	{
		require("./mindex.php");
		exit();
	}
	else
	{
		$ress = "The username/email doesn't match the password provided";		
	}
}
else if(isset($_COOKIE["u"],$_COOKIE["p"]))
{
	login($_COOKIE["u"],$_COOKIE["p"]);
}

if(isset($_POST["add"]))
{
			$con = new db();$conc = $con->c();
			$cont = true;
			$q = mysqli_query($conc,"SELECT `id` FROM users WHERE email = '$email'");
			if(mysqli_num_rows($q) == 1)
			{
				$cont = false;
				$res = "That email address is already registered";	
			}
			$q = mysqli_query($conc,"SELECT `id` FROM users WHERE user = '$user'");
			if(mysqli_num_rows($q) == 1)
			{
				$cont = false;
				$res = "That username is already registered";	
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
		setcookie("u",$user,time()+52*60*60*24*7);
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
			header("location: ./m/getting_started/");
		}
		else
		{
			$res = "Registration Failed. Please try again in a minute";
		}
		$con->close_db_con($conc);
	}
	else
	{
		$captch = "<b style='color:red'>Invalid Captcha Value, Please try again</b>";	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content='width=device-width,height=device-height,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' name='viewport' />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Muzik Kitchen Mobile</title>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
<script src="<?php echo PTH ?>/scripts/jquery.js"  type="text/javascript"></script>
<script src="<?php echo PTH ?>/scripts/gb.js"></script>
<link rel="stylesheet" href="<?php echo PTH ?>/m/scripts/style.css" type="text/css" media="all" />
<!--script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31303642-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script-->
</head>
<body style="background:#fff;">
<div align="center"><img height="73" width="200" src="./img/logo_home.png" /></div>
<div id="container" >
<div>
<Br />
<b style="font-size:20px;">Muzik Kitchen</b>
<hr /></div>
<div style="padding:10px;">

<form action="./" method="post" >
<div style="font-size:15px;">Already a member?</div>
<table cellpadding="2" cellspacing="1" width="100%"  style="font-size:10px;">
<tr><td width="30%">Username or Email</td><td><input type="text" class="txt" value="<?php isset($user)?$user:$_COOKIE["u"]; ?>"  name="user" placeholder="username or email" /></td></tr>
<tr><td>Password</td><td><input type="password"  placeholder="password" class="txt"  name="pass" /></td></tr>
<tr><td></td><td style="font-size:10px" colspan="2"><input type="checkbox" value="1" name="remember"/><label for="remember">Remember Me</label><br/><a href="./forgot_password.php">Forgot password?</a><i style="color:red;"><?php echo $ress; ?></i></td></tr>
<tr><td></td><td><input type="submit" name="login" value="login" class="button1" /></td></tr>
</table>
</form>
<form method="post" action="./" id="form1" onsubmit="return subm();" >
<div style="font-size:15px;">Join in.</div>
<table cellpadding="2" width="100%"  cellspacing="1" style="font-size:10px;">
<tr><td width="30%"></td><td id="err"><?php echo $res; ?></td><Td></Td></tr>
<tr><td>Email</td><td><input type="text" class="txt" placeholder="email"  name="email" value="<?php echo $email;?>" id="email" onblur="chkmail()" /><Br /><span id="emm"></span></td></tr>
<tr><td>Password</td><td><input type="password" placeholder="password" class="txt" id="p1"  name="pass"  /><Br/><span id="pww"></span></td></tr>
<tr><td>Re-type Password</td><td><input type="password"  placeholder="re-enter password"class="txt" id="p2" onblur="chkp()" name="rpass" /><br /><span id="pw"></span></td></tr>
<tr><td style="font-size:10px" width="100"></td><td><input type="submit" class="button1"  name="add" value="Join" /> </td></tr>
</table>
</form>
</div>
<?php 
include_once("./m/scripts/footer.php")
?>
</div>
<script>
$(document).ready(function(){	
	sel_country(".");
	});
</script>

</body>
</html>