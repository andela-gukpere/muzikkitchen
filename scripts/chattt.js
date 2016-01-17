//i borrowed scritps from http://bubble-ng.co.cc :P
//calling of functions//
window.onload = function (){
num_online();
}
function shoP()
  	  	{
        	$("#divpch").slideToggle(100,function () {
            				$("#indivpch").niceScroll({cursorcolor:"#555",cursoropacitymax:0.7,boxzoom:false,touchbehavior:false}).resize();

				//document.getElementById("divpch").style.zIndex = 6;
			//$("#scrolldiv").tinyscrollbar();	
            });
			
    	}
	var show_nuts = function ()
	{
		$("#_not").slideToggle(300);
		setTimeout(function(){
			document.getElementById("_not_btt").value = "Events";
			},5000);
	}
	var _plate = "";
 function num_online()
    {
		if(document.getElementById("guest"))
		{
			document.getElementById("divpch").style.display = "none";
			document.getElementById("phref").style.display = "none";
			return false;
		}
		
          $.post(PTH+"/chatt/onl.php",{is_session:true},       
         function(data)
	 	 {
				var content = data;
				var _content = content.split("___");
				
				var num_onl = parseInt(_content[0]);

				if(num_onl < 1)
				{
					document.getElementById("phref").style.display = 'none';
				}
				else
				{
					document.getElementById("phref").style.display = 'block';	
	                document.getElementById("phref").value = "Online "+num_onl;
				}
				document.getElementById("indivpch").innerHTML =  _content[1];
				// $("#indivpch").customscroll( { direction: "vertical" } );

                setTimeout(chat_login,5000);
         }

     ).error(function (){
		 
		 setTimeout(chat_login,5000);
		 }); 
    }
	

	function num_msg()
        {
            $.post(PTH+"/msg/num.php",{is_session:true},function(data){
				if(data.toString().length > 0)
				{
                	$("#bnum").html(data);
					$("#bnum").fadeIn(1000);
				}else $("#bnum").fadeOut(10000);
                setTimeout(plate_no,2500);
            }).error(function (){setTimeout(plate_no,5000);});
        }
				function platetab()
				{
						setTimeout(function (){
							$("#_platen").html("");
							},60000);	
				}
		function plate_no()
		{
			try
			{
				var _platen = document.getElementById("_platen");
				if(_platen)
				{
				  $.post(PTH+"/actions/platenumber.php",{is_session:true},function(data)
				  {		
					  try
					  {		  
							var n = !isNaN(parseInt(_platen.innerHTML))?_platen.innerHTML:0;
							var nn = !isNaN(parseInt(data))?data:0;
							if(n == 0 || nn > n)
							{
								_platen.innerHTML = nn== 0?"":nn;	
								if(nn > 0)$(".num").fadeIn(1000);else (".num").fadeOut(1000);					
								if(nn > n)
								{
									$.post(PTH+"/actions/plate.php",{page:0},function (data){
										var ip = document.getElementById("plate");
										if(ip)
										{
											ip.innerHTML = data;
										}
									});
								}
							}
						}
						catch(err)
						{
							
						}
					setTimeout(get_chat_vars,2500);
				   }).error(function (){setTimeout(get_chat_vars,5000);});
				}
				else
				{
					get_chat_vars();
				}
			}
			catch(eee)
			{
				get_chat_vars();	
			}
		}
function chat_login()
{
    
    $.post(PTH+"/chatt/getop.php",{is_session:true}, function (data)
    {
        dg = data;
		
        var ems = dg.split("__c");
        var exc = new Array();
        var sss = new Array();
        var id = new Array();
            for (var d = 1; d < ems.length;d++)
            {
                try
                {
                    exc[d] = ems[d].split("_");
                    sss[d] = exc[d][0];
                    id[d] = exc[d][1];
                    chatwith(sss[d],id[d],false);
                }
                catch(Rare_error)
                {
					//alert(Rare_error + "chatLogin[function]");
                   //pwin("none","Error Getting Open Chats",Rare_error,null,null,null);
				  
                }
            }
			setTimeout(num_msg,2500);
    }).error(function (){setTimeout(num_msg,5000);});
	
	;
}

    
	var fll = false;
	var int_i = 0;
	var intss = new Array();
	var intoo = new Array();
	function formEvent(e)
		{
			e = e?e:window.event;
			this.id = e.target?e.target:e.srcElement;
			this.txt = this.id.firstChild;
			this.nxt = this.id.nextSibling;
			this.parent = this.id.parentNode;
			//this.parentP8 = this.id.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
			this.firstBrother = this.id.parentNode.firstChild;
			//this.parent7= this.id.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
		}
	function inscc(e,id)
	{	
	    var form_e = new formEvent(e);
		var d = new Date();
		var am_pm ="am";
		var hr = parseInt(d.getHours().toString());
    	if (hr > 12){hr = hr - 12;am_pm = "pm";}
		var minn = (d.getMinutes() < 10)?"0" + "" + d.getMinutes().toString():d.getMinutes();
		var dd = hr + "<b>:</b>"  + minn +am_pm;
	   var chatmsg = form_e.txt.value;
	    $.post(PTH+"/chatt/send.php",{id:id,msg:chatmsg,time:dd},function(data){
		form_e.txt.nextSibling.value = 2;
         cRom(id);
            });
	    form_e.txt.value = "";  
	}
    var msg_chat = new Array();
    var pals = new Array();
	var npals = new Array();
    var cht_rum = new Array();
    var msg_old = new Array();
    var _redo = true;
    function get_chat_vars()
    {
        $.post(PTH+"/chatt/pop.php",{is_session:true},function(data){
        var inf = data.toString().split("__::__");
		for(var i = 0; i < inf.length;i++)
		{   
			try
			{
				msg_chat[i]  = inf[i].split(":")[1].split("=")[0];
				cht_rum[i] = inf[i].split(":")[1].split("=")[1];
				pals[i] = inf[i].split(":")[0];
			}
			catch(bigError)
			{
			//	alert(bigError);
			}
		}	
		if(pals.length != npals.length)
		{
			_redo = true;	
		}
		else
		{
			_redo = false;
		}
		if(_redo)
		{
			for (var p =0;p < msg_chat.length;p++)
			{
				msg_old[p] = msg_chat[p];
				npals[p] = pals[p];
			}
		}
		check_length();
		});
    }   

function check_length()
{
    for(var j = 0;j < msg_old.length;j++)
    {
        if (msg_old[j] != msg_chat[j])
        {
			if(parseInt(msg_chat[j]) != 0)
			{
           		chatwith(pals[j],cht_rum[j],true);

				//try{$("#lowdiv").prepend("<embed src='"+PTH+"/chatt/aud.swf' height='0' width='0'/>");}catch(_ewor){alert(_ewor);}
			}
           msg_old[j] = msg_chat[j];
        }
    }
	setTimeout(num_online,5000);
}
var ttop = 230;
var tleft = 10;
function chatwith(friend,id,_open)
    {   	
        $("#divpch").fadeOut(200);
        var fr = friend.toString();
    	var lowdiv = document.getElementById("lowdiv");
    	var boo = true;
        var cl = "";
    	if(document.getElementById("f"+fr)!= null){boo=true;}else{boo = false;}
	    if (!boo)
	        {	
	        	var fr_hd = document.createElement("input");
	  	 		fr_hd.type = "hidden";
    	        fr_hd.id  = "f"+fr;
    	        fr_hd.value = int_i;
				var bz_hd = document.createElement("input");
	  	 		bz_hd.type = "hidden";
				bz_hd.value = 0;
    	        var _cupd = document.createElement("input");
				_cupd.id = ("p"+id);
				_cupd.type = "hidden";
				_cupd.value = 0;
    	        lowdiv.appendChild(_cupd);
                $.post(PTH+"/chatt/saveop.php",{user:friend,id:id},function (data){});
 	            var chtwin = document.createElement("div");
	            chtwin.innerHTML = "<center><br/><br /><br/><br/><br /><img src='"+PTH+"/img/load/al.gif'/><br/><br/></center>"; 
                var chrow = document.getElementById("chrow");
                var chattxt = document.createElement("input");
                chattxt.type = "text";
                var chform = document.createElement("form");
                chattxt.className = "txt_c";
                chform.appendChild(chattxt);
				chform.appendChild(bz_hd);
				lowdiv.appendChild(fr_hd);
                chform.setAttribute("action","javascript:return false;");
                chform.onsubmit = function (event)
                {
                    inscc(event?event:window.event,id);
                }
                var txvvv = document.createElement("div");                
                txvvv.appendChild(chtwin);
                txvvv.appendChild(chform);
                txvvv.className = "chit";
				txvvv.ondblclick = function (){
				$(txvvv).slideToggle(200);	
				}
				//txvvv.title = "You can drag this chat box around the page";
				if(ttop > 300)
				{
					 ttop = 230;	
//					 tleft = tleft + 50;
				}
				ttop += 30;
				tleft += 50;
				txvvv.style.top= ttop +"px";
				txvvv.style.left = tleft+"px";
				//txvvv.onmousedown = function (event)
				//{
					//var e = event?event:window.event;	
					//drag(e);
				//}
				txvvv.onmouseover = function()
				{
				//		 try{document.getElementById("_zp"+id).focus();}catch(__a){}	
				//	    try{chattxt.focus()}catch(_no_way){}				   
				}
			
				chrow.appendChild(txvvv);
				
                boo = true;
                // $(tdd).fadeIn(500);
                var brow = document.getElementById("brow");
                var btd = document.createElement("td");
                btd.valign = "center";
                var pbtt = document.createElement("div");
                pbtt.className = "chatbtt";
                pbtt.onclick = function(){

                $(txvvv).slideToggle(200,function(){								
					document.getElementById("chat"+id).style.display = "block";
					//$("#chat"+id).niceScroll({cursorborder:"",cursorcolor:"#336699",boxzoom:false});
					   try{document.getElementById("_zp"+id).focus();}catch(__a){}	
					    try{chattxt.focus()}catch(_no_way){}				   
					   });
				   
				//	c1st.push(id); 
                }
                btd.appendChild(pbtt);
//				btd.style.width = "120px";
                var a = document.createElement("a");
                a.href="#";
                a.onclick = function () {
                    
                  minh(txvvv,btd,friend,id);  
                };
                
		        a.innerHTML  = "<img src='"+PTH+"/img/mg/x.png' />";//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                a.className = "xxp";
               
                 
				$.post(PTH+"/chatt/chitchat_.php",{id:id},function (data){
				chtwin.innerHTML = data;	
				if(c1st.indexOf(id)<0)
				{
					
					var drag_div = "#drag_div_"+id;
					var scolor = $(drag_div).attr("color");
					$(txvvv)
						.bind('dragstart',function( event ){
							if ( !$(event.target).is(drag_div) ) return false;
							 $( this ).addClass('drag_active');
								//return $(event.target).is(drag_div);
						})
						.bind('drag',function( event ){
						 $( this ).css({
							top: event.screenY-($(this).height()/2)+ ($(drag_div).height()/2) + 4,
							left: event.offsetX
							})
							 .bind('dragend',function( event ){
					$("#chat"+id).niceScroll({cursorcolor:scolor,cursoropacitymax:0.7,boxzoom:false,touchbehavior:false}).resize();
					$( this ).removeClass('drag_active');})
						
					});
				//	$("#chat"+id).niceScroll({cursorborder:"",cursorcolor:"#994499",boxzoom:false});
	
				}
				cRom(id);
				
				_ponline(id,friend);
				var aS = chtwin.getElementsByTagName("a");					   
			   pbtt.innerHTML = aS[1].innerHTML;
               a.title = "Close Chat with "+aS[1].innerHTML; 
			   
               brow.appendChild(btd);
			   pbtt.appendChild(a);	
			   				processVars();			
				var dload_interval = function () { 
					cRom(id);
				}
				var onl_interval = function() {
					_ponline(id,friend);	
				}
				var sssint = setInterval(function (){dload_interval()},5000);
				var sssint2 = setInterval(function (){onl_interval()},120000);
                intss[int_i] = sssint;
				intoo[int_i] = sssint2;
                int_i++;	
				});
				if(!_open){txvvv.style.display = "none";}
          }
}
var _ponline = function(id,uid){
	
	$.post(PTH+"/chatt/o_.php",{id:id,uid:uid},function(data){
		try
		{
		document.getElementById("o"+id).innerHTML = data;
		}catch(ee)
		{
			//alert(ee);
		}
		});
}
var cchat = function(id){
    	$.post(PTH+"/chatt/cchat_.php",{id:id});
	}
	var _locChat = function (e,bool,idv)
	{
		return;
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		var txtvv = id.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
		if(!bool)
		{
			id.src='"+PTH+"/img/mg/lock.png';
			id.title = "Enable dragging of this window";
			id.onclick = function (event){_locChat(event?event:window.event,true,idv);}
			$(txtvv).bind("drag",function (e){})
			.bind("dragstart",function (e){})
			.bind("dragend",function (e){});
			//txtvv.onmousedown = function (){}
		}
		else
		{
			id.src='"+PTH+"/img/mg/opn.png';
			id.title = "Disable dragging of this window";
			id.onclick = function (event)
			{
				_locChat(event?event:window.event,false,idv);
			}

			var drag_div = "#drag_div_"+idv;	
				$(txtvv)
					.bind('dragstart',function( event ){
						if ( !$(event.target).is(drag_div) ) return false;
               			 $(this).addClass('drag_active');

					})
					.bind('drag',function( event ){
               		 $( this ).css({
                        top: event.screenY-($(this).height()/2)+ ($(drag_div).height()/2) + 4,
                        left: event.offsetX
                        })
					.bind('dragend',function( event ){
				$("#chat"+idv).niceScroll({cursorcolor:"#333",cursoropacitymax:0.7,boxzoom:false,touchbehavior:false}).resize();
                $(this).removeClass('drag_active');})
					
              	});
		//	txtvv.onmousedown = function (event)
		//	{
		//		drag(event?event:window.event)
		//	}	
		}
	}
_vib = 0;
var _vibrate = function (element)
{
	_title_(element);
	var left_p = parseInt(element.style.left) + 5;
	var left_m = parseInt(element.style.left) - 5;
	var left = parseInt(element.style.left);	
	var ppa = function () {
	$(element).animate({left:left_p +"px"},25,function(){$(element).animate({left:left_m + "px"},25,_redo_()
	
	); });}
	var _redo_ = 	function()
	{
		_vib++;
		if(_vib < 15)
		{
			ppa();
		}
		else
		{
			_vib = 0;
		}
	}
	_redo_();

}
var _title_ = function (e)
{

	try{
		var c = e.getElementsByTagName("a");
		var a = false;
		for(var i in c)
		{
			if(c[i].className == "_mn_")
			{
				a = c[i];
				break;
			}
		}
		var tt = document.title;
		var t = a.innerHTML;
		var n = 0;
		var inta = setInterval(function (){
			n++;
				//window.getAttention();
				if(document.title != tt)
				{
					document.title = tt;
				}
				else
				{
					document.title = "New chat from "+ t;	
				}
				if(n == 15)
				{
					clearInterval(inta);
					document.title = tt;
				}
			},500);
	}
	catch(err)
	{
		//alert(err);	
	}
}
var c1st = new Array();
function cRom(id)
	{	
		var mywall = false;try{mywall = new XMLHttpRequest();}catch (e1){try{mywall = new ActiveXObject("Microsoft.XMLHTTP");}catch(e2){
		try{mywall = new ActiveXObject("Msxml2.XMLHTTP");}catch(e3){mywall = false;}}}
		if (mywall){ 
		var postdata = "id="+id;
        mywall.open ("POST",PTH+"/chatt/c_.php",true);
		mywall.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		mywall.onreadystatechange = function()	{
	    if (mywall.readyState==4 && mywall.status == 200)	
	    {
			
				var chtid = document.getElementById("chat"+id);

				try
				{
					var txttv = chtid.parentNode.parentNode;	            
					if(txttv.style.display == "block")
					{
						
					}
					var bz_hd = chtid.parentNode.nextSibling.childNodes[1];
					var buzz = bz_hd.value == 1?true:false;
					var _len = parseInt(mywall.responseText.length);
					var _cupd = document.getElementById("p"+id);
					chtid.innerHTML = smiley(_str(mywall.responseText));
					var scolor = $("#drag_div_"+id).attr("color");
					$(chtid).niceScroll({cursorcolor:scolor,cursoropacitymax:0.7,boxzoom:false,touchbehavior:false}).resize();
					try{
					chat_time("chat"+id);
					}catch(ee){alert(ee);}
					if(_cupd.value != 0 && _len - _cupd.value > 1 && buzz)
					{
						chtid.innerHTML += "<embed src='"+PTH+"/chatt/aud.swf' height='0' width='0'/>";	
						txttv.style.display = "block";
						_vibrate(txttv);
						try{document.getElementById("_zp"+id).focus();chtid.parentNode.nextSibling.firstChild.focus();}catch(__a){}
					}
					_cupd.value = _len;
					if(!buzz)
					{
						
						try{document.getElementById("_zp"+id).focus();chtid.parentNode.nextSibling.firstChild.focus();}catch(__a){}
					}
					chtid.parentNode.nextSibling.firstChild.style.visibility = "visible";
					bz_hd.value = 1;
					
					if(c1st.indexOf(id) < 0)
					{
						
						c1st.push(id);
					}
				}
				catch(_closed_)
				{
					//alert(_closed_ + "cRom[function]");
				}
	        }
    	}
        mywall.send(postdata);
    }
}// JavaScript Document

function minh(cdiv,ddiv,friend,id)
	{	
		$.post(PTH+"/chatt/closeop.php",{user:friend,id:id});
		var hd = document.getElementById("f"+friend);
		if (cdiv && ddiv)
		{
			$(cdiv).fadeOut(500,function()
			{
			    cdiv.parentNode.removeChild(cdiv);
                ddiv.parentNode.removeChild(ddiv);
                         });
			clearInterval(intss[parseInt(hd.value)]);
			clearInterval(intoo[parseInt(hd.value)]);
			hd.parentNode.removeChild(hd);
		}
	}
	var smiley = function (filter)
{
	var string = filter.toString();
	while(string.indexOf("3:)") > -1){string = string.replace("3:)","<img src='"+PTH+"/img/sm/de.png'/>");}
	while(string.indexOf(":v") > -1){string = string.replace(":v","<img src='"+PTH+"/img/sm/m.png'/>");}
	while(string.indexOf(":3") > -1){string = string.replace(":3","<img src='"+PTH+"/img/sm/3.png'/>");}
	while(string.indexOf("&gt;:o") > -1){string = string.replace("&gt;:o","<img src='"+PTH+"/img/sm/_.png'/>");}
	while(string.indexOf("0:)") > -1){string = string.replace("0:)","<img src='"+PTH+"/img/sm/a.png'/>");}
	while(string.indexOf("&gt;:(") > -1){string = string.replace("&gt;:(","<img src='"+PTH+"/img/sm/n.png'/>");}
	while(string.indexOf(":&#039;(") > -1){string = string.replace(":&#039;(","<img src='"+PTH+"/img/sm/c.png'/>");}
	while(string.indexOf(":-*") > -1){string = string.replace(":-*","<img src='"+PTH+"/img/sm/k.png'/>");}
	while(string.indexOf("&lt;3") > -1){string = string.replace("&lt;3","<img src='"+PTH+"/img/sm/l.png'/>");}
	while(string.indexOf("^_^") > -1){string = string.replace("^_^","<img src='"+PTH+"/img/sm/q.png'/>");}
	while(string.indexOf("-_-") > -1){string = string.replace("-_-","<img src='"+PTH+"/img/sm/t.png'/>");}
	while(string.indexOf("0.o") > -1){string = string.replace("0.o","<img src='"+PTH+"/img/sm/o0.png'/>");}
	while(string.indexOf(":)") > -1){string = string.replace(":)","<img src='"+PTH+"/img/sm/d.png'/>");}
	while(string.indexOf(":(") > -1){string = string.replace(":(","<img src='"+PTH+"/img/sm/s.png'/>");}
	while(string.indexOf(":0") > -1){string = string.replace(":0","<img src='"+PTH+"/img/sm/o.png'/>");}
	while(string.indexOf(":P") > -1){string = string.replace(":P","<img src='"+PTH+"/img/sm/p.png'/>");}
	while(string.indexOf(";)") > -1){string = string.replace(";)","<img src='"+PTH+"/img/sm/w.png'/>");}
	while(string.indexOf("8|") > -1){string = string.replace("8|","<img src='"+PTH+"/img/sm/81.png'/>");}
	while(string.indexOf("8)") > -1){string = string.replace("8)","<img src='"+PTH+"/img/sm/8.png'/>");}
	while(string.indexOf(":|]") > -1){string = string.replace(":|]","<img src='"+PTH+"/img/sm/r.png'/>");}
	while(string.indexOf(":D") > -1){string = string.replace(":D","<img src='"+PTH+"/img/sm/dd.png'/>");}
	while(string.indexOf(":\\") > -1){string = string.replace(":\\","<img src='"+PTH+"/img/sm/0.png'/>");}
	return string;
}