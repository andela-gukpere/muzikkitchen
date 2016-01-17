<?php
include("../scripts/db.php");

$user = $_POST["user"];
$pass = $_POST["p"];
$_s = $_POST["_s"];
if(isset($pass) && !$wall)//lgg($user,$pass))
{
    $fed = new notifications();
	if(isset($_s))
	{	$con = new db();$conc = $con->c();;
		$new_not  = new_not_num($conc,$user,$_s);
		if($new_not != 200000)
		{			
			print($new_not."____");
			print ($fed->createFeed($conc,$user,5));
			mysqli_kill($conc,mysqli_thread_id($con->c()));
			mysqli_close($con->c());
		}
		else
		{
			mysqli_kill($conc,mysqli_thread_id($con->c()));
			mysqli_close($con->c());
			echo "none";
			exit();
		}
	}
	else
	{
		$con = new db();$conc = $con->c();;
		print $fed->createFeed($conc,$user,30);
		$con->close_db_con($conc);
	}
}
class notifications
{
    public function __construct() 
    {

    }
    
    public function createFeed($con,$user,$num)
    {
  
       	$p_r = _pals($user,$con);
/*
email==0 femail==1 href1==2 href2==3 time==4 img_1==5 img_2==6 img_3==7  fname==8 lname==9 sex==10 type = 11
*/
		$num = $num?$num:20;
		$n = 0;
		$months = array("Null","January","Febuary","March","April","May","June","July","August","September","October","November","December");
        $feed="<table>";
       $res = mysqli_query($con,"SELECT `mhistory`.`email`,`mhistory`.`femail`,`mhistory`.`href1`,`mhistory`.`href2`,`mhistory`.`time`,`mhistory`.`img_1`,`mhistory`.`img_2`,`mhistory`.`img_3`,`users`.`fname`,`users`.`lname`,`users`.`sex`,`mhistory`.`type` FROM `mhistory` inner join `users` on (`users`.`em` = `mhistory`.`email`) ORDER BY `mhistory`.`time` DESC");
        while(($rarray = mysqli_fetch_array($res)))
        {
			$em1 = $rarray[0];
			$em2 = $rarray[1];
			if(in_array($em1,$p_r) || in_array($em2,$p_r) || $em1 == $user || $em2 == $user){}else{continue;}
			$n++;
			if($n == $num + 1){break;}
            $time = new vartime($rarray[4]);
			
			$pid = $rarray[2];
            $tt = $time->ttime();
			$uu = array($rarray[8],$rarray[9],$rarray[10]);
			if(strlen($em2) > 1)
			{
				$uy = users($con,"`fname`,`lname`,`sex`",$em2);
			}
            if($em1 == $em2)
            {
       			$owner = ($uu[2] == "Male")?"his":"her";    
				$ss = "";
            }
            else
            {
                $owner = "$uy[0] $uy[1]";
                $ss = "'s";
            }
			
            $pwn = ($uu[2] == "Male")?"himself":"herself";
            $email = "$uu[0] $uu[1]";
            if ($rarray[11]== 1)
                {
                    $feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em1#divprof' onclick = 'return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>$email</a> added a comment on <a onmouseover = '_pop(event,\"$em2\")' href='../home/?ref=$em2#divprof' onclick = 'return _go(event,\"../prof/\",\"$em2\")'>".$owner."$ss</a> <a href='../home/?ref=$em2&ccc=$pid#divwall' onclick='return get_only_d($pid,\"$em2\")'>post</a> <span class='tt'>".$tt."</span></td></tr>";
                }
             else if ($rarray[11]== 2)
                {
                   
                    $feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em1#divprof' onclick = 'return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>$email</a> created a post on <a href='../home/?ref=$em2#divprof' onclick = 'return _go(event,\"../prof/\",\"$em2\")' onmouseover = '_pop(event,\"$em2\")'>".$owner."$ss</a> <a href='../home/?ref=$em2&ccc=$pid#divwall' onclick = 'return get_only_d($pid,\"$em2\")'>wall</a>  <span class='tt'>".$tt."</span></td></tr>";
                }
                else if ($rarray[11]== 3)
                {
                    $feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em1#divprof' onclick = 'return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>$email</a> and <a href='../home/?ref=$em2#divprof' onclick='return _go(event,\"../prof/\",\"$em2\")' onmouseover = '_pop(event,\"$em2\")'>".$owner."</a> became friends <span class='tt'>".$tt."</span></td></tr>";
                }
                else if ($rarray[11]== 4)
                {
                    $img1 = ($rarray[5]!= "")?"<img src='".$rarray[5]."' />":"";
                    $img2 = ($rarray[6]!= "")?"<img src='".$rarray[6]."' />":"";
                    $img3 = ($rarray[7]!= "")?"<img src='".$rarray[7]."' />":"";
                    list($r1,$r2,$r3) = explode("_",$rarray[2]);
                    $feed .= "<tr><td></td><td valign='center'><a onmouseover='_pop(event,\"$em1\")' href='../home/?ref=$em1#divprof' onclick ='return _gp(\"../prof/\",\"$em1\")'>$email</a> Uploaded new photos <span class='tt'>".$tt."</span><br/><table><tr><td><a href='../home/?ref=$em1&pid=$r1#divalb' onclick='return get_only_p(event,\"$r1\");'>$img1</a></td><td><a onclick='return get_only_p(event,\"$r2\");' href='../home/?ref=$em1&pid=$r2#divalb'>$img2</a></td><td><a href='../home/?ref=$em1&pid=$r3#divalb' onclick='return get_only_p(event,\"$r3\");'>$img3</a></td></tr></table></td></tr>";
                }
                else if($rarray[11]== 5)
                {
                     $feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em2#divprof' onclick='return _go(event,\"../prof/\",\"$em2\")' onmouseover = '_pop(event,\"$em2\")'>$owner</a> received a request from <a href='../home/?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>$email</a> <span class='tt'>".$tt."</span></td></tr>";
                }
               else if ($rarray[11]== 6)
                {
					list($did,$ty) = explode("__",$pid);
					if($ty == 0)
					{
						$addy = "<a href='../home/?ref=$em2&aid=$did#divalb' onclick='return get_only_p(event,$did);'>";
					}else{ $addy = "<a href='../home/?ref=$em2&pid=$did#divalb' onclick='return get_only_p(event,$did);'>";}
                    $feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>".$email."</a> added a comment on <a href='../home/?ref=$em2#divprof' onclick='return _go(event,\"../prof/\",\"$em2\")' onmouseover = '_pop(event,\"$em2\")'>".$owner."$ss</a> photo $addy album</a> <span class='tt'>".$tt."</span></td></tr>";
                }
                else if ($rarray[11]== 7)
                {
                    $id = $rarray[6];
                    $tag = $rarray[5];
					$u = users($con,"`fname`,`lname`",$tag);
                    $ttt = $tag==$em1?$pwn:"$u[0] $u[1]";
                    $getpic = mysqli_query($con,"SELECT `img_m` FROM `pics` WHERE `id` = $id;");
                    $pr = mysqli_fetch_array($getpic);
                    $feed .= "<tr><td valign='top'><img src='../img/mg/not.png'/></td><td valign='center'><a href='../home/?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")'>$email</a> tagged <a href='../home/?ref=$tag#divprof' onclick='return _go(event,\"../prof/\",\"$tag\")' onmouseover = '_pop(event,\"$tag\")'>$ttt</a> in <a href='../home/?ref=$em2#divprof' onclick='return _go(event,\"../prof/\",\"$em2\")' onmouseover = '_pop(event,\"$em2\")'>".$owner."$ss</a> photo <a href='../home/?ref=$em2&pid=$id#divalb' onclick='return get_only_p(event,$id);'>album</a> <span class='tt'>".$tt."</span><br/><a href='../home/?ref=$em2&pid=$id#divalb' onclick='return get_only_p(event,$id);'><img src='".$pr[0]."'/></a></td></tr>";
                }
				else if ($rarray[11]== 8)
				{
					$day = $rarray[5];
					$mon = $rarray[6];
					$mont = $months[$mon];
					$daydiff = ($day > date("d"))?(time() + (($day - date("d")) * 24 * 60 * 60)):(date("U") - ((date("d") - $day) * 24 * 60 * 60));
					$exDay = date("D",$daydiff);
					$tense = date("d") > $day?"was":"is";
					$msgg = ($day == abs(date("d")))?"is today":(($day - date("d")== 1)?"is tomorrow":((date("d") - $day == 1)?"was yesterday":"$tense on $exDay $day $mont"));
					$feed .= "<tr><td><img src='../img/mg/not.png'/></td><td valign='top'><a href='../home/?ref=$em1#divwall' onclick='return _go(event,\"../prof/\",\"$em1\")' onmouseover = '_pop(event,\"$em1\")' title='Click and write on wall'>$email</a>$ss birthday $msgg announced<span class='tt'>".$tt."</span></td></tr>";
				}
				else if($rarray[11] == 9)
				{
					$img = _gp($con,"`img_1`,`gp`",$em2);
					$feed .= "<tr><td valign='top'><img src='../img/mg/not.png'/></td><td><a href='./?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\");' onmouseover='_pop(event,\"$em1\");' >$uu[0] $uu[1]</a> joined group <a href='../home/?gpid=$em2#gpcent' onclick=' _go(event,\"../gp/\",\"$user\");return _gpwall(\"$em2\")' >$img[1]</a><br/><span class='tt'>$tt</a><br/><img src='$img[0]' /></td></tr>";	
					
				}
				
				else if($rarray[11] == 10)
				{
					$img = _gp($con,"`img_1`,`gp`",$em2);
					$feed .= "<tr><td valign='top'><img src='../img/mg/not.png' /></td><td><a href='../home/?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\");' >$uu[0] $uu[1]</a> is now a group Admin <a href='../home/?gpid=$em2#gpcent' onclick=' _go(event,\"../gp/\",\"$user\");return _gpwall(\"$em2\")' >$img[1]</a><br/><span class='tt'>$tt</a><br/><img src='$img[0]' /></td></tr>";						
				}
				else if($rarray[11] == 11)
				{
					$img = _gp($con,"`img_1`,`gp`",$em2);
					$feed .= "<tr><td valign='top'><img src='../img/mg/not.png' /></td><td><a href='../home/?ref=$em1#divprof' onclick='return _go(event,\"../prof/\",\"$em1\");' >$uu[0] $uu[1]</a> created <a href='../home/?gpid=$em2#gpcent' onclick=' _go(event,\"../gp/\",\"$user\");return _gpwall(\"$em2\")' >$img[1]</a> group<br/><span class='tt'>$tt</a><br/><img src='$img[0]' /></td></tr>";						
				}
        }
        $feed .= "</table>";
        return $feed;    
    }
}

?>