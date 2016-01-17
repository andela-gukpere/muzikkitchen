<?php
session_start();
require_once("./scripts/db.php");
$str = $_SERVER['REQUEST_URI'];
$st = preg_split('-/-',$str);
//print_r($_GET);
$owner = $_GET['i'];//$st[count($st) - 1];
$noJx = $_SESSION["uid"] == 0?"true":"false";
if(!$_SESSION["user"])
{
	$_SESSION["uid"] = 0;
	$_SESSION["user"] = "Guest";
	$_SESSION["name"] = "Guest";
	$_SESSION["img1"] = PTH."/img/d70.jpg";
	$_SESSION["img2"] = PTH."/img/d150.jpg";
	$_SESSION["img3"] = PTH."/img/d500.jpg";
	$noJx = "true";
	if(!($owner))
	{
		header("location: ".PTH);	
	}
}
if($_SESSION["uid"]==0 &&!($owner) && !isset($_GET['mediaID']) && !isset($_GET["search"]))
{
	header("location: ".PTH);	
}
$_SESSION["mobile"] = false;
$user = $_SESSION["user"];
$uid = $_SESSION["uid"];
$img = $_SESSION["img1"];

$img2 = $_SESSION["img2"];
$img3 = $_SESSION["img3"];
$user_login_auth = $_SESSION["ula"];
$p = $_SESSION["p"];
$user_info = false;
if($owner)
{
	$con = new db();$conc = $con->c();
	$user_info = $con->fromTable("users","bgcolor,user,name,bio,loc,tz,web","id = '$owner' OR user='$owner'");
	$color_ar = $user_info[0];
}
else
{
	$color_ar =$_SESSION["color"];
}	
$col =intval($color_ar);
$profcolor = $color_array[$col];
$media_array = array();
if(isset($_GET['media']))
{
	$media_array["type"] = $_GET[type];
 	$media_array["id"] = $_GET[id];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta name="distribution" content="global" />
<meta name="audience" content="all" />
<meta NAME="rating" content="General"/>
<meta http-equiv="description" content="<?php if($user_info){
	echo "Muzik Kitchen user => $user_info[1], $user_info[2], $user_info[3], $user_info[4], $user_info[5], $user_info[6]. ";
	
	} ?>Muzik Kitchen is a social website, it allows peeps share, exchange and relate. It also supports upcoming artists and potential celebs to display their talents with music, picture and video upload. Join in on the fun :D ."  />
<meta http-equiv="keywords" content="<?php if($user_info){
	echo "$user_info[1], $user_info[2], $user_info[3], $user_info[4], $user_info[5], $user_info[6],";
	
	} ?>Social website,Muzik kitchen, Muzikkitchen,Music Kitchen, Social, Web, Chat, Upload,Music Picture,Videos, Nigerian,Social, site, friends, pals, groups, chat, meet-up, share,family, photos"  />
<title>Muzik Kitchen | <?php echo $user ?></title>
<link rel="shortcut icon" href="<?php echo PTH; ?>/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="<?php echo PTH; ?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo PTH; ?>/scripts/jqtabs1.8.css"/>
<script>var PTH = "<?php echo PTH; ?>"; </script>
<style type="text/css">
::selection {
	background: <?php echo $profcolor; ?> !important; /* Safari */
	}
::-moz-selection {
	background:<?php echo $profcolor; ?> !important; /* Firefox */
}
::-webkit-scrollbar {
    width: 12px;
	background-color:#ddd;
}
 ::-webkit-scrollbar:hover
 {
		background:#eee; 
 }
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover
{
	background-color:<?php echo $profcolor; ?>;	
}
</style>
<script src="<?php echo PTH; ?>/scripts/jquery.js"  type="text/javascript"></script>
<script type="text/javascript" src="<?php echo PTH; ?>/scripts/jqtabs1.8.js"></script>
<script src="<?php echo PTH; ?>/scripts/jquery.event.drag-1.5.min.js"  type="text/javascript"></script>
<script src="<?php echo PTH; ?>/scripts/jquery.nicescroll.min.js"  type="text/javascript"></script>

<script src="<?php echo PTH; ?>/scripts/script.js"  type="text/javascript"></script>
<script src="<?php echo PTH; ?>/scripts/gdate.js"  type="text/javascript"></script>
<script src="<?php echo PTH; ?>/scripts/gb.js"></script>
</head>
<?php
//	echo $uid == 0?"<div  class='chatbtt' style='color:#333;padding:10px;margin:10px auto; position:absolute; top:10px;text-shadow:2px 2px 2px #333;' onclick='window.open(\"".PTH."/\",\"_parent\")' title='login or join' ><img src='".PTH."/img/logo_home.png' ></div>":"";
?><body style="background-color:<?php echo $profcolor;  ?>;" >
<div id="nav" class="nav"><table style="overflow:visible; margin:0px auto;"  cellpadding="0" cellspacing="0"><tr><td valign="middle"><a href="<?php echo PTH; ?>/"><img src="<?php echo PTH; ?>/img/logo.png"/></a></td><Td><a class="button1" style="font-size:20px; padding:20px" href="<?php echo PTH; ?>/<?php echo $_SESSION["user"];?>" onclick="return _pop(event,'<?php echo $_SESSION["user"];?>')" onmouseover="//_pop(event,<?php echo $_SESSION["uid"];?>)">@<?php echo $_SESSION["user"] ?></a></Td><td valign="middle" width="100" style="background:url(img/play.png) center left no-repeat;padding:0 0 0 20px !important;margin:0 !important;"><a href="#"  id="nowplay" name="modal" style="font-size:12px;color:#fff;"><span direction="left"  behavior="scroll"  id='nowplaying'>Now Playing : Nothing</span></a></td><td ><a href="#" onclick="$('#sform').slideToggle(500);" style="padding:5px" class="button1">Search</a><div id="sform"><form action="#" onsubmit="return _s(this)"><input type="text" id="sbox"  onkeyup="__s(event)" class="sch" placeholder="Search" title="Search" /></form>
<br/><div id="_s" onclick="$('#sform').slideUp(200);"></div></div>
</td><td valign="top"><table style=" <?php echo $uid==0?"display:none;":"display:block;"; ?>  float:left; margin-left:10px; overflow:hidden;"><tr>

<td><a  href="#" class="button1" onclick="new_post(event)" style="padding:5px;" >&lsquo;Quick Feed&rsquo;</a></td>
<td><a href="#!/wall" go='wall/' onclick="return false;" ><div  go='wall/' onclick="return _go(event);" title="home" class="home_menu"></div></a></td>
<td><a href="#!/msg" go='msg/' onclick="return false;" ><div title="messages"  go='msg/' onclick="return _go(event);" class="msg_menu" style="padding-top:10px;" align="center"><div id="bnum"></div></div></a></td>
<td><a href="<?php echo PTH; ?>/<?php  echo $user?>"  onclick="return false;"><div class="prof_menu" onclick="return _o(event,'<?php echo $user ?>');" title="my profile" ></div></a></td>
<td><a  href="#!/media" go='media/' onclick="return false"><div class="edit_menu" title="edit your media"  go='media/' onclick="return _go(event);"></div></a></td>
<td><a href="#!/settings" go='settings/' onclick="return false;" title="settings"><div class="settings_menu"  go='settings/' onclick="return _go(event);"></div></a></td>
<td><a  href="<?php echo PTH; ?>/?logout" onclick=""><div class="logout_menu" title="logout"></div></a></td>
</tr></table>
</td></tr></table></div>

<div class="loading" align="center"><table cellpadding="0" cellspacing="0"><tr><td class="loadtxt">Loading</td><td width="27%"><span id="loader"></span></td></tr></table></div>
<div id="container">

	<div id="_div_">
   		<?php
		$isINC = false;
		if(($noJx == "true" || isset($_GET['i'])) && !isset($_GET["media"]) && !isset($_GET['search']))
		{
			include("./prof/index.php");
			$isINC = true;
		}
		if($_GET["mediaID"])
		{
			include("./actions/mediacontent.php");	
			$isINC = true;
		}
		if(isset($_GET["search"]))
		{

			include("./search/index.php");	
			$isINC = true;
		}
		$pnav = $_GET["pnav"];
		if(isset($pnav) && !$isINC)
		{
			$noJx = "true";
			if (file_exists($pnav))
			{
				
				include($pnav."/index.php");
			}
			else
			{
				echo "$pnav not found";
			}
			echo $noJx;
		}
		?>
    </div>

       <div id="boxes">
    	    <div id="dialog" class="window">
            <div><div style="float:left;background:url(<?php echo PTH; ?>/img/logo.png) no-repeat left; width:140px;height:38px;" ></div>
<a class="close" onclick="_modal_close(event)"></a> <a href="javascript:return false;" class="min" title="Hide" onclick="_tggle_(event)" ></a>  <!--div class="drag_g" title="Drag"></div--> 
            	   	  	<br/><br/>
           				<div id="div_audio_player" align="center"></div>
            			<div id="footnote"></div>    
				</div>
        	</div>
      </div>
      
      
       <div id="boxes">
        <div id="pwindow" class="window">
	      <div><div><div style="float:left;background:url(<?php echo PTH; ?>/img/logo.png) no-repeat left; width:140px;height:38px;" ></div> <a class="close" onclick="_modal_close(event)"/></a></div><br/>
          <br/>   
           <div id="pwin" ><br/><br/><div align="center">
           <img src="<?php echo PTH; ?>/img/load/ml.gif" /></div>
           <br/><br/>
           </div>
              
        </div>
      </div>
    </div>
    
    <div id="boxes">
        <div id="dialogvideo" class="window">
        	<!--a class="close" onclick="_modal_close(event)"/></a-->   
            <div id='video_html_vars'>
            </div>
            <div id="footnotediv"> </div>
        </div>    
	</div>
    <div id="boxes">
        <div id="userwindow" class="window" style="padding:0px !important;">
        	<!--a class="close" onclick="_modal_close(event)"/></a-->
            <div id='userwin'>
            </div>
        </div>    
	</div>
    
     <div id="boxes">
           <div id="dialogpicture" class="window">
        	<!--a class="close" onclick="_modal_close(event)"/></a-->
            <div id='art_html_vars'>
            </div>
            <div id="footnoteart"> </div>
        </div>
	</div>
     <?php include_once("./scripts/footer.php"); ?>
</div>  
                  <input type="hidden" id="is_playing" value="nil" /> 

   	
<div id="chrow"></div>
        <div id="divpch">
        	<div id="indivpch" style="padding:5px 5px 0px;"> 
        	</div>
        </div>
    <div id="lowdiv" style="position:fixed;bottom:0px;z-index:5"><table  style="margin-left:70px;"></table><table style=""><tr id="brow" ><td><!--input type="button" value="Events" title='Top 5 Notifications'onclick="show_nuts()" class="button1" id="_not_btt" /--></td><td valign="top"><input type="button" onclick='shoP()' class="chatbtt"  value="Online" id="phref" /> </td></tr></table></div></div>
       <div id="divl" class="lldiv">
       <div id='dd'><table><tr><td><div id='tim' style="color:#fff; font-size:9px;"></div></td></tr></table>
       </div>
    
    </div>
<script type="text/javascript" language="javascript">
var bgcolor = document.body.style.backgroundColor;
var prof_color = bgcolor;
var php_color = "<?php echo $profcolor; ?>";
var temp_color  = bgcolor;
var wallt = null;
var loading_interval = null;
function uploading(b)
{
		doLoading (b?10:20);
}
function doLoading (show)
{
//	if(loading_interval != null)return false;

	if(show == 10)
	{
		show = true;
		$(".loadtxt").html("Uploading");
	}
	else
	{		
		show = show == 20?false:show;
		$(".loadtxt").html("Loading");
	}	
	is_active = show;
	var loader = document.getElementById("loader");
	$(".loading").fadeIn(200);
	if(show)$(".loading").animate({bottom:"-1%"},200,function(){
		loading_interval = setInterval(function (){
		
		loader.innerHTML += ".";
			if(loader.innerHTML == "....")
			{
				loader.innerHTML = "";	
			}
		},2000);
		});
		else $(".loading").animate({bottom:"-10%"},750,function (){
			$(".loading").fadeOut(500);
		loader.innerHTML = "";
		if(loading_interval != null){clearInterval(loading_interval);loading_interval = null;}
	});
}
function default_(){
					doLoading(true);
			$(document).ready(function (){

				var d_ = /[^A-Za-z0-9_]+/;
	var _d = /[A-Za-z0-9_]+/;

			var ad = "/wall/";
			try
			{	
				var l = window.location.toString().split("/");
				var search_str = window.location.toString().split("?search=");
				var li = l[l.length - 1];
				if(li.search(d_) > -1)
					{
						var ll = li.split(d_);
						li = ll[0];	
					}

				if(li.length > 1 && li.indexOf("search") < 0 && li.indexOf("?") < 0 && li.indexOf("#") < 0 )
				{
					
//					li = String(li).replace("#!","");
					ad = "/prof/";

				}
				if(li.length>1 && (li.indexOf("music")>-1 || li.indexOf("video")>-1 ||li.indexOf("picture")>-1 ))
				{
					ad = "/actions/mediacontent.php?<?php echo "type=".$_GET[type]."&mediaID=".$_GET["mediaID"]; ?>";
					
				}
			}
			catch(except)
			{
				
			}
			try
				{
					if(search_str[1].length > 0)
					{
						ad = "/search/?s="+search_str[1];	
					}
				}
				catch(e_s)
				{
					
				}

			try
			{
				var s = window.location.toString().split("#!/search=");
				if(s[1].length > -1)
				{
					var sss = s[1].split("#");
					var ss = sss[0].replace("#","");
					ad = "/search/?s="+ss;
				}
			}
			catch(except2)
			{
				
			}
			var owner = "<?php echo trim($owner);?>";

			owner = owner.indexOf("!") < 0 && owner.indexOf("?") < 0 && owner.length > 0?owner:li;
			$.post(PTH+ad,{owner:owner,aut:"<?php echo $user_login_auth;?>",is_alive:true},function(data){
							doLoading(false);
				$("#_div_").html(data);

				processVars();
					
				try
					{

							eval(document.getElementById("eval_script").value);	
							tabFunc();
						
						}
						catch(err_eval_scr_not_found_or_bad_script)
						{
							//alert(err_eval_scr_not_found_or_bad_script);
						}
				
				}).error(function (){$("#_div_").html("<div class='m_s_g'>The page you tried to access cannot be reached at the moment.</div>");});	
				
				});
		}
	var ownn = false;

function _go(e)
{
	if(document.body.style.backgroundColor != bgcolor)
	{
		$(document.body).animate({backgroundColor:bgcolor},1000);
		prof_color = bgcolor;	
	}
	
				doLoading(true);
	try
	{
		e = e?e:window.event;
		var url = false;
		var id = e.target?e.target:e.srcElement;
		try
		{
			url = id.getAttribute("go");
			if(url == null)
			{
				url = id.parentNode.getAttribute("go");
			}
			if(url == null)
			{
				return false;
			}
		}
		catch(e1)
		{
			url = "/wall/";
		}
		var owner = "<?php echo $user; ?>";
		ownn = id.getAttribute("owner")?id.getAttribute("owner"):false;
		window.location = "#!/"+url;
		$.post(PTH+"/"+url,{user:"<?php echo $user?>",owner:owner,aut:"<?php echo $user_login_auth;?>",is_alive:true},function (data){
			$("#_div_").html(data);
							doLoading(false);
			try
			{
				processVars();
				document.getElementById("nav").scrollIntoView(true);
				tabFunc();
				eval(document.getElementById("eval_script").value);	
			}
			catch(err_eval_scr_not_found_or_bad_script)
			{
				//alert(err_eval_scr_not_found_or_bad_script + "\n" + "_go");
			}
		});
	}
	catch(e22)
	{
		//alert(e22 + "\n _go");
	}
	return false;	
}
function _o(e,owner)
{
					doLoading(true);
	e = e?e:window.event;
	window.location = "#!/"+owner;
	$.post(PTH+"/prof/",{owner:owner,aut:"<?php echo $user_login_auth;?>",is_alive:true},function (data){
						doLoading(false);
	$("#_div_").html(data);
	processVars();
	try
	{

		document.getElementById("nav").scrollIntoView(false);
		tabFunc();
		eval(document.getElementById("eval_script").value);	
		
	}
	catch(err_eval_scr_not_found_or_bad_script)
	{
		alert(err_eval_scr_not_found_or_bad_script + "\n" + "_o");
	}
	});
	return false;	
}

function _st(e,str)
{
	e = e?e:window.event;				doLoading(true);

	if("<?php echo $_SESSION["uid"]?>" != "0")
	{
			window.location = "#!/trend="+str;
	}
	$.post(PTH+"/search/trend.php",{s:str,aut:"<?php echo $user_login_auth;?>",is_alive:true},function (data){
				doLoading(false);
	$("#_div_").html((data));
	$("#leftcolumn").html(_str(	$("#leftcolumn").html()));
	processVars();
	try
	{			
		eval(document.getElementById("eval_script").value);	
		tabFunc();

	}
	catch(err_eval_scr_not_found_or_bad_script)
	{
		alert(err_eval_scr_not_found_or_bad_script);
	}
	});

	return false;
}


function tabFunc()
		{

			try
			{
          			var tabs = $("#tabs").tabs({show:function (event,ui){
					var e = event;
					var attr = e.target.getAttribute("tab");
					if(attr == null)
					{
						var s = $("#tabs").tabs("option","selected");
						var ul = e.target.getElementsByTagName("ul");
						var li = ul[0].getElementsByTagName("li");
						var a = li[s].getElementsByTagName("a");
						
					
						try{
							
						var oc = String(a[0].getAttribute("onclick"));				
						if(oc.indexOf("{") < 0)
						{
							 oc = a[0].getAttribute("onclick");
						}
						else
						{
							oc = oc.replace("onclick","");
							oc = oc.replace("function","");
							oc = oc.replace("()","");
							oc = oc.replace("{","");
							oc = oc.replace("}","");
							oc = a[0].getAttribute("code");													
						}
					 	eval(oc);
						try{	
						a[0].onclick = function (){}
						}catch(e2){}
											
						}catch(_no_code)
						{
						alert(_no_code);
							try{	
									eval(a[0].getAttribute("code"));
								}
								catch(_no_code_2)
								{
									$("#pwin").html("<div align='center'>A critical script error occured<Br/><a href='<?php echo PTH; ?>/' >Continue</a></div>");
									pwin("#pwindow");
									alert(_no_code + "\n tabfunc 11");
								}
							}
					}
					e.target.setAttribute("tab","1");
					},fx: { opacity: 'toggle' } });
				tabs.bind("tabsshow",function (event,ui){return false;});
				/*	
				if(json.tab != null)
				{
					if(json.tab == "#divalb")
					{
						tabs.tabs("option","selected",3);	
					}
				}
				*/
			}
			catch(_noNeed_){
				alert(_noNeed_ + "\n" + "tabFunc()");
			}
		}	
		function ___gomedia(loc)
		{
			try{
			if(loc.indexOf("music=") > -1)
			{

				var l = loc.split("music=");
				
				//_st(null,l[1]);
				_gomedia(l[1],2)
				return false;
			}
			}catch(no_trend){}
			
			try{
			if(loc.indexOf("picture=") > -1)
			{
				var l = loc.split("picture=");
				_gomedia(l[1],1)
				return false;
			}
			}catch(no_trend){}
			
			try{
			if(loc.indexOf("video=") > -1)
			{
				var l = loc.split("video=");
				_gomedia(l[1],3)
				return false;
			}
			}catch(no_trend){}	
			return true;
		}
		var is_active = false;
function __go()
{
	var ad = window.location.toString();
	var noJx = <?php echo $noJx; ?>;
	if(noJx || (ad.indexOf("prof")>-1 || ad.indexOf("mediacontent")>-1)){doLoading(false);return false;}

	var d_ = /[^A-Za-z0-9_]+/;
	var _d = /[A-Za-z0-9_]+/;
	//return;
				doLoading(true);
	try{
			var l2 = window.location.toString().split("/");
			var l3 = window.location.toString().split("#!/search=");
			var l4 = window.location.toString().split("?search=");

			var l = window.location.toString().split("#!/");
			var ll = window.location.toString().split("?");
			
			try{
			if(l[1].indexOf("trend=") > -1)
			{
				var l = l[1].split("trend=");
				_st(null,l[1]);
				return false;
			}
			}catch(no_trend){}
				
			if(!___gomedia(l[1]))return false;
			
			try
			{
				var li = l2[l2.length - 1];
				
				var _dnd_ = ["wall","settings","media","msg","logout","force_web",""];
				var is_user = true;
				for(var u in _dnd_)
				{
					if( li == _dnd_[u])
					{
						is_user = false;
						break;	
					}
				}

			//alert(is_user + "  " + li);
//			alert(li.search(d_));return false;

				if(li.length > 0  && li.indexOf("search=") < 0 && li.search(d_)< 0 && li.indexOf("?") < 0 && is_user)
				{
					default_();
					return false;
				}
				else
				{
					is_user = false;	
				}
			}
			catch(exc)
			{
					//alert(exc);
			}
			
			try
			{
				if(l3[1].length > -1)
				{
					default_();
					return false;
				}
			}
			catch(exc)
			{
					//alert(exc);
			}
			try
			{
				if(l4[1].length > -1)
				{
					default_();
					return false;
				}
			}
			catch(exc)
			{
					//alert(exc);
			}
									
		try{
			 l = l[1].split("#");
			 l = l[0];
		}
		catch(err)
		{
			l = ll[1];	
		}
		if(l.indexOf("force_web=") > -1 || l.indexOf("force_mobile=") > -1)
		{
			l = "wall";	
		}

			if(l.length < 1 && !is_user)
			{
				default_();
				return false;
			}

			$.post(PTH+"/"+l,{user:"<?php echo $user?>",owner:"<?php echo $owner; ?>",aut:"<?php echo $user_login_auth;?>",is_alive:true},function (data){
				doLoading(false);
			$("#_div_").html(data);

				processVars();
				tabFunc();
			try
			{
				eval(document.getElementById("eval_script").value);	
			}
			catch(err_eval_scr_not_found_or_bad_script)
			{
				//alert(err_eval_scr_not_found_or_bad_script);
			}
			}).error(function (){ doLoading(false);$("#_div_").html("<div class='m_s_g'>The page  &lsquo;"+l+"&rsquo; you tried to access cannot be reached at the moment.</div>");
			try
			{
				if(l == "wall")
				{
			//		window.location = "#!/wall";
			//		__go();
				}
			}
			catch(lex){}
			});	
	}
	catch(no_query_string){
	//	alert(no_query_string+" ___go");
			default_();	
	}
}

$(document).ready(function (e){
	
	<?php
	if(!isset($_GET["mediaID"]) && !isset($_GET["i"]) && !isset($_GET['search']))
	{
	?>
	
		__go();	
		<?php
	}

		?>
//		$("html").niceScroll({cursorcolor:'#555',cursoropacitymax:0.9,boxzoom:false,touchbehavior:false});
suggests_();
setInterval(function (){vary_time("_div_")},20000);

});
	window.onhashchange = function (e){
	
	var loc = window.location.toString();
	if(loc.indexOf("#!/music")>-1 || loc.indexOf("#!/picture")>-1 || loc.indexOf("#!/video")>-1)
	{return;}
	var hash = window.location.hash;
	if(hash.toString().length < 5 || is_active ||hash.toString().indexOf("!")<0)
	return;
	__go();

	}
	var _$ = function (id)
	{
		return document.getElementById(id);	
	}
</script>
<script src="<?php echo PTH; ?>/scripts/msg.js"  type="text/javascript"></script>
<script src="<?php echo PTH; ?>/scripts/chattt.js"  type="text/javascript"></script>
<script src="<?php echo PTH; ?>/scripts/dragme.js"  type="text/javascript"></script>
<?php 
if($_SESSION["uid"] == 0)
{
	echo "<input type='hidden' id='guest' value='user'/>";	
}

?>
<script>
//function alert(msg)
//{
//	$("#pwin").html("<h3 align='center'>MuzikKitchen: Message</h3><div style='font:15px Verdana;padding:0 10px 10px 10px;'>"+msg.toString()+"</div>");	
//	pwin("#pwindow");
//}

function _remove_media(node){node.parentNode.removeChild(node);node = null;}
var js,po,jss;
function _share_media()
{
	
	(function(d, s, id) {
	  var fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.async = true;
	  js.src = "//connect.facebook.net/en_US/all.js?mk="+Math.floor(Math.random(1000,9999)*8000)+"#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	(function() {
		po = document.createElement('script'); po.type = 'text/javascript';
		po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	!function(d,s,id){var fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){jss=d.createElement(s);jss.id=id;
	jss.src="https://platform.twitter.com/widgets.js";
	jss.async=true;fjs.parentNode.insertBefore(jss,fjs);}}(document,"script","twitter-wjs");
}
window.onbeforeunload = function (e)
{
	
}
</script>
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
</body>
</html>
