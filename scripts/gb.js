var fdf = false;
var sel_country = function (loc)
	{
		$.get(loc+"/scripts/cty.php",function (data){
			eval(data);
			try{
					var country = sGeobytesCountry;
					var city = sGeobytesCity;
					var sel = document.getElementById("user_time_zone").childNodes;
					for(var o in sel)
					{
						var opt = sel[o];							
						if(String(opt.value).indexOf(country) > -1)
						{
							opt.selected = true;
							break;	
						}
					}
				}
				catch(_no_location)
				{
					
				}			
		});
	}
	

    function subm()
	{        	
		if(chkp()  && chkmail() )//&& chkname() && chk_usr()
		{
			fdf = true;
			//document.getElementById("_ReR_").innerHTML = "";
		}
		else
		{
			fdf = false;   
			//document.getElementById("_ReR_").innerHTML = "Please Make sure you have filled all information";
			
		}
		return fdf;   
    }
	function chk_usr()
	{
		var usr = document.getElementById("usr_name");
		var usrn = document.getElementById("usrn");
		if(usr.value.length < 5)
		{
			usrn.style.color = "red";
			usrn.innerHTML = "* At least six letters";	
			fdf = false;
			return false;
		}
		else
		{
			usrn.innerHTML = "";	
			return true;
		}

	}
    function chkp()
    {
	
        var pws = new Array(document.getElementById("p1"),document.getElementById("p2"),document.getElementById("pw"),document.getElementById("pww"));
        if(pws[0].value.length < 6)
        {
            pws[3].innerHTML = "* password must be more than 6 characters";
            pws[0].focus();
            fdf = false;
            pws[1].value = "";
            pws[0].value = "";
        }
         else
         {
            pws[3].innerHTML = "";
            if(pws[0].value !=pws[1].value)
            {
                pws[2].innerHTML = "* passwords do not match";
                fdf = false;
               pws[0].focus();
                pws[1].value = "";
                pws[0].value = "";
            }
            else
            {
                fdf = true;
                document.getElementById("pw").innerHTML = "";    
            }
         }
         return fdf;
    }
	function chkname(e)
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		if(id.value.length < 2)
		{
			fdf = false;
			$("#unn").html("Name must be at least 2 characters");
		}
		else
		{
			fdf = true;	
			$("#unn").html("");
		}
		 return fdf;
	}
	function chkmail()
	{
		var emv = document.getElementById("email");
		var emvv = emv.value;
		// email regular expression cross checker...... dat one sef dey
		//  "/(.*).@.*\.(.[a-z])/.test(<string>)"
		var boolin = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i.test(emvv);
		fdf = boolin;
		if(!boolin)
		{
			document.getElementById("emm").innerHTML = "example &lsquo;chef@muzikkitchen.com&rsquo;";
			//emv.focus();
		}
		else
		{
			document.getElementById("emm").innerHTML = "";
		}
		
		return boolin; 
	
	}
function get_s(r)
{
	try
	{
		var tz = document.getElementById('user_time_zone');
		var opt = tz.getElementsByTagName('option');
		for(var option in opt)
		{
			if(opt[option].value == r)
			{
				opt[option].selected = 'selected';
				break;	
			}
//			alert(opt[option].value + ' ==>> ' + '$r[5]');
//			break;
		}
	}
	catch(u_no_sabi)
	{
		alert(u_no_sabi);	
	}
}

var rSh = function (e)
{
	e = e ?e:window.event;	
	var id = e.target?e.target:e.srcElement;
	
	var txt = id.parentNode.getElementsByTagName("input");
	if(id.value == 4)
	{
		txt[0].style.display = "block";	
	}
	else
	{
		txt[0].style.display = "none";	
	}
	fdf = true;
}


var _sav_color = function (color)
{
		$.post("./actions/savcolor.php",{color:color},function (data){
	//	$("#color_div").html(data);

	var c = data;
		//$("#color_div").animate({color:c});
//	$(document.body).animate({backgroundColor:c},500);
//		document.body.style.backgroundColor = data;
		bgcolor = data;
		prof_color = bgcolor;
		temp_color = prof_color;
		processVars();
		}).error(function (){
			
		$("#pwin").html("<div align='center'>Please try again.</div>");			
			pwin("#pwindow");
			
});
}

var _prev_color = function (e,col,t)
{
	e = e?e:window.event;
	var fade = true;
	var id = e.target?e.target:e.srcElement;
	id.onmouseout = function ()
	{
		fade = false;
		_prev_color(e,col,2);
	}
	switch (t)
	{
		case 1:
			setTimeout(function()
						{	
							if(fade)
							{
								fade = false;
								prof_color = col;
								$(document.body).animate({backgroundColor:prof_color},500);
								processVars();
							}
						}
						,1500);
		break;
		case 2:
			prof_color = temp_color;
			$(document.body).animate({backgroundColor:prof_color},500);
			processVars();
		break;
	}
}
var del_med = "";
var edit_content = function (type,id,vars)
{
	var action='#';
	var divid = "";
	var name = "";
	var info = "";
	var preview = "";
	vars = document.getElementById(vars).innerHTML;
	var const_v = vars;
	var vars = vars.split("____");
	switch(type)
	{
		case 1:
				action = './actions/gallery.php';
				divid  = "a_edit";
				name = vars[4];
				info = vars[5];
				 del_med = "<form action='./actions/gallery.php' align='center' target='frame' method='post'>Are you sure you want to Delete "+name+" ?<br/><br/><input type='submit' value='Delete' onclick='ifr_done(1);$(\"#pwindow\").fadeOut(500);'  class='button1'/><input type='hidden' name='del' /><input type='hidden' value='"+const_v+"' name='vars' /></form>";
				//$("#pwin").html(del);
				var fullart = "./art/full_"+ String(vars[3]).substr(5,vars[3].length);
				preview = '<a href="#" onclick="tab_click(null,\'gallery.php\')">Back</a><br/>'+"<a href='./picture-"+id+"' ><img tid='"+id+"' type='0' onclick='ajax_media(event);return setURI(\"picture\","+id+");' src='"+PTH+""+vars[2]+"' class='mpdiv' /></a>";
		break;			
		case 2:
				action = './actions/muzik.php';
				name = vars[2];
				info = vars[3];
				 del_med = "<form action='./actions/muzik.php' align='center' target='frame' method='post'>Are you sure you want to Delete "+name+" ?<br/><br/><input type='submit' value='Delete' onclick='ifr_done(2);$(\"#pwindow\").fadeOut(500);'  class='button1'/><input type='hidden' name='del' /><input type='hidden' value='"+const_v+"' name='vars' /></form>";
				divid  = "m_edit";
				
				preview = '<a href="#" onclick="tab_click(null,\'muzik.php\')">Back</a><br/>'+"<a href='./music-"+id+"'  ><div type='1' tid='"+id+"' onclick='ajax_media(event);return setURI(\"music\","+id+");' class='music_m' style='font-size:10px;'>Listen to "+name+"</div></a>";
		break;	
		case 3:
				action = './actions/videoz.php';
				divid  = "v_edit";
				name = vars[3];
				info = vars[4];
				 del_med = "<form action='./actions/videoz.php' align='center' target='frame' method='post'>Are you sure you want to Delete "+name+" ?<br/><br/><input type='submit' value='Delete' onclick='ifr_done(3);$(\"#pwindow\").fadeOut(500);'  class='button1'/><input type='hidden' name='del' /><input type='hidden' value='"+const_v+"' name='vars' /></form>";
				 preview = '<a href="#" onclick="tab_click(null,\'videoz.php\')">Back</a><br/>'+"<a href='./video-"+id+"' ><img tid='"+id+"' type='2' onclick='ajax_media(event);return setURI(\"video\","+id+");' src='"+PTH+"/prev/"+vars[2]+"' class='mpdiv' /></a>";
		break;	
	}
	
	var html = '<table cellspacing="5"><tr><td valign="top">'+preview+'</td><td><form method="post" target="frame" action="'+action+'" ><table cellspacing="5"><tr><td>Name</td><td><input type="hidden" value='+id+' name="id"/><input type="text" class="txt" value="'+name+'"  name="name" /></td></tr><tr><td>Info</td><td><textarea class="txt"  name="info" onkeyup="gment(event)" >'+info+'</textarea><div class="pl2div" style="top:280px;"></div></td></tr><tr><td></td><td><input type="submit" class="button1"  name="upd" value="Update" onclick="ifr_done('+type+')" /> <input class="button1" type="button" onclick="setHTML();" value="Delete"/></td></tr></table></form></td></tr></table>';
	
	document.getElementById(divid).innerHTML = html;
}
var setHTML  = function()
{		
		$("#pwin").html(del_med);	
		pwin('#pwindow');
}
function ifr_done(type)
{
	var id = document.getElementById("frame");
	
	id.scrollIntoView(false);
	uploading(true);	
	var url = ""
	switch (type)
	{
		case 1:
			url= 'gallery.php';
		break;
		case 2:
			url= 'muzik.php';
		break;
		case 3:
			url = 'videoz.php';
		break;	
	}
	id.onload = function ()
	{
//		alert(url);	
		uploading(false);
		tab_click(null,url)
	}
}