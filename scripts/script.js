//muzik kitchen m js
var _str = function (str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("-http://");
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = "";
					if (hr[0].lastIndexOf(".jpg") > -1 || hr[0].lastIndexOf(".png") > - 1 || hr[0].lastIndexOf(".gif") > - 1 || hr[0].lastIndexOf(".bmp") > -1) {
						var img = document.createElement("img");
						img.src = "http://"+hr[0];
						istr = "<i style='font-size:8px;'><img src='http://" + hr[0] + "' height='50' width='60'/><br/>view Image</i>";
//						img.onreadystatechange = function (){
							//if(img.readyState != 4)
							//{
								//istr = "http://"+hr[0];
						//	}
	//						alert(img.readyState);
		//				}
					}
					else{		
					istr = "http://"+hr[0];
					}
					var ar = "<a href='http://"+hr[0]+"' target='_blank' title='"+hr[0]+"'>"+istr+"</a>";
					str = str.replace("-http://"+hr[0]+" -",ar);	
				}
				return mention(str.toString());
			}
	
			function tcm(str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("_#");
				var d_ = /[^A-Za-z0-9]+/;
				var _d = /[A-Za-z0-9]+/;

				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var t_ = istr.replace(d_,"");
					var _t = istr.replace(_d,"");
					istr = t_;
					var ar = "#<a href='./#!/trend="+istr+"' onclick='return _st(event,\""+istr+"\")'>"+istr+"</a>"+_t;
					str = str.replace("_#"+hr[0]+" _",ar);	
				}			
				return _media_music_(str);		
			}

			function mention (str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("_@");
				var d_ = /[^A-Za-z0-9_]+/;
				var _d = /[A-Za-z0-9_]+/;
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var t_ = istr.replace(d_,"");
					var _t = istr.replace(_d,"");
					istr = t_;//onmouseover='_pop(event,\""+istr+"\")'
					var ar = "@<a href='./"+istr+"' onclick='return _pop(event,\""+istr+"\")'>"+istr+"</a>"+_t;
					str = str.replace("_@"+hr[0]+" _",ar);	
				}
				return tcm(str.toString());
			}
			
			
			function _media_music_ (str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("[music:");
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var ar = "<a class='muzik_item' href='./music-"+istr+"' tid='"+istr+"' type='1' onclick='ajax_media(event);return setURI(\"music\","+istr+")'>[<b tid='"+istr+"' type='1'>music:</b>"+istr+" ]</a>";
					str = str.replace("[music:"+hr[0]+" ]",ar);	
				}
				return _media_art_(str.toString());
			}
			var img_load_array = Array();
			var img_load_num = 0;
			var img_done_load= Object();
			function load_img_async()
			{
				if(img_load_array.length == 0)return;
				var istr = img_load_array[img_load_num];
				if(img_load_num == img_load_array.length - 1){img_load_num=0;return;}	
				try
				{
					var img = document.getElementById("_dyn_art_"+istr);					
					if(img.style.backgroundImage!=""){img_load_num++;load_img_async();return;}
					if(img_done_load[img.id])
					{img.style.backgroundImage = img_done_load[img.id];img_load_num++;load_img_async();return;}

					$.post(PTH+"/actions/json_pic.php",{pid:istr},function (data){
					
						var json_res = eval(data);
						
						img.style.backgroundImage = "url("+PTH+""+json_res.medium+")";						
						img_done_load[img.id] = img.style.backgroundImage;
						img_load_num++;
						if(img_load_num == img_load_array.length)
						{
							img_load_num = 0;
						}
						else
						{
							load_img_async();	
						}
					
				}).error(function (){ load_img_async();});
				}
				catch(ee)
				{
					
					img_load_num++;
					load_img_async();
						
				}
			
			}
			function _media_art_ (str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("[art:");
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var ar = "<a href='./picture-"+istr+"'class='art_items' tid='"+istr+"' type='0' onclick='ajax_media(event);return setURI(\"picture\","+istr+")'><div class='dyn_img'  id='_dyn_art_"+istr+"' tid='"+istr+"' type='0'><span class='hd_id' tid='"+istr+"' type='0'>[<b tid='"+istr+"' type='0'>art:</b>"+istr+" ]</span></div></a>";//
					img_load_array.push(istr);				
					str = str.replace("[art:"+hr[0]+" ]",ar);	
				}
				return _media_video_(str.toString());
			}
			function _media_video_ (str)
			{
				str = str.toString();
				str = " " + str + " ";
				var a = str.split("[video:");
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var ar = "<a href='./video-"+istr+"' class='vid_item' tid='"+istr+"' type='2' onclick='ajax_media(event);return setURI(\"video\","+istr+")'>[<b tid='"+istr+"' type='2'>video:</b>"+istr+" ]</a>";
					str = str.replace("[video:"+hr[0]+" ]",ar);	
				}
				return (str.toString());
			}
	
var edit_user = function (e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var uid = id.getAttribute("user");
	//id.parentNode.parentNode.parentNode.parentNode.parentNode.id == edit_div
	$.post(PTH+"/admin/edituser.php",{user:uid,edit:true},function(data){
	$("#edit_div").html(data);
	});
}

function anim(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({opacity:0.8},500,function(){
	
		});	
}
function anim2(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({opacity:1},500,function(){
	
		});	
}
function processVars()
{
	try{
		$(document).ready(function() {	
	 	//$('a').animate({color:prof_color},500);
	 	//$('#bnum').animate({color:prof_color},500);
		$("#box ul li").animate({color:prof_color},500);
		//$(".profilepic").css({backgroundColor:prof_color});
		//$(".smpdiv").css({backgroundColor:prof_color});
		$(".vid_prev").css({backgroundColor:prof_color});
		//$(".ssmpdiv").css({backgroundColor:prof_color});
		//$(".mpdiv").css({backgroundColor:prof_color});
		$(".post").css({borderColor:prof_color});
		$(".num,#bnum").css({color:prof_color});
		$(".button1").css({backgroundColor:prof_color});
		$(".loading").css({borderColor:prof_color});
		//$(".preply").css({backgroundColor:prof_color});
		//$(".delete").css({backgroundColor:prof_color});
		//$(".prefeed").css({backgroundColor:prof_color});
		//$(".like").css({backgroundColor:prof_color});
		$("#show_more").css({backgroundColor:prof_color});
		//$(".chit").css({backgroundColor:prof_color});
		$("#dialogpicture").css({backgroundColor:prof_color});
		//$("#userwindow").css({backgroundColor:prof_color});
		$("#dialogvideo").css({backgroundColor:prof_color});
//		$(".prof_table").animate({boxShadow:"0px 1px 12px "+prof_color},500);

    	$(".ui-state-default").animate({backgroundColor:prof_color},500);
//		$(".ui-state-active < a").animate({color:prof_color},500);

		
		$("#dialog").animate({backgroundColor:prof_color},500);
		

		$("#pwindow").animate({backgroundColor:prof_color},500);
		
		$(".chatbtt").animate({backgroundColor:prof_color});

		$(".title").animate({backgroundColor:prof_color},500);
	
		//$("#panel").animate({backgroundColor:prof_color},500);
		generate_tips("title_id");
		});
	}catch(eee){}

	load_img_async();
}
var _textgrow = function(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({fontSize:"15px"},500);	
	id.onmouseout = function ()
	{
		$(id).animate({fontSize:"9px"},500);	
	}
}
function _music()
{
		$("#music").fadeToggle(400);
		$("#video").hide();
		$("#art").hide();
		return false;
}
function _art()
{
		$("#art").fadeToggle(400);
		$("#music").hide();
		$("#video").hide();
		return false;
}

function _video()
{
		$("#video").fadeToggle(400);
		$("#music").hide();
		$("#art").hide();
		return false;
}
function playvideo(e)
{
	if(e.status == true)
	{
		var video = e.video;
		var prev = e.prev;
		var vdate = e.vdate;
		var vname = e.vname;
		var info = e.title;
		var vid = e.vid;
		var owner = e.owner;
		var uid = e.uid;
	}
	else
	{
		e = e?e:window.event;
		var id 	= e.target?e.target:e.srcElement;
		var video = id.getAttribute("video");
		var prev = id.getAttribute("prev");
		var vdate = id.getAttribute("vdate");
		var vname = id.getAttribute("vidname");
		var info = id.getAttribute("title");
		var vid = id.getAttribute("vid"); 
		var owner = id.getAttribute("owner");
		var uid = id.getAttribute("uid"); 
	}
	var href = "<i style='font-size:10px;'>Uploaded by <a href='./" + owner + "' onclick='return _pop(event,"+uid+")'>"+owner+"</a> "+ vdate+"</i><br/><br/><a href='#' onclick='_gomedia("+vid+",3)'>Post Comment</a>";
		document.getElementById("is_playing").value = "<b><img src='"+PTH+"/img/vid.png' />" + vname + "</b>";
		now_playing(2,vid);
	$("#video_html_vars").html('<div style="width: 550px; height: 400px;" id="mediaplayer_wrapper"><object tabindex="0" name="mediaplayer" id="mediaplayer" bgcolor="#000000" data="'+PTH+'/player/player.swf" type="application/x-shockwave-flash" height="400" width="550"><param value="true" name="allowfullscreen"><param name="Movie" value="'+PTH+'/player/player.swf" /><param name="Src" value="'+PTH+'/player/player.swf"><param value="always" name="allowscriptaccess"><param value="true" name="seamlesstabbing"><param value="opaque" name="wmode"><param value="id=mediaplayer&amp;file=..%2Fvideo%2F'+video+'&amp;image=.%2Fprev%2F'+prev+'&amp;controlbar.position=over&amp;title='+vname+'&amp;author=muzikkitchen.com&amp;description='+info+'&amp;date='+vdate+'" name="flashvars"><embed src="'+PTH+'/players/player.swf" height="400" width="550" /></object></div>');
	$("#footnotediv").html(_str("<b>" + vname + "</b><br/>" + info + "<br/>" + href));
		$("#nowplaying").html(vname);
	
	var nowplaying = document.getElementById("nowplaying");
	nowplaying.parentNode.onclick = function ()
	{
			pwin("#dialogvideo");	
	}
//	var div = new createCommentDiv(vid,3,uid);
//	$("#footnotediv").append(div);
		pwin("#dialogvideo");	
		_$("dialogvideo").scrollIntoView();	
}
function _show(e)
{
	e  = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var res = "";
	for(var x in id)
	{
		res += x + " ::>" + id[x] + "<br/>";	
		
	}
//	document.writeln(res);
}

var _tggle_ = function (e)
{
	try{
	e = e ? e:window.event;	
	var id = e.target?e.target:e.srcElement;}
	catch(ee){}	
	$("#dialog").animate({opacity:50,top:"-100px"},500,function (){
		$("#dialog").css({top:"-500px"});
		});	
	
	if(id.className=="min")
	{
		//id.className="max";

	//	$("#dialog").animate({height:23+"px",opacity:0.1},1000);	
	}
	else
	{
//		id.className="min";
		//$("#dialog").animate({height:125+"px",opacity:1},500);
	}
}
function getAllmusicOnScreen(mid)
{
//	var m_dir = new Array();
//	var m_tit = new Array();
	var mdir = "";
	var mtit = "";
	if(mid)
	{
		
	}
	var ul = document.getElementById("plid");
	var li = ul.getElementsByTagName("li");
	for(var m in li)
	{
		if(li[m].className == 'muzik_item')
		{
			if(mid != li[m].getAttribute("mid"))
			{
				mdir += "|./music/"+li[m].getAttribute("music");
				mtit += "|"+li[m].getAttribute("mname");
				//m_dir.push(PTH+"/music/"+li[m].getAttribute("music"));
				//m_tit.push(li[m].getAttribute("mname"));
			}
		}
	}
	return new Array(mdir,mtit);
}
function playmusic(e)
{
	var color = php_color.replace("#","");
	pwin("#dialog");
	_$("dialog").scrollIntoView();

	if(e.status == true)
	{
		var music = PTH+"/music/"+e.music;
		var mdate = e.mdate;
		var mname = e.mname;
		var info = e.title;
		var mid = e.mid
		var owner = e.owner
		var uid = e.uid;		
	}
	else
	{
		e = e?e:window.event;		
		var id 	= e.target?e.target:e.srcElement;
		var music = PTH+"/music/"+id.getAttribute("music");
		var mdate = id.getAttribute("mdate");
		var mname = id.getAttribute("mname");
		var info = id.getAttribute("title");
		var mid = id.getAttribute("mid");
		var owner = id.getAttribute("owner");
		var uid = id.getAttribute("uid"); 
	}
	var list = getAllmusicOnScreen(mid);
	if(info.length > 500)
	{
		info = "<span style='font-size:12px;'>"+info+"</span>";	
	}
		
	var href = "<i style='font-size:10px;'>Uploaded by <a href='./" + owner + "'  onclick='return _pop(event,"+uid+")'>"+owner+"</a> "+mdate+"</i><br/><br/><a href='#' onclick='_gomedia("+mid+",2);$(\"#dialog\").fadeOut(300);'>Post Comment</a>";
	document.getElementById("is_playing").value = "<b>" + mname + "</b>";
	now_playing(1,mid);
	//$("#div_audio_player").html('<audio height="30" onclick="_show(event)" loop="loop" width="auto" autoplay id="myaudio" preload="auto" autobuffer controls><source src="'+music+'" ></source></audio>');
	var width = (href_width - 66) > 0 ? (href_width - 66): 300;
	
	$("#div_audio_player").html('<div class="player" style="padding:10px;"><object type="application/x-shockwave-flash" data="'+PTH+'/player/player_mp3_multi.swf" width="'+width+'" height="100">                     <param name="movie" value="'+PTH+'/player/player_mp3_multi.swf" />                   <param name="FlashVars" value="mp3='+music+list[0]+'&amp;title='+mname+list[1]+'&amp;autoplay=1&amp;bgcolor1='+color+
	'&amp;bgcolor2='+color+'&amp;buttoncolor=ffffff&amp;buttonovercolor='+color+'&amp;width='+width+'&amp;showvolume=1&amp;showinfo=0&amp;sliderovercolor='+color+'&amp;showplaylistnumbers=1&amp;textcolor='+color+'&amp;&amp;repeat=1&amp;shuffle=0&amp;height=100" /> </object>            </div> ');
	//$("#div_audio_player").html('<object type="application/x-shockwave-flash" data="'+PTH+'/player/dewplayer-multi.swf?autostart=yes&mp3='+music+'|'+music+'|'+music+'" height="20" width="240" id="dewplayer"><param name="wmode" value="transparent" /><param name="movie" value="'+PTH+'/player/dewplayer-multi.swf?autostart=yes&mp3='+music+'|'+music+'|'+music+'" /></object>');
	//var dewp = document.getElementById("dewplayer");
 // if(dewp!=null) dewp.dewplay();
	//$("#div_audio_player").html('<embed wmode="transparent" style="height:24px;width:100%;" src="'+PTH+'/player/beemp3.swf" quality="high" bgcolor="#ffffff" width="100%" height="24" align="center" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="playerID=1&autostart=yes&loop=yes&bg=0x000000&leftbg=0x357DCE&lefticon=0xF2F2F2&rightbg=0xaaaaaa&rightbghover=0x555555&righticon=0xF2F2F2&righticonhover=0xFFFFFF&text=0xdddddd&slider=0x357DCE&track=0xFFFFFF&border=0xbbbbbb&loader=0x888888&soundFile='+music+'"></embed>');
	//$("#div_audio_player").html('<object type="application/x-shockwave-flash" data="'+PTH+'/player/dewplayer-vol.swf?mp3='+music+'&autostart=true" id="dewplayer-vol" height="20" width="340"><param name="wmode" value="transparent"><param name="movie" value="'+PTH+'/player/dewplayer-vol.swf?mp3='+music+'"></object>');
	
//	$("#div_audio_player").html('<object type="application/x-shockwave-flash" data="'+PTH+'/player/player_mp3_maxi.swf" width="300" height="20"><param name="movie" value="'+PTH+'/player/player_mp3_maxi.swf" /> <param name="FlashVars" value="mp3='+music+'&amp;showinfo=1&amp;textcolor=666666&amp;buttoncolor=666666&amp;buttonovercolor=000000&amp;bgcolor1=f5f5f5&amp;bgcolor2=cccccc&amp;sliderovercolor=333333&amp;autostart=true" /></object> ');
	$("#nowplaying").html(mname);
	var nowplaying = document.getElementById("nowplaying");
	nowplaying.parentNode.onclick = function ()
	{
			$("#dialog").animate({opacity:1},500);
			pwin("#dialog");	
	}
	
$("#footnote").html(_str("<b>" + mname + "</b><br/>" + info + "<br/>" + href ));
//var div = new createCommentDiv(mid,2,uid);
//	$("#footnote").append(div);

}

function playart(e)
{
	if(e.status == true)
	{
		var art = e.art;
		var adate = e.adate;
		var aname = e.aname
		var aid = e.aid;
		var owner = e.owner;
		var uid = e.uid;
		var info = e.title;
	}
	else
	{
	e = e?e:window.event;
	
	var id 	= e.target?e.target:e.srcElement;
	var art = id.getAttribute("art");
	var adate = id.getAttribute("adate");
	var aname = id.getAttribute("aname");
	var aid = id.getAttribute("aid");
	var owner = id.getAttribute("owner");
	var uid = id.getAttribute("uid"); 
	var info = id.getAttribute("title");
	}
	var href = "<i style='font-size:10px;'>Uploaded by <a href='./" + owner + "'  onclick='return _pop(event,"+uid+")'>"+owner+"</a> "+ adate +"</i><br/><a href='#' onclick='_gomedia("+aid+",1)'>Post Comment</a>";
	
	var fullart = PTH+"/art/full_"+ String(art).substr(6,art.length);
	$("#art_html_vars").html("<a href='./picture-"+aid+"' onclick='_gomedia("+aid+",1);return setURI(\"picture\","+aid+")'><div align='center'><img src='"+art+"' id='current_img'/></div><div class='main_art' style='background: url("+art+") no-repeat center;display:none;'></div></a>");
	$("#footnoteart").html(_str("<a href='"+fullart+"' target='_blank'>View Full Image</a><br/><b>" + aname + "</b><br/>" + info + "<br/>" + href ));
	//var div = new createCommentDiv(aid,1,uid);
	
//	document.getElementById("footnoteart").appendChild(div);
	//$("#footnoteart").append(div);
	
	pwin("#dialogpicture");
}
function createCommentDiv (cid,type,owner)
{
	var div = document.createElement("div");
	div.id = "comment_div"+type;
	div.style.marginTop = "10px";
	div.innerHTML = "<i style='color:#ddd;font-size:10px;text-align:center;'>loading comments...</i>";
	div.style.display = "none";
	getcom(cid,type,div,owner);
	return div;
}
function getcom (cid,type,div,owner)
{
	$.post(PTH+"/actions/comment.php",{action:1,cid:cid,type:type,owner:owner},function (data){	
	
		document.getElementById("comment_div"+ type).innerHTML = _str(data);

		$(div).fadeIn(500);
		});
}

function _com (e,type,cid,owner)
{
	try{
	var txtcom = document.getElementById("txtcom_"+type);
	var txt = txtcom.value;	

	if(txt.length < 1)
	{
		return false;	
	}
	txtcom.disabled = true;
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	id.disabled = true;
	$.post(PTH+"/actions/comment.php",{type:type,cid:cid,action:2,post:txt,owner:owner},function (data){
		getcom(cid,type,"comment_div"+ type,owner);		
	});
	}catch(err){alert(err);}
}
function _delcom(e,type,id)
{
	pwin("#pwindow");	
	$("#pwin").html("<div align='center'>Are you sure you want to delete this comment?<Br/><input type='button' value='Delete' class='button1' onclick='_delcom_("+type+","+id+")' /></div>");
}
function _delcom_(type,id)
{
	$.post(PTH+"/actions/comment.php",{action:3,type:type,id:id},function (data){
		if(parseInt(data) ==1)
		{				
			$("#pwindow").fadeOut(200,function (){$(".comment_"+id).fadeOut(200);});
		}
	});	
}
//double click on tabs to reload them//

function tab_click(e,url)
{
	doLoading(true);
	var code = false;
	try{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	//var code = id.getAttribute("code");
	}catch(e2){	}
	var code = document.getElementById("_main_")?2:3;
//	var href = id.href.toString().split("#");
	
		var href = url.toString().split(".php");
		if(href[0]=="mention"){code=4;}
		if(href[0] == "like_"){code=5;}
		var s = $("#tabs").tabs("option","selected");
		
		var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
		if(document.getElementById("_main_") && s > 0)
		{
			window.location = "#"+href[0];
		}
		$.post(PTH+"/actions/"+url,{session_auth:true,code:code,owner:owner},function (data){
		doLoading(false);
		var divs =	document.getElementById(href[0]).childNodes;
		
		var divd = false;
		for(var d in divs)
		{
			if(divs[d].className=='div_d')	
			{
				divd = divs[d];
				break;
			}
		}
		if(href[0] == "main")
		{
			try{
			var divss = $(".new_1");
			for(var dd in divss)
			{
				if(divss[dd].className=='new_1')	
				{
					divss[dd].parentNode.removeChild(divss[dd]);	
				}
			}
			}catch(e3){}
		}
		$(divd).html(_str(data));
		
		//$("#"+href[0]).html();
		processVars();
		//load_img_async();
		//ajax_re_get_script();
			});
			//try{eval(id.getAttribute("code"));}catch(e4){alert(e4);}
		try{	
				id.onclick = function (){
					
				}
				id.ondblclick = function ()
				{
					try{
					tab_click(e,url);
					}catch(e2){}
				}
			}
			catch(e3){
				//alert(e3+"\n tab_click");
				}
}


function tab_vclick(e,url)
{
	doLoading(true);
	e = e?e:window.event;
	try{
	var id = e.target?e.target:e.srcElement;
	var code = id.getAttribute("code");
	var href = id.href.toString().split("#");
	}
	catch(_no_e)
	{
		var s = $("#tabs").tabs("option","selected");
	
						var ul = e.target.getElementsByTagName("ul");
						var li = ul[0].getElementsByTagName("li");
						var a = li[s].getElementsByTagName("a");
						var href = a[0].href.toString().split("#");
	}
	//var href = url.toString().split(".php");
	var owner = document.getElementById("owner")?document.getElementById("owner").value:false;
	if(!owner){return false;}
	
						
		if(document.getElementById("_main_"))
		{
			window.location = "#"+href[1];
		}
		$.post(PTH+"/actions/"+url,{session_auth:true,owner:owner},function (data){
			doLoading(false);
		$("#"+href[1]).html(data);
		processVars();
			});
			try{eval(id.getAttribute("code"));}catch(e4){alert(e4 + "\n" + "tab_vclick");}
		try{
						
				id.onclick = function (){
			
				}
				id.ondblclick = function ()
				{
					try{
					tab_vclick(e,url);
					}catch(e2){}
				}
			}
			catch(e3){}
}

var ff = function (e,u2)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	id.onclick = function (){}
	$.post(PTH+"/actions/follow.php",{u2:u2},function (data)
		{
//			alert(data);
			if(parseInt(data) == 1)
			{
				id.className = "unff";
				id.title='undine with';
			}
			else if(parseInt(data) == 2)
			{
				id.className = "ff";	
				id.title='dine with';
			}
				id.onclick = function (){
					ff(e,u2);
					
					}
			//alert(data);
			try
			{
			var pop_hd = document.getElementById("pop"+u2);
			pop_hd.parentNode.removeChild(pop_hd);
			}catch(ee){}
		});
	if(id.toString().indexOf("image") > -1)
	{
		
	}
	else
	{
		return false;
	}
}
function _s(e)
{
	//e = e?e:window.event;
				doLoading(true);
	var id = e;//.target?e.target:e.srcElement;
	var txt = id.childNodes[0].value;
	window.location = "#!/search="+txt;		
	$.post(PTH+"/search/",{session_is:true,s:txt},function (data){
		$("#_div_").html(data);		
						doLoading(false);
		try
		{
			
			eval(document.getElementById("eval_script").value);	
			
		}
		catch(err_eval_scr_not_found_or_bad_script)
		{
			alert(err_eval_scr_not_found_or_bad_script);
		}		
		});
		return false;
}
function __s(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var txt = id.value;
	if(txt.toString().length < 3){return false;}
	$.post(PTH+"/search/s.php",{session_is:true,s:txt},function (data){
		$("#_s").html(data);
		var show = false;

		$("#_s").slideDown(300,function (){
			
			id.onmouseout = function ()
			{
				setTimeout(function(){
					if(!show){
				$("#_s").slideUp(200);}},2000);	
			}
			document.getElementById("_s").onmouseout = function ()
			{
				show = false;
				setTimeout(function(){
					if(!show){
				$("#_s").slideUp(200);}},2000);	
			}
			});
		id.onmouseover = function (){show = true;$("#_s").slideDown(300)}
		document.getElementById("_s").onmouseover = function (){show = true;$("#_s").slideDown(300);}				
	});
		return false;
}
//postting reply and repost//






var _more = function (e,type,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
	id.onclick = function (){return false;}
	id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
	$.post(PTH+"/actions/main.php?code=" + type,{page:page,owner:owner},function (data){
	id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
//	load_img_async();
	processVars();
	});
}

var _more_hist = function (e,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
		id.onclick = function (){return false;}
		id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
	$.post(PTH+"/actions/plate.php",{page:page},function (data){
id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
				processVars();
	});
}

var _more_st = function (e,s,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
		id.onclick = function (){return false;}
		id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	//var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
	$.post(PTH+"/search/trend.php",{page:page,s:s},function (data){
id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
	//load_img_async()
				processVars();
	});
}
var _vmore = function (e,type,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
			id.onclick = function (){return false;}
				id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
	$.post(PTH+"/actions/"+type,{page:page,owner:owner},function (data){
	id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
	//load_img_async();
				processVars();
	});
}
var _more_search = function (e,arg,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
			id.onclick = function (){return false;}
		id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	$.post(PTH+"/search/?s=" + arg,{page:page},function (data){
			id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
//load_img_async();
				processVars();
	});
}

var _more_reposts = function (e,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
		id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
			id.onclick = function (){return false;}
	$.post(PTH+"/actions/reposts.php",{page:page},function (data){
	id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
				processVars();
				//load_img_async();
	});
}

var _ment_ = function (e,user,arg)
{
	try
	{
		e = e ? e:window.event;
		var id	= e.target?e.target:e.srcElement;
		var txts = id.parentNode.parentNode.getElementsByTagName("textarea");
		var _d = false;
		var txt = false;
		
		for(var t in txts)
		{
			if(txts[t].id == "txtdiv" || txts[t].className == "txtdiv" || txts[t].className == "txt")
			{
				txt = txts[t];	
				_d = true;
				break;
			}
		}
		if(!_d)
		{
			txts = id.parentNode.parentNode.getElementsByTagName("input");
			
			for(var t in txts)
			{
				if(txts[t].className == "txt" && txts[t].type == "text")
				{
					txt = txts[t];	
					_d = true;
					break;
				}
			}
			
		}
		
		if(txt)
		{
			var v = txt.value;
			var i = v.lastIndexOf("@");
			txt.value = v.substr(0,i) + "@"+user;
	//		var val = v.replace(arg,user);
	//		txt.value = val.substr(0,(val.length - 1));	
		}
	}
	catch(e1)
	{
		
	}
	return false;
}

var _post= function (e){
	
	if(!_isvalidpost)
		{
			return false;
		}
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	id.disabled = true;
	var txtdiv = document.getElementById("txtdiv");

	var post = txtdiv.value;
	var ttt = _chkmaxlength(txtdiv);
	if(!ttt)
	{

		return false;
	}
	txtdiv.disabled = "disabled";
//	alert(post);
	$.post(PTH+"/actions/post.php",{post:post,client:1,loc:1,rid:0,type:0},function (data){
		txtdiv.disabled = false;
		id.disabled = false;
		if(data == 1){
			txtdiv.value = "";
		}else
		{
			//alert(data);
//			pwin("#pwindow");	
		}
		
	});
	
	
	}
	var tb_del_var = false;
	var _del = function (e,id)
	{
		e = e?e:window.event;
	//	var d = e.target?e.target:e.srcElement;	
	pwin("#pwindow");	
		$("#pwin").html("<div style='font-size:15px;' class='pwndiv' align='center'>Are you sure you want to delete this post<br/><br/><input type='button' name = 'Delete' onclick='__del("+id+")' class='button1' value='Delete'></div>");	
	}
	var __del = function (id)
	{
		try{
			var pp = document.getElementById("post"+id);					//tb_del_var.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
		$.post(PTH+"/actions/del_post.php",{id:id},function (data){

		if(parseInt(data) == 1)
		{
			try{
			pp.parentNode.removeChild(pp);
			}catch(ee){}
			$("#pwindow").fadeOut(500);
			//tb_del_var = false;	
		}
		else
		{
				$("#pwin").html("<div style='width:100%;font-size:15px;' align='center'>Error deleting post</div><br/><input type='button' name = 'Delete' onclick='__del("+id+")' class='button1' value='Try Again'></div>");
		}
			
			});	
		}catch(ee){alert(ee + "\n" + "__del");}
	}
	
	function _reply(e)
	{
		try
		{
		e = e ? e : window.event;
		var id = e.target?e.target:e.srcElement;
		id = id.parentNode;
		var u = id.getAttribute("u");
		var rid = id.getAttribute("rid");
		var txt = new createTextarea();
		txt.setAttribute("u",u);
		txt.setAttribute("rid",rid);
	//	var post = get_post_text(id);
	
		var pwind = document.getElementById("pwin");
		pwind.innerHTML = "<b></b><br/>";
		pwind.appendChild(txt);
		var vd = document.createElement("div");
		vd.className = "pl2div";
		pwind.appendChild(vd);
		vd.onclick = function (){$(vd).slideUp(200);}
		//pwin.innerHTML += '<div class="pl2div"></div>'; 
		var post = document.getElementById("post_span_"+rid);
		$(txt).text(" Re: @"+ u );

		pwind.innerHTML  = pwind.innerHTML + "<Br/>";
		var butt = new createButton();
		butt.value = "Reply";
		pwind.innerHTML = pwind.innerHTML + "<b style='font-size:13px;'>Reply <a href='./"+u+"' onclick='return _o(event,\""+u+"\")'  >@"+u+": </a><i style='color:#fff;font-size:12px;'>"+$(post).text()+"</i></b><br/>";
		var butt2 = new createButton();
			butt2.style.cssFloat = "left";
			butt2.value = "Add media";
			butt2.onclick = function (event)
						{
							get_media(event?event:window.event);
						}
			
					butt.onclick = function (event){
					_dpost(event?event:window.event,1);
						
						}
			pwind.appendChild(butt2);
		pwind.appendChild(butt);
					processVars();
		txt.focus();
		
			}catch(eer){alert(eer + "\n" + "_reply");}
			pwin("#pwindow");
					return false;
	}	
	
	function _repost(e)
	{
		try
		{
		e = e ? e : window.event;
		var id = e.target?e.target:e.srcElement;
		id = id.parentNode;
		var u = id.getAttribute("u");
		var rid = id.getAttribute("rid");
		var txt = new createTextarea();
		txt.setAttribute("u",u);
		txt.setAttribute("rid",rid);
		var post = document.getElementById("post_span_"+rid);
	
		var pwind = document.getElementById("pwin");
		pwind.innerHTML = "<b></b><br/>";
		pwind.appendChild(txt);
		
		var vd = document.createElement("div");
		vd.className = "pl2div";
		pwind.appendChild(vd);
		vd.onclick = function (){$(vd).slideUp(200);}
		$(txt).text("RF: @"+ u + " "+$(post).text());
//		pwind.innerHTML = pwind.innerHTML + "<b style=''>ReFeed</b><Br/>";
		pwind.innerHTML  = pwind.innerHTML + "<Br/>";
		var butt = new createButton();
		butt.value = "ReFeed";
		
		
		var butt2 = new createButton();
			butt2.style.cssFloat = "left";
			butt2.value = "Add media";
			butt2.onclick = function (event)
						{
							get_media(event?event:window.event);
						}
			
			butt.onclick = function (event){
					_dpost(event?event:window.event,2);
						
						}
			pwind.appendChild(butt2);
		pwind.appendChild(butt);
					processVars();
		txt.focus();
		
			}catch(eer){alert(eer + "\n" + "_repost");}
			pwin("#pwindow");
		return false;
	}	
	var get_post_text = function (id)
	{
		var post_div = id.parentNode.parentNode.parentNode.parentNode.getElementsByTagName("span");
		for(var i in post_div)
		{
			if(post_div[i].className == "_post")
			{
				return post_div[i];
				break;
			}
		}
	}
	function new_post(e)
	{
		try
		{
			e = e ? e : window.event;
			var id = e.target?e.target:e.srcElement;
			
			var txt = new createTextarea();
			txt.setAttribute("u",0);
			txt.setAttribute("rid",0);
			//var post = get_post_text(id);
		
			var pwind = document.getElementById("pwin");
			pwind.innerHTML = "<b></b><br/>";
			pwind.appendChild(txt);
			var vd = document.createElement("div");
		vd.className = "pl2div";
		pwind.appendChild(vd);
		vd.onclick = function (){$(vd).slideUp(200);}
//			pwind.innerHTML += '<div class="pl2div"></div>'; 
	
			//$(txt).text("RP: @"+ u + " "+$(post).text());
	
			pwind.innerHTML  = pwind.innerHTML + "<Br/><br/>";
			var butt = new createButton();
			butt.value = "Feed";
			butt.style.cssFloat = "right";
			butt.style.marginLeft = "200px";
			var butt2 = new createButton();
			butt2.style.cssFloat = "left";
			butt2.value = "Add media";
			butt2.onclick = function (event)
			{

				get_media(event?event:window.event);
			}

			butt.onclick = function (event)
			{
				_dpost(event?event:window.event,0);
			}
			pwind.appendChild(butt2);
			pwind.appendChild(butt);
			processVars();
//			txt.focus();
			
		}
		catch(eer){}
			pwin("#pwindow");	
	}	
	
	var createTextarea = function ()
	{
			var txt = document.createElement("textarea");
			txt.className = "txtdiv";
			txt.setAttribute("onkeyup","gment(event);fixlength(event);");
			//txt.setAttribute("onkeydown","");
			return txt;
	}
	var txtdiv_val = "";
	var _isvalidpost = true;
	var fixlength = function (e)
	{
		
		e = e ? e:window.event;
		var id = e.target?e.target:e.srcElement;
		var b = id.parentNode.childNodes[0];
		var total = 225;
		b.innerHTML = (total - id.value.length);
		if(id.value.length > 200)
		{
			b.style.color = "red";	
		}
		else
		{
			b.style.color = "#777";	
		}
		if(id.value.length == total)
		{
			_isvalidpost = true;
			txtdiv_val = id.value;
		}
		
		if(id.value.length > total)
		{
			_isvalidpost = false;
			//id.value = txtdiv_val;	
		}
		if(id.value.length < total)
		{
			_isvalidpost = true;	
		}
		
	}
	var gment = function (e)
	{
		e = e ? e:window.event;
		var id = e.target?e.target:e.srcElement;
		var last = id.value.lastIndexOf("@");

		var start = id.value.length - last;
		
		if(last > -1)
		{
			if(id.value.length < 2)
			{
				id.value = " " +id.value;
			}
			var val = id.value.substr(last - 1,id.value.length);
			var v = val.split("@");
			var vv = v[1].split(" ");
			var vvv = vv[0];
//		alert(v[1]);
//			return false;
			var div = false;
			var d = id.parentNode.childNodes;

			for(var i in d)
			{
				if(d[i].className == "pl2div")
				{
					div = d[i];	
					break;
				}
			}
			$.post(PTH+"/actions/ajax_mention.php",{s:vvv},function(data){
				
				$(div).slideDown(200);
				$(div).html(data);
				});
				
		div.onclick = function (){$(div).fadeOut(300);}
		}	
	}
	var createButton = function ()
	{
			var inp = document.createElement("input");
			inp.type = "button";
			inp.className = "button1";
			inp.style.cssFloat = "right";
			return inp;
	}
	
	var _dpost = function (e,type){
		if(!_isvalidpost)
		{
			return false;
		}
		e = e ?e :window.event;
		var id = e.target?e.target:e.srcElement;
		id.disabled = true;
		var p = id.parentNode.getElementsByTagName("textarea");		
		var  txt = null;
		for(var i in p)
		{
			if(p[i].className == "txtdiv")
			{
				txt = p[i];
				break;
			}			
		}
			var ttt = _chkmaxlength(txt);
			if(!ttt)
			{
				return false;
			}
		if(!txt){return false;}
		txt.disabled = true;
		var text = txt.value;
		var rid = txt.getAttribute("rid");
		$.post(PTH+"/actions/post.php",{loc:0,client:1,post:text,rid:rid,type:type},function (data){
		if(data == 1)
		{
		//	txt.value = "";
			_modal_close(e);
			$(pw).fadeOut(500);
		}
		
		});
			
	}
	
	
	
	
	
	
	
	
	
	
	var href_width = 0;
//post reply repost//	
 var prev_h_div = ""; 
	function pwin(href)
	{
		if(href == "#dialog")
		{
			$(href).css({width:"35%"});
			href_width = $(href).width();
		}
		var mask_div = document.createElement("div");
		var window_div = document.createElement("div");
		try{
		document.getElementById(href.substr(1,href.length)).scrollIntoView();
		}catch(ofNull){}
		
		mask_div.className = "mask";
		window_div.className = "window";
		
		document.body.appendChild(window_div);

		var maskHeight = $(document).height();

		var maskWidth = $(window).width();

		var winH = $(window).height();
		var winW = $(window).width();
		$(href).css('left', winW/2-$(href).width()/2);
		$(href).css('top',  winH/2-$(href).height()/2);
		if(href.indexOf("pwindow") < 0 && href != "#dialog")
		{
			document.body.appendChild(mask_div);
			$(href).css('top', '12%');
		}
		if(href.indexOf("userwindow") > -1)
		{
			_hidepwin();
		}
		
		//$(href).css('top',  winH/2-$(href).height()/2);
		
		
		$(mask_div).css({'width':maskWidth,'height':maskHeight});

		//$(mask_div).fadeIn(500);	

		$(mask_div).fadeTo(100,0.5);	
		$(mask_div).click(function (){
			
			$(href).fadeOut(100);
			$(mask_div).fadeOut(100);
			$(".mask").fadeOut(100);
			});
		$(href).fadeIn(200); 
		//scrollToElement(href);
		/*$('.window .close').click(function (e) {
		Cancel the link behavior
		e.preventDefault();
		e = e? window.event;	
		});		*/	
		prev_h_div = href;
	}
	function _hidepwin()
	{
		try
		{
			$("#pwindow").fadeOut(200);
			if(prev_h_div == "#dialog")_tggle_(null);
			$("#dialogvideo").fadeOut(200);
			$("#dialogpicture").fadeOut(200);

			$("#userwindow a").click(function (){
				$("#userwindow").fadeOut(200);
				$(".mask").fadeOut(200);
			});	
			$(".mask").fadeOut(200);
		}
		catch(e)
		{
			
		}
	}
	function _modal_close(e)
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		var par = false;
		function isBoxes(pn)
		{
			try{
			if(pn.parentNode.parentNode.id=="boxes")return pn.parentNode;
			if(pn.parentNode.parentNode.parentNode.id =="boxes") return pn.parentNode.parentNode;
			if(pn.parentNode.parentNode.parentNode.parentNode.id=="boxes")return pn.parentNode.parentNode.parentNode;
			return false;
			}catch(ee){return false;}
		}
	//	if(id.parentNode.parentNode.id == "boxes")
	//	{
	//		par = id.parentNode;
	//	}
	//	else
	//	{
	//		par = id.parentNode.parentNode;			
	//	}
		par = isBoxes(id)
		if(par)
		{
			if(par.id == "dialog")
			{
				//$(par).animate({opacity:0.05},500);
			}
			else
			{
				
			}			
			$(par).fadeOut(100);
			$(".mask").fadeOut(100);
		}		
		//alert(par);
		//$('#mask').fadeOut(200);
		//$('.window').fadeOut(200);	
	}
	function _op(id,type)
	{
		$.post(PTH+"/actions/_op.php",{id:id,type:type},function(data){
		$("#pwin").html(_str(data));	
		pwin("#pwindow");
					processVars();
		});
		return false;
	}
	var _404 = true;
	var ajax_re_get_script = function (){
		try
		{
			if(document.getElementById("_main_"))
			{
				var last_time = document.getElementById("last_time");
				var time = last_time.value;	
				var jxhr =	$.post(PTH+"/actions/main.php",{time:time,code:"upd"},function (data)
				{
					if(String(data).indexOf("id='last_time'") > -1)
					{
						last_time.parentNode.removeChild(last_time);
					}
					else
					{
						setTimeout(function(){ajax_re_get_script();},6000);
						return false;
					}
					var div = document.createElement("div");
					div.innerHTML = _str(data);
					
					
					var mainD = document.getElementById("main");
					mainD.insertBefore(div,mainD.childNodes[0]);
//								processVars();
					if(data.toString().length> 70)
					{						
						
					}
					load_img_async();	
					setTimeout(function(){ajax_re_get_script();},6000);
					
				}).error(function (){
			setTimeout(function(){ajax_re_get_script();},6000);
			});

			}
			else
			{				
				setTimeout(function(){ajax_re_get_script();},6000);
			}
		}
		catch(e2)
		{
			setTimeout(function(){ajax_re_get_script();},6000);
		}
	}
	$(document).ready(function (){setTimeout(function(){ajax_re_get_script();_404 = false;},6000);});
	function now_playing(type,id)
	{
			$.post(PTH+"/actions/np.php",{type:type,id:id},function (data){
			});				
	}
	
	function is_playing()
	{
		try
		{
			if(document.getElementById("_np_"))
			{

				var owner = document.getElementById("owner").value;
				$.post(PTH+"/actions/np.php",{owner:owner},function (data){
					document.getElementById("_np_").innerHTML = data;
				});				
			}
					
		}
		catch(e2)
		{

		}
	}
	
	/////////////////////////////////////
	
	
	
	function media_post(e,t)
	{
		try{
		e = e ? e:window.event;
		var id = e.target?e.target:e.srcElement;
		var type = id.getAttribute("type");
		var tid = id.getAttribute("tid");
		//alert(type + "  :"+t+" : " + tid);
		var txts = t!=2?id.parentNode.parentNode.parentNode.getElementsByTagName("textarea"):id.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName("textarea");
		var txtdiv = false;
//alert(id.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.outerHTML);
		for(var tt in txts)
		{
			if(txts[tt].id == "txtdiv" || txts[tt].className == "txtdiv")
			{
				txtdiv = txts[tt];	
			}
		}
	//	alert(txtdiv);
		txtdiv.value += " ["+type+":"+tid+" ]";
		}
		catch(e2){alert(e2 + "\n media post");}
	}
	
	function get_media(e)
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		var p = id.parentNode.getElementsByTagName("textarea");		
		var txt = null;
		for(var i in p)
		{
			if(p[i].className == "txtdiv" || p[i].id == "txtdiv")
			{
				txt = p[i];
				break;
			}			
		}
	
		var pl2 = null;
		var d = txt.parentNode.childNodes;
		for(var i in d)
		{
			if(d[i].className == "pl2div")
			{
				pl2 = d[i];	
				break;
			}
		}

		$.post(PTH+"/actions/media_post.php",{is_session:true},function (data){
			
			$(pl2).html(data);
			$(pl2).slideDown(200);
			
			});		
		pl2.onclick = function (){
			$(pl2).fadeOut(200);	
		}
	}
	
	function _vote(e,cid)
	{
		e = e?e:window.event;
		var id  = e.target?e.target:e.srcElement;
		var form_div = id.parentNode.parentNode;
		var hd = form_div.getElementsByTagName("input");
		for(var h in hd)
		{
			if(hd[h].type == "hidden")
			{
				hd[h].value = cid;
				break;
			}	
		}
	}
	function _Vote(e,cat)
	{
		e = e?e:window.event;
		var id  = e.target?e.target:e.srcElement;
		var cid = id.nextSibling.value;
		if(cid == 0){return false;}
		$.post(PTH+"/actions/vote_submit.php",{cid:cid,cat:cat},function (data){id.parentNode.parentNode.innerHTML = data;})		
	}
	function scrollToElement(eID)
	{
		//var container = $('body');
   		//var scrollToE = $(eID);
	//alert(container.scrollTop())
	//var s_c_l = scrollToE.offset().top - container.offset().top;
document.getElementById(eID.toString().substr(1,eID.toString().length)).scrollIntoView();
//   scrollTo = $('#row_8');

//container.scrollTop(
 //   scrollTo.offset().top - container.offset().top + container.scrollTop()
//);

// Or you can animate the scrolling:
//container.animate({
 //   scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
//});​
		
	}
	function ajax_media(e)
	{
		doLoading(true);
		e = e ? e:window.event;
		//pwin("#pwindow");
		var id = e.target?e.target:e.srcElement;
		//alert(id);
		var type = id.getAttribute("type");
		var tid = id.getAttribute("tid");
		//alert(type + " " + tid);
		$.post(PTH+"/actions/ajax_media.php",{type:type,id:tid},function (data){
		json_eval_media(data);	
		
			doLoading(false);
		});
	}
	
	function json_eval_media(data)
	{
		
		try{
			var json_e = eval(data);

			if(json_e.status)
			{
				if(json_e.type == 1)
				{
					playart(json_e);
				}
				if(json_e.type == 2)
				{
					playmusic(json_e);	
				}
				if(json_e.type==3)
				{
					playvideo(json_e);	
				}
			}
			else
			{
				$("#pwin").html(json_e.msg +"::1");
				pwin("#pwindow");	
			}
			}catch(ee){
				$("#pwin").html(ee.toString() + "::2");
				pwin("#pwindow");
				}
			
	}
	function hist_media(id,type)
	{		
		doLoading(true);
		$.post(PTH+"/actions/ajax_media.php",{type:type,id:id},function (data){	
			json_eval_media(data);
			doLoading(false);
		});
	}
	
	
	
var _chkmaxlength = function (txt)
{
	var b = txt.parentNode.childNodes[0];
	if(txt.value.length > 225)
	{
		b.innerHTML = 225 - parseInt(txt.value.length);
		b.style.color = "red";	
		return false;	
	}
	else
	{
		b.innerHTML = 225 - parseInt(txt.value.length);
		b.style.color = "#999";
		return true;
	}
}
	
	
	
/*	var time_to_pop = false;
	var _pop = function (e,uid)
	{
		e = e ? e : window.event;
		var stp="";
		var id = e.target?e.target:e.srcElement;
		id.onmouseover = function ()
		{
			time_to_pop = true;
		}
		id.onmouseout = function ()
		{
			time_to_pop = false;
		}
		setTimeout(
		function ()
		{
			if(time_to_pop)
			{
				_popt(e,uid);	
			}			
		}
		,2000);	
	}
	*/
	var _pop = function (e,uid)
	{
		var dload_pop = document.getElementById("pop"+uid);
		doLoading(true);
		if(dload_pop)
		{
				
			$("#userwin").html(dload_pop.value);
			pwin("#userwindow");
			doLoading(false);
			load_img_async();	
			_runeval();				
		}		
		else
		{
			$.post(PTH+"/actions/pop.php",{uid:uid},function(data){
				var dload_pop = document.createElement("input");
				dload_pop.type = "hidden";
				var data1 = data.split("____id:");
				dload_pop.id = "pop"+uid;
				dload_pop.value = _str(data1[0]);
				document.body.appendChild(dload_pop);				
				$("#userwin").html(_str(data1[0]));
				pwin("#userwindow");	
				doLoading(false);
				load_img_async();
				_runeval();
			});
		}
		function _runeval(){
			try{
			//eval(document.getElementById("eval_pop").value);
			}
			catch(ee){alert(ee);}
		}
		return false;
	}
	var _popt = function(e,uid)
		{
			try{
			//if(usem == uid || document.getElementById("pop_oot"))
			//{return false;}
			var _old = false;
			e = e ? e : window.event;
			var stp="";
				
			
			//if(navigator.appVersion.indexOf("MSIE 7.0") > -1 || navigator.appVersion.indexOf("MSIE 6.0") > -1)
        //	{_old = true;return false;}
			var id = e.target?e.target:e.srcElement;
			var dwc_ = 180;//document.getElementById("divwallcot")?130:document.getElementById("msgnot") || document.getElementById("gpcent")?180:0;
		//	var x = e.pageX?e.pageX:e.clientX;
        //	var y = e.pageY?e.pageY:(dwc_ + e.y);
			var div = document.createElement("div");
			var _transDiv = document.createElement("div");
			div.id = "pop_oot";
			div.className = "_popd";
			_transDiv.className = "_popt";
			var _div = document.getElementById("container");
			var cntdiv = document.createElement("div");
			//cntdiv.id = "pop_c_div";
			//cntdiv.innerHTML = "<img src='"+PTH+"/img/load/ml.gif' title='loading . . .' />";
			var y = e.clientY?e.clientY: e.screenY;
					
				//	var s = "";
				//	for(var t in e)
				//	{
				//		s += t + ": " +e[t] +"<br/>";	
				//	}
				//	$("#pwindow").html(y);pwin("#pwindow");
			div.style.top = (y - 30) + "px";
	//		div.style.left = (x - 10) + "px";

			_transDiv.style.top = (y - 40) + "px";
	//		_transDiv.style.left = (x - 20) + "px";
			
//			function cor (){
//			$(_transDiv).corner("round 10px");
//			}
			
			var  _on = true;
			var _opo = function ()
			{
				if(!_on){
					
					try{_div.removeChild(div);}catch(a21){}
					try{_div.removeChild(_transDiv);}catch(e3){}
		//			$(_transDiv).fadeOut(50);	
		//			$(div).fadeOut(50);
				}
			}
			//serious
			//if(document.getElementById("pop"+uid)){_on = false;_opo();_pop(e,uid);return false;}
			div.onmouseover = function () { _on = true;}
			_transDiv.onmouseover = function () { _on = true;}
			cntdiv.onmouseover = function () { _on = true;}
			function _out() {_on = false;
				setTimeout(_opo,2000);}

			id.onmouseout = function (){_out();}
			div.onmouseout =function (){_out();}
			cntdiv.onmouseout =function (){_out();}
			_transDiv.onmouseout = function (){_out();}
			
			var setH = function(){
		setTimeout(function (){$(div).fadeIn(200);$(_transDiv).fadeIn(100);	_transDiv.style.backgroundColor = prof_color;},100);
				}
				var dload_pop = document.getElementById("pop"+uid);
				
				if(dload_pop)
				{
					if(_on){	
						_div.appendChild(_transDiv);
						_div.appendChild(div);
						div.appendChild(cntdiv);
						
					cntdiv.innerHTML = dload_pop.value;
					setH();
					}
					return false;
				}
			else{
								
				$.post(PTH+"/actions/pop.php",{uid:uid},function(data){
					if(_on){	
							_div.appendChild(_transDiv);
							_div.appendChild(div);
							div.appendChild(cntdiv);
							var dload_pop = document.createElement("input");
							dload_pop.type = "hidden";
							
							var data1 = data.split("____id:");
							dload_pop.id = "pop"+data1[1];
							dload_pop.value = _str(data1[0]);
							document.body.appendChild(dload_pop);
												setH();
						
							//$(div).animate({height:80+"px",width:250+"px"},10);
							//$(_transDiv).animate({height:100+"px",width:270+"px"},10);
					/*div.style.height = "120px";
					div.style.width = "250px";
					_transDiv.style.height = "140px";
					_transDiv.style.width = "270px";
					*/	
					$("#pwindow").html(_str(data1[0]));
					pwin("#pwindow");	
							cntdiv.innerHTML =  _str(data1[0]);
						//	cor();	
					}
				});
			}
			
			}catch(ee){alert(ee);return false;}
			return false;
		}
	
	var modal_msg = function (pid,user)
	{
		if(!pid || !user)
		{
			return false;			
		}		
		var btt = document.createElement("input");
		var subj = document.createElement("input");
		var txtarea = document.createElement("textarea");
		var div = document.createElement("div");
		var href = "<a href='./'" + user + "' onclick='return _o(event,"+ pid+");' onmouseover='_pop(event,"+pid+")'>" +user + "</a>";

		
		
		subj.type ="text";
		subj.id = "subj";
		subj.className = "txt";
		
		txtarea.className = "txt";
		txtarea.style.width = "300px";
		txtarea.id = "txtarea";
		
		
		btt.type = "button";
		btt.className = "button1";
		btt.value = "Send";
		
		btt.onclick = function (event)
		{
			sendNewMsg(event?event:window.event,pid);
		}
		
		var pw = document.getElementById("pwin");
		pw.innerHTML = "To: " + href + "<br/>";
		pw.innerHTML += "Subject : ";
		pw.appendChild(subj);
		pw.innerHTML += "<br/><br/>";
		pw.appendChild(txtarea);
		pw.innerHTML += "<br/><br/>";
		pw.appendChild(btt);
		
		pwin("#pwindow");
		$("pwin").html("<div></div>");
		
	}
	var sendNewMsg = function (e,pid)
	{
		e = e?e:window.event;	
		var id = e.target?e.target:e.srcElement;
		var ppp = id.parentNode.childNodes;
		var subj = false;
		var txtarea = false;
		try
		{
			for(var a in ppp)
			{
				if(ppp[a].id == "txtarea")
				{
					txtarea = ppp[a].value;
				}
				if(ppp[a].id == "subj")
				{
					subj = ppp[a].value;
				}
			}
		}catch(ee)
		{
			alert(ee);	
		}
		if(subj && txtarea)
		{
			
			$.post(PTH+"/msg/send.php",{u2:pid,msg:txtarea,subj:subj},function (data){
				if(data != 1)
				 {					
					$("#pwin").html("Error occured. please try again"); 
					pwin("#pwindow");
				 }
				 else
				 {
					//$('#mask').fadeOut(200);
					$('#pwindow').fadeOut(500); 
				 }

				});
		}
		
	}
	
	
	
	
	
	
	
	
	
	function _like(e,pid,userid)
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		$.post(PTH+"/actions/like.php",{id:pid,userid:userid},function (data){
			var n = parseInt(id.innerHTML);
			var n = !isNaN(n)?n:0;
			if(parseInt(data) == 1)
			{	
				n =typeof(10) == typeof(n)?(n + 1):n;
				id.style.backgroundImage="url("+PTH+"/img/like.png)";	
				id.title ='unlike '+n;

			}
			else
			{
				n = n > 0 && typeof(10) == typeof(n)?(n - 1):n;
				id.style.backgroundImage="url("+PTH+"/img/like_2.png)";	
				id.title ='like '+n;			
			}
			id.innerHTML = n == 0?"":n;
			});
	}
	
	
	
	
	var sugg = false;
	function suggests_()
	{
		try{
		if(document.getElementById("_suggest"))
		{
			$.post(PTH+"/actions/rand_p.php",{session:true},function (data){
			var data = String(data).split("__::__");
			if(!sugg)
			{
				sugg_interval();
$("#_suggest").fadeOut(500,function (){
	$("#_suggest").fadeIn(500);$("#_suggest").html(data[0]);
	});
			$("#_dinewu").fadeOut(500,function (){
	$("#_dinewu").fadeIn(200);$("#_dinewu").html(data[1]);processVars();
	});	
			}
			sugg = data;				
			setTimeout("suggests_()",60000);
			}).error(function (){
				setTimeout("suggests_()",2000)
				});
		}
		else
		{
			
			setTimeout("suggests_()",2000);	
		}
		}
		catch(ee3){alert(ee3);setTimeout("suggests_()",2000);};
	}
	
	
	function sugg_interval()
	{
		try
		{
			$("#_suggest").html(sugg[0]);
			$("#_dinewu").html(sugg[1]);
			$(".ssmpdiv").css({backgroundColor:prof_color});
		}catch(e)
		{
			
		}
		setTimeout("sugg_interval()",5000);	
	}
	var _delDissapear = false;
	function _postOver(e)
	{
		try{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		var del = id.getElementsByClassName("del");
		$(del).fadeIn(200);
		_delDissapear = true;
		if(id.className == "post")
		{
			id.onmouseout = function ()
			{
				_delDissapear = false;
				setTimeout(function (){
				if(!_delDissapear)
				{
					$(del).fadeOut(200);
				}
				},3000);
			}
	    }
		}
		catch(ee){}
	}
	
var	_gomedia = function (mediaID,type)
{
	doLoading(true);
	try
	{
		if(js){
		_remove_media(js);
		_remove_media(po);
		_remove_media(jss);}
	}catch(_med){alert(_med);}
	$.post(PTH+"/actions/mediacontent.php",{mediaID:mediaID,type:type},function (data){
			doLoading(false);

		$("#_div_").html(data);
		_hidepwin();
		
		try{
		$(".subdiv").html(_str($(".subdiv").html()));
		var uid = document.getElementById("upid").value;
		var div = new createCommentDiv(mediaID,type,uid);
		document.getElementById("comdiv").appendChild(div);
		eval(document.getElementById("eval_script").value);
		}
		catch(e)
		{
			alert(e+"errr");
		}
		
		try
		{
			_share_media();
		}
		catch(e_)
		{
			alert(e_);
		}
		processVars();
		})	
	.error(function (){
					$("#_div_").html("<div class='m_s_g'>Error loading media<Br/>Please try <a href='#' onclick='_gomedia("+mediaID+","+type+"'>again</a></div>");
				});
	
		
}
function generate_tips(tip_id){
if(! document.getElementById(tip_id))
 $("body").append("<div id='"+tip_id+"'></div>");

 $("[title]").each(function() {
    $(this).hover(function(e) {
      $(this).mousemove(function(e) {
        var tipY = e.pageY + 15;
        var tipX = e.pageX + 15;
        $("#"+tip_id).css({'top': tipY, 'left': tipX});
      });

      if($(this).attr('title').length > 1)
        $("#"+tip_id).html($(this).attr('title'));

      $("#"+tip_id)
        .stop(true,true)
        .fadeIn(1000);
      $(this).attr("title", "");
    }, function() {
      $("#"+tip_id)
        .stop(true,true)
        .fadeOut(1000);
      $(this).attr('title', $("#"+tip_id).html());
    });
  });

}
function setURI(type,id)
{
	window.location  = "#!/"+type+"="+id;	
	return false;
}
