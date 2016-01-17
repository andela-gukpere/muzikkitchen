 <table cellpadding="10" width="100%" ><tr><td valign="top" width="15%">
    <div class="smpdiv" style="background:url(.<?php echo $_SESSION["img1"]; ?>) center no-repeat;" ></div></td><td valign="top"><b>225</b><br/><textarea name"post"  placeholder="What's Cooking?" rows="4" onkeyup="gment(event)" cols="10" onkeydown="fixlength(event)"  id="txtdiv"></textarea><br/><div class="pl2div" onclick="$(this).slideUp(200);"></div><br/>
    <input type="button" value="Feed" onclick="_post(0,0,event)" name="post_" class="button1" style="float:left;" /></td></tr></table>
<div align="center" class="mndiv"><ul class="menu">
    <li >
    <a href="./?table" class="se">My Table</a>
    </li>
    <li>
    <a href="./?mentions">Mentions</a>
    </li>
    <li>
    <a href="./?msg">Messages <b id="msg_num"><?php echo $_SESSION["msg_num"] ?></b></a>
    </li>
    <li>
    <a href="./?plate">My Plate <b id="plate_num"><?php echo $_SESSION["plate_num"] ?></b></a>
    </li>
    <li>
    <a href="./?likes">Likes</a>
    </li>
    <li>
    <a href="./?dine_with=1">Dining with</a>
    </li>
    <li>
    <a href="./?dine_with=2">Dining with me</a>
    </li>
    <li>
    <a href="./?reposts">Refeeds</a>
    </li>
    </ul>
    </div>
       <div id="_main_">
    	<div id="m_t_b">
               <?php include_once("./actions/load.php"); ?>
        </div>
        <script>
		   gposts(2,"m_t_b");
		   get_posts();
		   
		   $.post("../msg/num.php",{session:true},function (data){
			   
			   $("#msg_num").html(data);
					$.post("../actions/platenumber.php",{session:true},function (data){
			   
			   $("#plate_num").html(data);

			   });
			   });
        </script>
    </div>