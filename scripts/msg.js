var _cid = 0;
var _set_ = function (e)
{
	try
	{
		e = e?e:window.event;
		var id = e.target?e.target:e.srcElement;
		var hdd = id.nextSibling;	
		var val = "";
		if(!hdd || !hdd.value)
		{
			hdd = id.parentNode.nextSibling;
			if(!hdd || !hdd.value)
			{
				hdd = id.parentNode.parentNode.parentNode.parentNode.nextSibling;	
				
				id.parentNode.parentNode.parentNode.parentNode.parentNode.previousSibling.value = id.parentNode.parentNode.parentNode.parentNode.getAttribute("title");	
				val = hdd.value;	
				id.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.value = val;
				return true;
			}
			id.parentNode.parentNode.previousSibling.value = id.parentNode.getAttribute("title");	
			val = hdd.value;	
			id.parentNode.parentNode.firstChild.value = val;
		}
		else
		{
			id.parentNode.previousSibling.value = id.getAttribute("title");	
			val = hdd.value;
			id.parentNode.firstChild.value = val;
		}
	}
	catch(_E_)
	{
		
	}
}
function _msg_plst(e)
{
	e = e?e:window.event;
	var id = e.target?e.target:e.srcElement;
	var s = id.value;
	$.post(PTH+"/msg/plst.php",{s:s,nm:0},function(data){
		id.nextSibling.innerHTML = data;
		});
}
function sendNew()
{
    var subject = document.getElementById("txt_subj").value;
	var txt_subj = document.getElementById("txt_subj");
    var toh = document.getElementById("_hedin").value;
    var msgTxt = document.getElementById("txtEd").value;
	var txtEd = document.getElementById("txtEd");
	doLoading(true);
    $.post(PTH+"/msg/send.php",{u2:toh,msg:msgTxt,subj:subject},function(data){
	genbox();
 //   pwin("none","Status Report",data,"_go(null,'./msg/',cid)",usem,null);
 if(data != 1)
 {	
	$("#pwin").html("Error occured. please try again <br/><b>"+ data + "</b>"); 
	pwin("#pwindow");
 }
 else
 {
	 $("#pwin").html("<div align='center' class='pwndiv'>Message successfully Sent <Br/><input type='button' class='button1' onclick='_go(event)' href='?msg/' go='"+PTH+"/msg/' value='Inbox?' /></div>");
		pwin("#pwindow"); 
		txtEd.value ="";  txt_subj.value="";
 }
           });
}
var dms = 0;
function delmsg(cid,e)
{
    dms++;
		$("#pwin").html("<div id='dms"+dms+"' align='center' class='pwndiv'>Are you sure you want to delete this message?<br/><br/><input type='button' class='button1' value='DELETE' onclick='dmsg("+cid+")' /></div>"); 
			pwin("#pwindow");
 //   pwin(e,"Delete Message","<div id='dms"+dms+"'>Are you sure you want to delete this message?</div>","dmsg(cid)",cid,"close");
}
function dmsg(cid)
{
	doLoading(true);
    $.post(PTH+"/msg/delmsg.php",{cid:cid},function(data){
		doLoading(false);
        document.getElementById("dms"+dms).innerHTML = data;
        if(_cid != 0)
        {
            shwmsg(_cid);
        }
		
			$('#pwindow').fadeOut(500);
        });
}
function sendmsg(id,e)
{
		e = e ?e :window.event;
		var bid = e.target?e.target:e.srcElement;
		bid.disabled = true;
    var msg = document.getElementById("txtamsg").value;
    $.post(PTH+"/msg/send.php",{msg:msg,id:id},function(data){
		document.getElementById("txtamsg").value = "";
		bid.disabled = false;
		shwmsg(id);});    
}
function genbox()
{
  //	var l = new limg();
//	document.body.appendChild(l);
   
    $.post(PTH+"/msg/inbox.php",{is_session:true},function(data){
		$("#inbox_m").html(data);
		doLoading(false);
	//	document.body.removeChild(l);
		});
}

function shwmsg(id)
{
    _cid = id;
	doLoading(true);
    $.post(PTH+"/msg/msg.php",{id:id},function(data){document.getElementById("inbox_m").innerHTML = _str(data);
	doLoading(false);
	});
}

function getInbox()
{
   
    $.post(PTH+"/msg/inbox.php",{is_session:true},function(data){$("#inbox_m").html(data);});
}
function plst()
{
    $.post(PTH+"/msg/plst.php",{is_session:true},function(data){document.getElementById("divppp").innerHTML = data;});
}
function getnots()
{
   
    $.post(PTH+"/msg/not.php",{is_session:true},function(data){$("#msg_not").html(data);});
}
 
 var dc = 0;
function delconv(cid,e)
{
    dc++;

		$("#pwin").html("<div id='dc"+dc+"' align='center' class='pwndiv'>Are you sure you want to permanently delete this Conversation? <br/> <span style='color:#333;font-size:11px;'>* NOTE your friend won't see it again</span><br/><br/><input type='button' class='button1' value='DELETE' onclick='dconv("+cid+")' /></div>"); 
			pwin("#pwindow");
  //  pwin(e,"Delete Message","<div id='dc"+dc+"'>Are you sure you want to permanently delete this Conversation? <br/> <span style='color:#888888;font-size:11px;'>* NOTE your friend won't see it again</span></div>","dconv(cid)",cid,"close");
}
function dconv(cid)
{
	doLoading(true);
    $.post(PTH+"/msg/delconv.php",{id:cid},function(data){
        document.getElementById("dc"+dc).innerHTML = data;
      //  if(_cid != 0)
      // / {
		  
			$('#pwindow').fadeOut(500);
            genbox();
       // }
		
        });
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