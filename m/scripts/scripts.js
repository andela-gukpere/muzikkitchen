// JavaScript Document
var showLoad = function (show)
{
	if(show == 20)
	{
		$('.hddload').html("Uploading");	
		show = true;
	}
	else
	{
		$('.hddload').html("Loading");
	}
	if(show){$(".hddload").css({"top":"0%",display:"block"});}
	else {$(".hddload").css({top:"-10%",display:"none"});
	 if(vt == 2)$("#_pt_").fadeIn(500);else $("#_pt_").fadeOut(10); }
	
}
var _share_media = function (){}
var uploading=function(show)
{
	if(show)show=20;
	else show=false;
	showLoad(show);
}
var go_main = function (e)
{
	_active(e);
	gposts(2,"m_t_b");
				   showLoad(true);
		   $.post(PTH+"/msg/num.php",{session:true},function (data){
			   showLoad(false);
			   $("#msg_num").html(data);
					$.post(PTH+"/actions/platenumber.php",{session:true},function (data){
			   $("#plate_num").html(data);

			   });
	});	
}
var go_mention = function (e)
{
	_active(e);
	gposts(4,"m_t_b");	
}

var go_dine = function (e,type)
{
	_active(e);
	dine_(type);
	
}
var go_likes = function (e)
{
	_active(e);
    gposts(5,"m_t_b");
}
var go_msgs = function (e)
{
	_active(e);
	gmsgs();	
}
var go_plate = function (e)
{
	_active(e);
        gplate("m_t_b");
}
var gmsgs = function ()
{
	showLoad(true);
	$.post(PTH+"/m/msg/",{is_session:true},function (data){
		$("#m_t_b").html(_str(data));
			showLoad(false);
		});	
}
var go_refeeds = function (e)
{
	
	_active(e);
	 gposts(6,"m_t_b");
	
}
var _active = function (e)
{
	try
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		$(".se").attr("class","");
		id.className = "se";
	}
	catch(er)
	{

	}
}
var _post= function (type,rid,e){


	var txtdiv = document.getElementById("txtdiv");
		e = e ?e :window.event;
		var id = e.target?e.target:e.srcElement;
		id.disabled = true;
	var post = txtdiv.value;
	var ttt = _chkmaxlength(txtdiv);
	if(!ttt)
	{
		return false;
	}
	txtdiv.disabled = true;
//	alert(post);
	showLoad(true);
	$.post(PTH+"/actions/post.php",{post:post,client:2,loc:1,rid:rid,type:type},function (data){
		txtdiv.disabled = false;
			showLoad(false);
		id.disabled = false;
		if(data == 1){
			txtdiv.value = "";
			if(type == 1 || type == 2)
			{
				window.location = PTH+"/?table";	
			}
		}
	
	});
	
}
var _repost = function (e)
{
	
}
var _pop = function (e,d)
{
	
}
var _reply = function (e)
{
	
}
var _o = function (e,d)
{
	
}
var _op = function (e,d)
{
	
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
					var ar = "<a href='"+PTH+"/music-"+istr+"' tid='"+istr+"' type='1' >[<b tid='"+istr+"' type='1'>music:</b>"+istr+" ]</a>";
					str = str.replace("[music:"+hr[0]+" ]",ar);	
				}
				return _media_art_(str.toString());
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
					 var ar = "<a href='"+PTH+"/picture-"+istr+"'class='art_items' tid='"+istr+"' type='0' ><div class='dyn_img'  id='_dyn_art_"+istr+"' tid='"+istr+"' type='0'><span style='display:none;' tid='"+istr+"' type='0'>[<b tid='"+istr+"' type='0'>art:</b>"+istr+" ]</span></div></a>";//
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
					var ar = "<a href='"+PTH+"/video-"+istr+"' tid='"+istr+"' type='2' >[<b tid='"+istr+"' type='2'>video:</b>"+istr+" ]</a>";
					str = str.replace("[video:"+hr[0]+" ]",ar);	
				}
				return (str.toString());
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
			txtdiv_val = id.value;
		}
		else if(id.value.length >total)
		{
			id.value = txtdiv_val;	
		}	
	}
	

	var _404 = true;
	var get_posts = function (){
		try
		{
			if(document.getElementById("_main_") && !document.getElementById("no_no"))
			{
				var last_time = document.getElementById("last_time");
				var time = last_time.value;
			var jdxr = $.post(PTH+"/m/actions/gpost.php",{time:time,type:1},function (data)
				{
					
					if(String(data).indexOf("id='last_time'") > -1)
					{
						last_time.parentNode.removeChild(last_time);
					}
					else
					{	
						setTimeout(function(){get_posts();},6000);
						return false;
					}
					var div = document.createElement("div");
					div.innerHTML = _str(data);
					var mainD = document.getElementById("m_t_b");
					mainD.insertBefore(div,mainD.childNodes[0]);
					if(data.toString().length > 70)
					{						

											
					}
					load_img_async();					
					setTimeout(function(){get_posts();},6000);
				}).error(function (){
			setTimeout(function(){get_posts();},6000);
			});
		
			}
			else
			{		
				setTimeout(function(){get_posts();},6000);
			}
		}
		catch(e2)
		{
	//	alert(e2 + + "\n" + "getnewp");
			setTimeout(function(){get_posts();},6000);
		}
	}
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
						istr = "<img src='http://" + hr[0] + "' height='50' width='60'/>";
						img.onreadystatechange = function (){
							if(img.readyState != 4)
							{
								istr = "http://"+hr[0];
							}
						}
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
				var d_ = /[^A-Za-z0-9_]+/;
				var _d = /[A-Za-z0-9_]+/;
				for(var h in a)
				{
					var hr = a[h].split(" ");
					var istr = hr[0];
					var t_ = istr.replace(d_,"");
					var _t = istr.replace(_d,"");
					istr = t_;
					var ar = "#<a href='"+PTH+"/?str="+istr+"' onclick='return _st(event,\""+istr+"\")' >"+istr+"</a>" + _t;
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
					istr = t_;
					var ar = "@<a href='"+PTH+"/"+istr+"'>"+istr+"</a>" + _t;
					str = str.replace("_@"+hr[0]+" _",ar);	
				}
				return tcm(str.toString());
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
	
var _more = function (e,type,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
	id.onclick = function (){return false;}
	id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	
	var owner = document.getElementById("owner")?document.getElementById("owner").value:0;
	$.post(PTH+"/m/actions/gpost.php",{page:page,owner:owner,type:type},function (data){
		id.parentNode.removeChild(id);

	md.innerHTML = md.innerHTML + _str(data);
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
function processVars()
{
	$(".menu li a").css("backgroundColor",prof_color);
	$(".button1").css("backgroundColor",prof_color);
	$("#show_more").css("backgroundColor",prof_color);
	generate_tips("title_id");
	load_img_async();
}
function hist_media(id,type)
	{	
		return false;
	}
function _st(e,str)
{
	e = e?e:window.event;
				   showLoad(true);
	$.post(PTH+"/search/trend.php",{s:str,is_alive:true},function (data){
	$("#m_t_b").html(_str(data));
				   showLoad(false);
	});
	return false;
}

var _more_st = function (e,s,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
		id.onclick = function (){return false;}
	id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	
	$.post(PTH+"/search/trend.php",{page:page,s:s},function (data){
id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
	});
}
var not_done_yet = true;
var vt = 0;
function gposts(type,div)
{
	showLoad(true);
	var o = document.getElementById("owner");
	var owner = 0;
	if(o)
	{
		owner = o.value;	
	}
	$.post(PTH+"/m/actions/gpost.php",{type:type,owner:owner},function (data){
			vt = type;
			showLoad(false);
		//	alert(type);
		//	if(type != 2)	window.location = "#m_t_b";
		document.getElementById(div).innerHTML = _str(data);
		//div.scrollIntoView(true);
		
		if(type==2)
		{
			 document.getElementById(div).innerHTML += "<input type='hidden' id='_main_' />";			
		}
		if(type == 2 && not_done_yet)
		{
			 get_posts();
			 not_done_yet = false;
		}
						processVars();
		});	
}

var ff = function (e,u2)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	id.onclick = function (){}
	$.post(PTH+"/actions/follow.php",{u2:u2},function (data)
		{
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
		});
	if(id.toString().indexOf("image") > -1)
	{
		
	}
	else
	{
		return false;
	}
}

function dine_(t)
{
	var o = document.getElementById("owner");
				   showLoad(true);
	var owner = 0;
	if(o)
	{
		owner = o.value;	
	}
	if (t == 1)
	{

	$.post(PTH+"/actions/following.php",{type:t,page:0,owner:owner},function (data){
				$("#m_t_b").html(data);
							   showLoad(false);
		});	
	}
		else
		{
			$.post(PTH+"/actions/followers.php",{type:t,page:0,owner:owner},function (data){
				$("#m_t_b").html(data);
							   showLoad(false);
		});	
	}
}
var _textgrow = function(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({fontSize:"15px"},500);	
	id.onmouseout = function ()
	{
		$(id).animate({fontSize:"8px"},500);	
	}
}
function _s()
{
//	e = e?e:window.event;
//	var id = e.target?e.target:e.srcElement;
			   showLoad(true);
	var txt = document.getElementById("sbox").value;//id.childNodes[0].value;
	$.post(PTH+"/search/",{session_is:true,s:txt,mobile:true},function (data){
		$("#m_t_b").html(data);		
					   showLoad(false);
		});
		return false;
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
	});
}
var _more_search = function (e,arg,page)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var md = id.parentNode;
		id.onclick = function (){return false;}
	id.style.backgroundImage = "url("+PTH+"/img/load/loadd.gif)";
	
	$.post(PTH+"/search/?s=" + arg,{page:page,mobile:true},function (data){
		id.parentNode.removeChild(id);
	md.innerHTML = md.innerHTML + _str(data);
	});
}

function __s(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var txt = id.value;
	if(txt.toString().length < 3){return false;}
	$.post(PTH+"/search/s.php",{session_is:true,s:txt,mobile:true},function (data){
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
var _del = function (e,id)
{
	if(confirm("Are you sure you want to delete is feed?"))
	{		
		var pp = document.getElementById("post"+id);
		$.post(PTH+"/actions/del_post.php",{id:id},function (data){

		if(parseInt(data) == 1)
		{
			$(pp).fadeOut(500);
		}
		else
		{
			alert("Error deleting post\n Please try again");	
		}
		//alert(data);
		});
	}
}
var _ment_ = function (e,user,arg)
{
	try
	{
		e = e ? e:window.event;
		var id	= e.target?e.target:e.srcElement;
		var txts = id.parentNode.parentNode.getElementsByTagName("textarea");
		var txt = false;
		for(var t in txts)
		{
			if(txts[t].id == "txtdiv" || txts[t].className == "txtdiv")
			{
				txt = txts[t];	
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
			var div = $(".pl2div");
			div = div[0];
			$.post(PTH+"/actions/ajax_mention.php",{s:vvv},function(data){
				
				$(div).slideDown(200);
				$(div).html(data);
				});
				
		div.onclick = function (){$(div).slideUp(300);}
		}	
	}
function delconv(cid)
{
	if(confirm("Are you sure you want to delete this conversation?\nNOTE the other party won't be able to view it anymore.")){
 $.post(PTH+"/msg/delconv.php",{id:cid},function(data){
        document.getElementById("dc"+dc).innerHTML = data;
        if(_cid != 0)
        {
			
        }
		window.open(PTH+"/?msg","_parent");
        });
	}
}

function sendmsg(id,e)
{
		e = e ?e :window.event;
		var bid = e.target?e.target:e.srcElement;
		bid.disabled = true;
    var msg = document.getElementById("txtamsg").value;
    $.post(PTH+"/msg/send.php",{msg:msg,id:id},function(data){
		try
		{
			id  = parseInt(id);
			if(id>0)window.open(PTH+"/?msg=1&inb="+id,"_parent");
			else throw "The message id is not a number :(";
		}
		catch(notint)
		{
			alert(notint);
		}
		});    
}

function delmsg(cid)
{
	if(confirm("Are you sure"))
	{
    $.post(PTH+"/msg/delmsg.php",{cid:cid},function(data){
          
		window.open(String(window.location).replace("#",""),"_parent");
		
        });
	}
}
function gplate(mt)
{
				   showLoad(true);
	$.post(PTH+"/actions/plate.php",{is_session:true},function (data){
		$("#m_t_b").html(_str(data));
					   showLoad(false);
	});
}
var _delDissapear = false;
	function _postOver(e)
	{
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
function generate_tips(tip_id)
{
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
						
						img.style.backgroundImage = "url(."+json_res.medium+")";						
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
function now_playing(type,id)
	{
			$.post(PTH+"/actions/np.php",{type:type,id:id},function (data){
			});				
	}
	function anim(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({opacity:0.8},500,function(){
	
		});	
}
function _gomedia(f,d)
{
		
}
function setURI(b,c)
{
	return true;	
}
function formEventes(e)
		{
			e = e?e:window.event;
			this.id = e.target?e.target:e.srcElement;
			this.parent = this.id.parentNode;
			this.prv = this.parent.previousSibling;
			this.prv2 = this.prv;
		}
 function addCommentV(e)
    {
        var pp = new formEventes(e);        
        $(pp.prv2).fadeIn("2000",function (){pp.id.style.display = "none";
	pp.prv2.childNodes[0].childNodes[0].childNodes[0].childNodes[0].childNodes[1].childNodes[0].focus();
			  });
    }
function anim2(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	$(id).animate({opacity:1},500,function(){
	
		});	
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
	if(confirm("Are you sure you want to delete this comment?"))
	{
		_delcom_(type,id);
	}
	
}
var _$ = function (id)
	{
		return document.getElementById(id);	
	}
function _delcom_(type,id)
{
	$.post(PTH+"/actions/comment.php",{action:3,type:type,id:id},function (data){
		if(parseInt(data) ==1)
		{				
			$(".comment_"+id).fadeOut(200);
		}
	});	
}
function sendNew()
{
    var subject = document.getElementById("txt_subj").value;
	var txt_subj = document.getElementById("txt_subj");
    var toh = document.getElementById("txtto").value;
    var msgTxt = document.getElementById("txtEd").value;
	var txtEd = document.getElementById("txtEd");
	showLoad(true);
    $.post(PTH+"/msg/send.php",{u2:toh,msg:msgTxt,subj:subject},function(data){
	showLoad(false);
 if(data == 2)
 {	
	alert("Error sending message");
 }
 else
 {
	 try
	 {
		var dt = parseInt(data);
		if(dt >0)window.location = PTH+"/?msg&inb="+dt;
	   	else throw "error NaN";
	 }
	 catch(err)
	 {
		data= data.replace("<br/>","\n\t");
		alert(data); 
	 }
 }
           });
}
