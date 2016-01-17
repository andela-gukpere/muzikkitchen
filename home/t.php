<?php
include("../scripts/db.php");
$post = "RP: @fisicallyFeet RP: @omish RP: @papaste @fisicallyFeet @omish @easymind @DonZion";
$post = strclean(_hstr_($post,false));
$post = str_replace("__@","_@",$post);
$post = str_replace(" _ _ "," _ ",$post);
//echo $post;

$m = " @papaste @fisicallyFeet @omish [music:5] @papaste @fisicallyFeet @omish";
$con = new db();$conc = $con->c();
$conc = $con->c();
$q = mysqli_query($conc,"SELECT id,img1,img2,img3 FROM users");
echo "no. of users ".mysqli_num_rows($q);
if(isset($_GET["no"]))
{
	$con->close_db_con($conc);
	exit();	
}
while($r = mysqli_fetch_array($q))
{
	
	$img1 = str_replace("..","",$r[1]);
		$img2 = str_replace("..","",$r[2]);
			$img3 = str_replace("..","",$r[3]);
			
			
	$img1 = str_replace("d70.jpg","d70.png",$img1);
		$img2 = str_replace("d150.jpg","d150.png",$img2);
			$img3 = str_replace("d500.jpg","d500.png",$img3);
	$qq = mysqli_query($conc,"UPDATE users SET img1='$img1',img2='$img2',img3='$img3' WHERE id = $r[0]");	
	echo $img1."<br/>";
}


$q = mysqli_query($conc,"SELECT id,img1,img2,img3 FROM art");
while($r = mysqli_fetch_array($q))
{
	
	$img1 = str_replace("..","",$r[1]);
		$img2 = str_replace("..","",$r[2]);
			$img3 = str_replace("..","",$r[3]);
	$qq = mysqli_query($conc,"UPDATE art SET img1='$img1',img2='$img2',img3='$img3' WHERE id = $r[0]");	
	echo $img1."<br/>";
}
$con->close_db_con($conc);
?>