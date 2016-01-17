<?php
 $id = intval($_GET["rep"]);
$u = $_GET["u"];
$t = intval($_GET["t"]);
$con = new db();$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,post,user FROM post WHERE id=$id");
$r = mysqli_fetch_array($q);
 ?>
 <div align="center" class="mndiv">
 <ul class="menu">
    <li>
    <a href="./?table">Go Home</a>
    </li>
    </ul>
    
    </div>
 <table cellpadding="10" width="100%" ><tr><td valign="top" >
 
    <div class="smpdiv" style="background:url(.<?php echo $_SESSION["img1"]; ?>) center no-repeat;" >
    </div>
    </td><td valign="top" width="85%"><b>225</b><br/><textarea name="post"  placeholder="What's Cooking?" rows="4" cols="50"  onkeydown="fixlength(event)"  id="txtdiv"></textarea><br/>
    <input type="button" value="Feed" onclick="_post(<?php echo "$t,$r[0]" ?>,event);" name="post_" class="button1" style="float:left;" /></td></tr></table>
    <Div><?php 
	echo ($t == 1?"Reply To: ":"Refeed from: ")."<a href='./$u'>@$u</a>";
	?></Div>
    <div id="tempdiv" style="display:none;height:0px;"></div>
    <script type="text/javascript">
	var type = <?php echo intval($t); ?>;
	var ret ="";
	if(type == 1)
	{
		 ret = _str("<?php echo trim("Re: @$u ");?>");
	}
	else
	{
		 ret = _str("<?php echo trim("RF: @$u ".$r[1]); ?>");
	}
	$("#tempdiv").html(ret);
	
	document.getElementById("txtdiv").value = $("#tempdiv").text();
	</script>
<?php 	$con->close_db_con($conc); ?>