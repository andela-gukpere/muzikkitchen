<?php 
session_start();
if(!isset($_SESSION["uid"]))
{
	//header("location: ../");	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Muzik Kitchen Mobile</title>

<link rel="stylesheet" href="../scripts/style.css" type="text/css" media="all" />
<script>

</script>
<body>
<a href="../?logout" style="float:right;color:#888;margin-right:10px;">Logout</a>
<div align="center"><table><Tr><td><a style="font-size:20px;" href="../"><img src="../../img/logo.png" /></a></td><td>Welcome</td></Tr></table></div>
<div id="container">
<Table cellpadding="5" cellspacing="10" rules="rows">
<tr><th colspan="2">Quick Tips</th></tr>
<tr><Td><img src="../../img/spacer.gif" class="ff" title="dine with " /></Td>
<td>To dine with peeps::Their feeds will appear on your table</td></tr>
<tr><Td><img src="../../img/spacer.gif" class="unff" title="undine with" /></Td><td>To undine with peeps::The opposite of the former</td></tr>
<tr><Th>Feed</Th><td>To create what you might call a post, a status or a share.</td></tr>
<tr><Th>Refeed</Th><td>As the name implies, to re-send a feed you have seen on your table. (it will be referenced)</td></tr>
<tr><Th>Reply</Th><td>As the name implies, to reply to a feed you have seen on your table. (it will also be referenced)</td></tr>
<tr><th>Settings</th><td>You can change your username, password, email, profile picture and every other information when you login via PC at <a href="http://www.muzikkitchen.com/?force_web">www.muzikkitchen.com</a></td></tr>
<tr><th>Media</th>
<td>Users are allowed to add media such as music, pictures and videos, but only via the  PC version of the site<Br />For more info about user rights, terms and conditions, license agreement visit our <a href="http://www.muzikkitchen.com/tos">Terms Of Service</a> via PC</td></tr>
<Tr><th>Chatting</th><td>Our unique chats takes place between you and people that you dine with mutually. i.e. you dine with user1 and user1 dines with you. (This application is only available on the PC version of the website)</td></Tr>
<tr><th></th><th><input type="button"  onclick="window.open('../../','_parent')" class="button1" value="Continue to home page"/><br/>            <br />Return to this page anytime by clicking on <A href="../getting_started/">Getting started</A> in the footer.</th></tr>
</Table>
</div>
</body>
</head></html>