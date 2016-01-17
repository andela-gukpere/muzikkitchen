<table cellpadding="10" width="100%" ><tr><td valign="top" width="15%">
    <div class="smpdiv" style="background:url(.<?php echo $_SESSION["img1"]; ?>) center no-repeat;" ></div></td><td valign="top"><b>225</b><br/><textarea name"post"  placeholder="What's Cooking?" rows="4" cols="10" onkeydown="fixlength(event)"  id="txtdiv"></textarea><br/>
    <input type="button" value="Feed" onclick="_post(0,0,event)" name="post_" class="button1" style="float:left;" /></td></tr></table>
<div align="center" class="mndiv"><ul class="menu">
    <li>
    <a href="./?table">My Table</a>
    </li>
    <li>
    <a href="./?mentions" class='se'>Mentions</a>
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
    <Br/><hr/>
    <Div id="m_t_b">       <?php include_once("./actions/load.php"); ?></Div>
    <script>
    gposts(4,"m_t_b");
    </script>