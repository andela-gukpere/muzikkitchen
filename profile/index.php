<?php
session_start();
include("../scripts/db.php");
$id = $_GET["id"];
$_SESSION["id"] = $id?$id:$_SESSION["id"];
$con = new db();$conc = $con->c();
if(!isset($id))
{
	header("location: ../home/");	
}
$q = mysqli_query($conc,"SELECT * FROM prof WHERE em = '$id'");
$r = mysqli_fetch_array($q);
mysqli_close($con->c());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Muzik Kitchen | <?php echo $r[2]; ?></title>
</head>

<style type="text/css">

</style>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script src="../scripts/jquery.js"  type="text/javascript"></script>
<script src="../scripts/script.js"  type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
 
	$(".music").click(function(){
		$("#music").slideToggle(200);
		$("#video").hide();
		$("#art").hide();
		$(this).toggleClass("active"); return false;
	});
	
	$(".video").click(function(){
		$("#video").slideToggle(200);
		$("#music").hide();
		$("#art").hide();
		$(this).toggleClass("active"); return false;
	});
	
	$(".art").click(function(){
		$("#art").slideToggle(200);
		$("#music").hide();
		$("#video").hide();
		$(this).toggleClass("active"); return false;
	});
	
	 
});
	
		
</script>

<script type="text/javascript">


</script>


<!--script src="../scripts/popcorn.js"></script>
    <script>
      // ensure the web page (DOM) has loaded
      document.addEventListener("DOMContentLoaded", function () {

         // Create a popcorn instance by calling Popcorn("#id-of-my-video")
         var pop = Popcorn("#myaudio");
		  var pop = Popcorn("#myvideo");

         // add a footnote at 2 seconds, and remove it at 6 seconds
         pop.footnote({
           start: 2,
           end: 10,
           text: "Nobody test Me",
           target: "footnotediv"
         });

         // play the video right away
         pop.stop();

      }, false);
    </script-->

<nav><img src="../img/logo.png"/></nav>
<body>

<div id="container">
	<div id="leftcolumn">
    <table><tr><td>
    	<div class="profilepic" style="background:url(<?php echo $r[5]; ?>);" onmouseover="anim(event)" onmouseout="anim2(event)"></div></td><td>
        <div id="detail">
        	<h1><?php echo $r[2] ?></h1>
            <h2><?php echo $r[3]?></h2>
            <h2><?php echo $r[6]?></h2>
        </div>
        </td></tr></table>
        <br/>
        <div><?php echo $r[7] ?></div>
    </div>
    
    <div id="rightcolumn">
    	<div id="panel">
        	<a href="#" class="music" title="Music"></a>
            <a href="#" class="video" title="Video"></a>
            <a href="#" class="art" title="Pictures"></a>
            <a href="#" class="follow" title="Follow"></a>
        </div>
        
        <div id="music">
        	<h1><?php echo $r[2]?>'s Music</h1>
            <ul>
                <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM music WHERE user = $r[0]");
					while($rr = mysqli_fetch_array($q))
					{
						echo "<a href='#dialog' name='modal'><li title='$rr[3]' onclick='playmusic(event)' mname='$rr[2]' info='$rr[3]' music='$rr[4]' mdate='".date("l jS F Y g:i:a",$rr[5])."'>$rr[2]</li></a>";	
					}
				?>
            </ul>
            
            <h1>Featured Music</h1>
            <ul>
            	<?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM music ORDER BY RAND()");
					while($rr = mysqli_fetch_array($q))
					{
						echo "<a href='#' ><li title='$rr[3]' onclick='playmusic(event)' mname='$rr[2]' info='$rr[3]' music='$rr[4]' mdate='".date("l jS F Y g:i:a",$rr[5])."'>$rr[2]</li></a>";	
					}
				?>
            </ul>
        
        </div>
        
        <div id="video">

        <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM videos WHERE user = $r[0]");
					while($rrr = mysqli_fetch_array($q))
					{
						echo "<a href='#dialogvideo' name='modal'><span class='cspan' title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]' info='$rrr[3]' vidname='$rrr[2]' vdate='".date("l jS F Y g:i:a",$rrr[6])."'>$rrr[2]</span></a><br/>";	
					}
				?>
   
        </div>
        <div id="art">
         <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM art WHERE user = $r[0]");
					while($rr = mysqli_fetch_array($q))
					{
						echo "<a href='#dialogpicture' name='modal'><div style='background:url($rr[4]) no-repeat center;' class='smpdiv' title='$rr[3]' onmouseover='anim(event)' onmouseout='anim2(event)' onclick='playart(event)' art='$rr[6]' aname='$rr[2]' adate=''".date("l jS F Y g:i:a",$rr[7])."''></div></a><br/>";	
					}
				?>
        </div>
        
        <div id="aside">
        	<div class="title">Playlist</div>
            <div id="box" class="playlist">
            	<ul>
                <a href="#dialog"  id="nowplay" name="modal"><li>Now Playing : <B id='nowplaying'>Nothing</B></li></a>
                 <?php
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM music ORDER BY RAND() limit 0,2");
					while($rr = mysqli_fetch_array($q))
					{
						echo "<a href='#' ><li title='$rr[3]' onclick='playmusic(event)' mname='$rr[2]' info='$rr[3]' music='$rr[4]' mdate='".date("l jS F Y g:i:a",$rr[5])."'>$rr[2]</li></a>";	
					}
					$q = NULL;
					$q = mysqli_query($conc,"SELECT * FROM videos ORDER BY RAND() limit 0,2 ");
					while($rrr = mysqli_fetch_array($q))
					{
						echo "<a href='#dialogvideo' name='modal'><li title='$rrr[3]' onclick='playvideo(event)' prev='$rrr[4]' video='$rrr[5]' info='$rrr[3]' vidname='$rrr[2]' vdate='".date("l jS F Y g:i:a",$rrr[6])."'>$rrr[2]</li></a>";	
					}
				?>
                 </ul>
            
            </div>
        </div>
        
    </div>
    
      <div id="boxes">
        <div id="dialog" class="window">
	      <a href="#"class="close"/></a>   
                       <br/><br/>
           <div id="div_audio_player"></div>
            <div id="footnote"></div>    
        </div>
      </div>
    
    <div id="boxes">
        <div id="dialogvideo" class="window">
        	<a href="#"class="close"/></a>   
            <br/><br/>             
            <div id='video_html_vars'>
            </div>
            <div id="footnotediv"> </div>  
        </div>    
	</div>
     <div id="boxes">
           <div id="dialogpicture" class="window">
        	<a href="#"class="close"/></a>  <br/><br/>                
            <div id='art_html_vars'>
            </div>
            <div id="footnoteart"> </div>
        </div>
	</div>
    
</div>

</body>
</html>
<?php
mysqli_kill($conc,mysqli_thread_id($con->c()));
mysqli_close($con->c());
?>