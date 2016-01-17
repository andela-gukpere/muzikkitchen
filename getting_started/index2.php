<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>: Muzik Kitchen | Getting Started :</title>

<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../scripts/jqtabs1.8.css"/>
<script src="../scripts/jquery.js"  type="text/javascript"></script>
<script type="text/javascript" src="../scripts/jqtabs1.8.js"></script>
</script>

</head>

<body>

	<div id="container" style="width:90%;">
    <div>
        <div id="tabs" >
        	<ul  style="background-color:#fff !important;">
            	<li><a href="#step1" ><img src="../img/step1.png" /></a></li>
              	<li><a href="#step2"><img src="../img/step2.png" /></a></li>
	          	<li><a href="#step3"><img src="../img/step3.png" /></a></li>
				<li><a href="#step4"><img src="../img/step4.png" /></a></li>
				<li><a href="#step5"><img src="../img/step5.png" /></a></li>
            </ul>
			<div id = "step1" style='font-size:30px'>License Agreement information<Br/>Goes here</div>
			<div id = "step2"><img src='' height='240' width='480' />
			the <a href='../home/?home'>Home</a> menu takes you to the initial page on login.<Br/>It contains your main post page, where you see posts made by the 
			users you follow. This appears under the 'Main' tab. Under the 'Mentions' tab you see all the instances in which your user handle was mentioned in a post.
			In the 'Gallery', 'Music' and 'Video' tabs you'll see all the media you added to your account respectively. The 'Voting and Polling' tab is still under beta testing.
			<br/><br/>
			</div>
			<div id='step3'>
			The Profiles page consists of info and items belonging to the current profile in view, either yours or another user.<Br/>
			The 'Main' tab contains only the posts made by the user in view<br/>
			The 'Mentions' tab contains all the instances in which the user in view was referenced/mentioned in a post.<Br/>
			The 'Followers' and 'Following' Tabs contains the users which follow the user in view as well as the users he/she follows<br/>
			The 'Gallery', 'Music' and 'Videos' tabs contains the media the user in view has uploaded.
			</div>
			<div id='step4'>
			The 'Messages' menu takes you to the page where the messages are handled. Note you are allowed to send messages to only users that follow you. This 
			was enforced inorder to avoid unwarranted spams.
			<Br/>
			Chatting is done on a one-on-one basis. At the bottom left corner of the screen you see and 'Online' button, it will contain the number of pals you hav that
			<br/>are online so you can chat with them. 'Pals' in this instance identifies the users that have mutual followership, which means you follow he/she<Br/>
			and he/she follows you back. If the above condition is satisfied, then you the user will appear online and you could have a private chat.<br/>
		
			</div>
			<div id='step5'>
				The 'Edit my Media' page allow you to add and remove the various media you previously added. In any of the tabs which are 'Gallery', 'Music' and 'Videos' you<br/>
			are allowed to delete previously added content,as well as add new ones.<br/><br/>
			The 'Settings' page enables you to change your user information, password and account settings.. Each of which are embedded in their various tabs,<br/>
			You profile image can be changed there as wells as your username, email, password, bio, location, language and much more.
			</div>
                     <input type="button" onclick="window.location = '../home/?settings';" value="Continue to home" class="button1" style="padding:20px;" />
        </div>

        </div>

    </div>
    <script>
	$(document).ready(function (){
		
		$("#tabs").tabs();
		
		});
	</script>
</body>
</html>