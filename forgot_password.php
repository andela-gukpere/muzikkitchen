<?php
session_start();
require_once("scripts/db.php");
$str = $_SERVER['REQUEST_URI'];
$st = preg_split('-/-',$str);
$owner = $st[count($st) - 1];
if(!$_SESSION["user"])
{
	$_SESSION["uid"] = 0;
	$_SESSION["user"] = "Guest";
	$_SESSION["name"] = "Guest";
	$_SESSION["img1"] = "./img/d70.jpg";
	$_SESSION["img2"] = "./img/d150.jpg";
	$_SESSION["img3"] = "./img/d500.jpg";
}

$_SESSION["mobile"] = false;
$user = $_SESSION["user"];
$uid = $_SESSION["uid"];
$img = $_SESSION["img1"];

$img2 = $_SESSION["img2"];
$img3 = $_SESSION["img3"];
$user_login_auth = $_SESSION["ula"];
$p = $_SESSION["p"];
$col =intval($_SESSION["color"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="distribution" content="global" />
<meta name="audience" content="all" />
<meta NAME="rating" content="General"/>
<meta name="robots" content="all" />
<meta name="googlebot" content="all" />
<meta http-equiv="description" content="Muzik Kitchen is a social website, it allows peeps share, exchange and relate. It also supports upcoming artists and potential celebs to display their talents with music, picture and video upload. Join in on the fun :D ."  />
<meta http-equiv="keywords" content="Social website,Muzik kitchen, Muzikkitchen,Music Kitchen, Social, Web, Chat, Upload,Music Picture,Videos, Nigerian,Social, site, friends, pals, groups, chat, meet-up, share,family, photos"  />
<title>Muzik Kitchen | Reset Password</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="./scripts/jquery.js"  type="text/javascript"></script>
<script language="javascript">
var reset_password = function (e)
{
	$("#result").html("<div align='center'><img src='./img/load/ml.gif' /></div>");
	e = e?e:window.event;
	var email  = document.getElementById("email").value;
	var boolin = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i.test(email);
	if(!boolin)
	{
		$("#result").html("The email address entered is invalid.");	
		return false;
	}
	$.post("./actions/resetp.php",{email:email},function (data)
	{		
		$("#result").html(data);	
	});
}
</script>
<style type="text/css">
li{ list-style:none; padding:10px; font:14px Tahoma, Geneva, sans-serif;}
.dv{background-color:#8a8a8a;color:#ffffff;padding:10px;font:12px Verdana, Geneva, sans-serif;}
</style>
</head>
<?php
	//echo $uid == 0?"<div  class='chatbtt' style='color:#333;padding:10px;margin:10px auto; position:absolute; top:10px;text-shadow:2px 2px 2px #333;' onclick='window.open(\"./\",\"_parent\")' title='login or join' ><img src='./img/logo_home.png' ></div>":"";
?>
<div id="nav" class="nav"><table align="left" style="float:left;" cellpadding="1"><tr><td><a href="./"><img src="img/logo.png"/></a><Td style="width:70%;"></Td></td><td><form action="./" method="get" ><input type="text" id="sbox"   name="search" class="txt" style="width:150px;padding-left:5px;" placeholder="Search Muzik Kitchen" title="Search" /></form></td></tr></table></div>
<div id="_s" onclick="$(this).fadeOut(200);"></div>
<body style="background-color:<?php echo $color_array[$col];  ?>; padding-top:40px;">
<div id="container" align="center" >
<div style="padding:10px;">

	<div id="_div_"  class="dv">
    <ul><li><a href="./"><img src="img/logo.png"/></a></li></ul>
    <span style="font-size:25px;margin-left:50px;border-bottom:4px dashed #777; padding-bottom:20px;">Reset Password</span>
	<ul style="margin-top:50px;"><li>Enter the email address concerned<Br/>with your account</li><li><input type="text" class="txt" placeholder="Email address" id="email" /></li>
    <li> <input type="button" value="Reset Password" class="chatbtt" onclick="reset_password(event)"  /></li>
    <li><div id="result" style="padding:10px; border:1px solid #eee;background-color:#7a7a7a;width:80%;"></div></li>
</ul></div></div>
    <div style="margin-top:20px;">
    <?php include_once("scripts/footer.php"); ?>       
    </div>
    </div>  
</body>
</html>
