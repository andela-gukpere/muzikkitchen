<?php
session_start();
require_once("./scripts/db.php");
$str = $_SERVER['REQUEST_URI'];
$st = preg_split('-/-',$str);
$owner = $_GET[i];//$st[count($st) - 1];

	if(!valid_name($owner) || strstr ($owner,"?"))
	{
			$owner = false;	
	}
if(!$_SESSION["user"])
{
	$_SESSION["uid"] = 0;
	$_SESSION["user"] = "Guest";
	$_SESSION["name"] = "Guest";
	$_SESSION["img1"] = "/img/d70.jpg";
	$_SESSION["img2"] = "/img/d150.jpg";
	$_SESSION["img3"] = "/img/d500.jpg";
	if(!($owner))
	{
		header("location: ./?logout");	
	}
}
$_SESSION["mobile"] = 2;
$user = $_SESSION["user"];
$uid = $_SESSION["uid"];
$img = $_SESSION["img1"];
if($uid == 0 && !($owner) && !isset($_GET["mediaID"]))
{
	header("location: ./?logout");		
}
$img2 = $_SESSION["img2"];
$img3 = $_SESSION["img3"];
$user_login_auth = $_SESSION["ula"];
$p = $_SESSION["p"];
//$owner = isset($_GET["i"])?$_GET["i"]:$user;

$col = intval($_SESSION["color"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="<?php echo PTH ?>/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo PTH ?>/m/scripts/style.css" type="text/css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="distribution" content="global" />
<meta name="audience" content="all" />
<meta name="rating" content="General"/>
<meta content='width=device-width,height=device-height,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' name='viewport' />


<title>Muzik Kitchen | <?php echo $user ?></title>
<style>
.smpdiv
{
	height:60px;
	background:<?php echo $color_array[$col];  ?> no-repeat center;
	width:60px;
	border-radius:5px;
}
.ssmpdiv
{
	height:40px;
			background:<?php echo $color_array[$col];  ?> no-repeat center;
	width:40px;
	border-radius:5px;
}
.mpdiv
{
	height:90px;
	width:90px;
	background:<?php echo $color_array[$col];  ?> no-repeat center;
	border-radius:5px;
}
</style>
</head>
<script>var prof_color = "<?php echo $color_array[$col]; ?>";var PTH = '<?php echo PTH ?>';</script>
<script src="<?php echo PTH ?>/scripts/jquery.js" type="text/javascript"></script>
<script src="<?php echo PTH ?>/scripts/gdate.js"  type="text/javascript"></script>
<script src="<?php echo PTH ?>/m/scripts/scripts.js"></script>

<body style="background-color:<?php echo $color_array[$col];  ?>;">
<div id="nav" class="nav"><table width="100%" cellpadding="0" cellspacing="0"><tr><td>
<a href="<?php echo PTH ?>"><img src="<?php echo PTH; ?>/img/logo.png"/></a></td><td><form action="#" onsubmit="return _s(event)"><input type="text" id="sbox"  onkeyup="__s(event)" class="txt" style="width:80%;padding:2px;" placeholder="Search.."  title="Search"/></form><div id="_s" onclick="$('#_s').fadeOut(200)"></div></td><td><a class="button1" style="font:15px Tahoma, Geneva, sans-serif; margin:0px;padding:3px !important;" href="<?php echo PTH ?>/<?php echo $_SESSION["user"];?>"><?php echo $user?></a></td><td><a href="<?php echo PTH ?>/?logout" style="color:#fff;">Logout</a></td></tr></table>
</div>

<div id="container">

<table width='100%'><tr><td colspan="2">
<?php
if(!$owner && !isset($_GET["rep"]))
{


if(!$owner && !isset($_GET["mediaID"]))
{
?>
<div align="center" class="mndiv" ><ul   class="menu">
    <li>
    <a href="#" onclick="go_main(event);" class='se' >My Table</a>
    </li>
    <li>
    <a href="#" onclick="go_mention(event)" >Mentions</a>
    </li>
    <li>
    <a href="#" onclick="go_msgs(event)">Messages <b id="msg_num"><?php echo $_SESSION["msg_num"] ?></b></a>
    </li>
    <li>
    <a href="#" onclick="go_plate(event)">My Plate <b id="plate_num"><?php echo $_SESSION["plate_num"] ?></b></a>
    </li>
    <li>
    <a href="#" onclick="go_likes(event);">Likes</a>
    </li>
    <li>
    <a href="#" onclick="go_dine(event,1);">Dining with</a>
    </li>
    <li>
    <a href="#" onclick="go_dine(event,2);">Dining with me</a>
    </li>
    <li>
    <a href="#" onclick="go_refeeds(event);">Refeeds</a>
    </li>
    </ul>
 </div> 
<table  id="_pt_" style="width:100%; display:none;" ><tr><td valign="top" style="display:none !important;">
    <div class="smpdiv" style="background:#ccc url(<?php echo PTH.$_SESSION["img1"]; ?>) center no-repeat;" ></div></td><td valign="top"><b>225</b><br/><textarea name"post"  placeholder="What's Cooking?" rows="1" onkeyup="gment(event)" onkeydown="fixlength(event)"  id="txtdiv" onclick="rows=3;"></textarea><br/><div class="pl2div" onclick="$(this).slideUp(200);"></div>
 <table cellpadding="0" cellspacing="0"><tr><Td>   <input type="button" value="Feed" onclick="_post(0,0,event)" name="post_" class="button1" style="float:left;" /></Td><td><form enctype="multipart/form-data" action="./actions/gallery.php" method="post" target="mframe" >
    <input type="hidden" name="add" value="1" /><input type="hidden" name="quick" value="1" />
     <label for="upl" role="dialog" ><input type="file" id="upl" value="Upload pic" style="border:0; background:#111; visibility:hidden; height:1px; width:1px;" title="attach image" name="upl" onchange="submit();uploading(true);_$('txtdiv').disabled=true;" class="button1" /><div 
    class="upldiv" title="select 'n' upload photo"></div></label></form></td></tr></table><iframe onload="_$('txtdiv').disabled=false;" name="mframe" style="display:none;" height="0" width="0" frameborder="0"></iframe></td></tr></table>
    
<?php
}
}
$no_post = false;
$no_mtb = true;
if($owner)
{
	require_once("./m/actions/prof.php");	
	$no_post = true;
}
else if (isset($_GET["msg"]))
{
	if (isset($_GET["inb"]))
	{		
		$no_post = true;
		require_once("./m/msg/msg.php");		
	}
	if(isset($_GET["sendmsg"]))
	{
		require_once("./m/msg/compose.php");	
	}
}
else if (isset($_GET["view"]))
{
	$no_post = true;
	require_once("./m/actions/view.php");	
}
else if (isset($_GET["rep"]))
{
	require_once("./m/actions/rep.php");
	$no_post = true;	
}
else if (isset($_GET["mediaID"]))
{
	require_once("./actions/mediacontent.php");
	?>
	<script>
	$(document).ready(function(){showLoad(false)});
	</script>
    <?php 	
}
else
{
	echo "<script>go_main(null);</script>";	
}
?>
<?php
if(!$no_post)
{	
	
	?>
    
	<div class='hddload'>Loading...</div>
	<div id="m_t_b">
 		
	</div>
<?php
}

?>
</td></tr><tr><td>
<br/><br/>
<div align="center" class="nameH1"><B style="font-size:15px;" >Dining with you</B></div>
<div id="dinewu" class="scolumn">
</div><Br/>
<div align="center" class="nameH1"><B style="font-size:15px;">Peeps you may know</B></div>
<div id="ppl" class="scolumn">
</div>
</td><td></td></tr></table>
<?php
include_once("./m/scripts/footer.php");
?>
</div>
<script>

function pppp (){
	$.post(PTH+"/actions/rand_p.php?mobile",{session:true},function (data){
		var data = String(data).split("__::__");
		$("#ppl").html(data[0]);
		$("#dinewu").html(data[1]);
		processVars();
		setTimeout(pppp,60000);
		}).error(function (){		setTimeout(pppp,60000);});
}

$(document).ready(function(){
	
	pppp();
	setInterval(function(){
	vary_time("m_t_b");},30000);
	});
</script>
</div>

</body>

</html>