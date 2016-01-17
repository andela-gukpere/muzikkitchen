<?php
session_start();

include "../scripts/db.php";
$email = $_POST["email"];
if(isset($email))
{
	$con  = new db();
	$q = $con->query("users","id,user","email = '$email'");
	if($q[0] == 1)
	{
		$r = mysqli_fetch_array($q[1]);
		$p = sha1(date("U").rand(505,909));
		$pass = substr($p,0,8);
		$sha_pass = sha1($pass);
		$emailbody = "Your new password is <b>$pass</b>.<br/><br/><i style='font-size:12px;color:#999;'>The password contains just numbers and lowercase alphabets.<br/><br/>Discard previous password reset requests if any, only the latest password reset email will be valid.<br/><br/><br/>Thank you.</i>";
			s_mail($r[1],$emailbody,$r[0],$q[2],"Password Reset '$pass'");
			$up = $con->update("users","pass = '$sha_pass'","id = $r[0]");
			if($up)
			{
				echo "Your new password has been sent to <a href='mailto:$email'>$email</a>.<br/><br/>If you have trouble receiving our mail, please <a href='#'onclick='reset_password(event)' >try again</a>.<br/><br/>Continue to <a href='".PTH."'>login</a>";
			}
			else
			{
				echo "Error resetting password, please <a href='#'onclick='reset_password(event)' >try again</a>.";	
			}		
	}
	else
	{
		echo "The email address entered is not paired with any account.<br/><Br/>Do you want to <a href='".PTH."/?reg_email=$email'>register?</a> using $email";	
	}
	$con->close_db_con($q[2]);
}
?>