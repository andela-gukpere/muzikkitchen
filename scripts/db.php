<?php
define("DEF_VID_IMG", "vid.png");
define("DEF_BG_IMG", "/profile_bg/default.jpg");
if (stristr($_SERVER["HTTP_HOST"], "muzikkitchen.com")) define("PTH", "");
else define("PTH", "/projects/4/muzikkitchen");

class db
{
    public $database;
    function __construct() {
    }
    public function c() {
        if (stristr($_SERVER["HTTP_HOST"], "muzikkitchen.com")) {
        	// production database connection
        }
        else {
            $con = mysqli_connect("localhost", "root", "<db_password>", "mk");
        }
        return $con;
    }
    public function query($table, $vars, $where) {
        $nc = $this->c();
        $q = mysqli_query($nc, "SELECT $vars FROM $table WHERE $where");
        return array(
            mysqli_num_rows($q) ,
            $q,
            $nc
        );
    }
    public function update($table, $vars, $where) {
        $nc = $this->c();
        $q = mysqli_query($nc, "UPDATE $table SET $vars WHERE $where");
        $this->close_db_con($nc);
        return $q ? true : false;
    }
    public function close_db_con($nc) {
        mysqli_kill($nc, mysqli_thread_id($nc));
        return mysqli_close($nc);
    }
    public function fromTable($table, $vars, $where) {
        $nc = $this->c();
        $q = mysqli_query($nc, "SELECT $vars FROM `$table` WHERE $where");
        $r = mysqli_fetch_array($q);
        $this->close_db_con($nc);
        return $r;
    }
    public function insertInto($table, $values) {
        if (is_array($values)) {
            $str = "INSERT INTO `$table` VALUES (NULL,";
            foreach ($values as $value) {
                $str.= "'" . $value . "',";
            }
            $str = substr($str, 0, strlen($str) - 1);
            $str.= ")";
            $nc = $this->c();
            $q = mysqli_query($nc, $str);
            $this->close_db_con($nc);
            if ($q) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}

function strclean($input) {
    $input = str_replace("<br>", "", $input);
    return stripslashes(htmlspecialchars($input, ENT_QUOTES));
}

function str_fix($in) {
    $_out = str_replace("'", "&rsquo;", $in);
    $_out = str_replace('"', "&quot;", $_out);
    $_out = str_replace('&', "&amp;", $_out);

    // $_out = str_replace('@',"",$_out);
    // $_out = str_replace('!',"",$_out);
    //$_out = str_replace('~',"",$_out);
    // $_out = str_replace('`',"",$_out);
    // $_out = str_replace('$',"",$_out);
    //	$_out = str_replace('%',"",$_out);
    //	$_out = str_replace('^',"",$_out);
    //	$_out = str_replace('*',"",$_out);
    //	$_out = str_replace('(',"",$_out);
    //	$_out = str_replace(')',"",$_out);
    //	$_out = str_replace('=',"",$_out);
    //	$_out = str_replace('+',"",$_out);
    //	$_out = str_replace('#',"",$_out);

    //	$_out = str_replace('#',"",$_out);
    return trim($_out);
}
$lang_array = array(

    "pt" => "Portuguese - Português",

    "it" => "Italian - Italiano",

    "es" => "Spanish - Español",

    "tr" => "Turkish - Türkçe",

    "en" => "English",

    "ko" => "Korean - 한국어",

    "fr" => "French - français",

    "ru" => "Russian - Русский",

    "de" => "German - Deutsch",

    "ja" => "Japanese - 日本語"
);

function extension($ext) {

    //if(stristr($ext,"video"))
    //{
    if (stristr($ext, "flv")) {
        return ".flv";
    }
    if (stristr($ext, "avi")) {
        return ".mp4";
    }
    if (stristr($ext, "mp4")) {
        return ".mp4";
    }
    if (stristr($ext, "3gp")) {
        return ".3gp";
    }

    //}
    //if(stristr($ext,"audio"))
    //	{
    if (stristr($ext, "mp3")) {
        return ".mp3";
    }
    if (stristr($ext, "m4a")) {
        return ".m4a";
    }
    if (stristr($ext, "wma")) {
        return ".wma";
    }
    if (stristr($ext, "aac")) {
        return ".aac";
    }
    if (stristr($ext, "amr")) {
        return ".amr";
    }
    if (stristr($ext, "wav")) {
        return ".wav";
    }
    else {
        return "." . end(explode(".", $ext));
    }
}

//if u2 is following u1//
function isFollowing($con, $u1, $u2) {
    $q = mysqli_query($con, "SELECT id FROM follow WHERE u1 = $u1 and u2 = $u2");
    if (mysqli_num_rows($q) == 1) {
        return true;
    }
    else {
        return false;
    }
}
function gtime($date) {
    $cTime = date("U") - $date;
    $yy = intval(($cTime / 365 / 24 / 60 / 60));
    $MM = intval(($cTime / 30 / 24 / 60 / 60));
    $ww = intval(($cTime / 7 / 24 / 60 / 60));
    $dd = intval(($cTime / 24 / 60 / 60));
    $hh = intval(($cTime / 60 / 60));
    $mm = intval(($cTime / 60));
    $ss = $cTime;
    $aTime = $yy == 0 ? $MM == 0 ? $ww == 0 ? $dd == 0 ? $hh == 0 ? $mm == 0 ? ($ss == 1 ? " a second ago" : "$ss seconds ago") : ($mm == 1 ? " a minute ago" : " $mm minutes ago") : ($hh == 1 ? " an hour ago" : " $hh hours ago") : ($dd == 1 ? " a day ago" : " $dd days ago") : date("D d M h:ia", $date) : date("h:ia D d M Y", $date) : date("l d F h:ia", $date);
     //l d F h:ia  //D d M Y h:ia
    return $aTime;
}
function me_n_you($con, $u1, $u2) {
    $q = mysqli_query($con, "SELECT id FROM follow WHERE (u1 = $u1 AND u2 = $u2) OR (u1 = $u2 AND u2 = $u1)");

    if (mysqli_num_rows($q) == 2) {
        return true;
    }
    else {
        return false;
    }
}
function xtra_space($str) {
    $output = str_replace(" _", " ", $str);

    //$output = str_replace("    ","   ",$output);
    //$output = str_replace("   "," ",$output);
    $output = str_replace("  ", " ", $output);
    if (stristr($output, "  ")) return xtra_space($output);
    else return $output;
}
function _hstr_($str, $is_mail) {
    $pr = explode(" ", $str);
    $ostr = $str;
    $href = array();
    $mention = array();
    $trend = array();
    $music = array();
    $art = array();
    $video = array();
    foreach ($pr as $a) {
        if (stripos($a, "http://") !== false && !in_array($a, $href)) {
            $str = str_replace($a, "-$a -", $str);
            array_push($href, $a);
        }
        else if (stripos($a, "@") !== false && !in_array($a, $mention)) {
            $str = str_replace($a, "_$a _", $str);
            array_push($mention, $a);
            send_mention_mail($a, $ostr, $is_mail);
        }
        else if (stripos($a, "#") !== false && !in_array($a, $trend)) {
            $str = str_replace($a, "_$a _", $str);
            array_push($trend, $a);
        }

        /*(	else if(stripos($a,"[art:") !== false && !in_array($a,$art))
        {
        $str = str_replace($a,"_$a _",$str);
        array_push($mention,$a);

        }
        else if(stripos($a,"[music:") !== false && !in_array($a,$music))
        {
        $str = str_replace($a,"_$a _",$str);
        array_push($trend,$a);
        }
        */
    }
    $href = null;
    $mention = null;
    $trend = null;
    return strclean($str);
}

function send_mention_mail($user, $str, $type) {
    $con = new db();
    $conc = $con->c();
    $user = str_replace("@", "", $user);
    if ($user != $_SESSION["user"]) {
        switch ($type) {
            case 1:
                s_mail($_SESSION["user"], "mentioned you in his/her feed<br/><div style='font-size:12px;'>$str</div>", $user, $conc, "mentioned you");
                break;

            case 2:
                s_mail($_SESSION["user"], "included you in his/her<br/>relationship status", $user, $conc, " updated his/her status");
                break;

            default:

                //goHard or goHome
                break;
        }
    }
    mysqli_kill($conc, mysqli_thread_id($con->c()));
    mysqli_close($con->c());
}
function user($con, $vars, $user_id) {
    $user_id = trim($user_id);
    $q = mysqli_query($con, "SELECT $vars FROM `users` WHERE `id`='$user_id' OR `user`='$user_id'");
    $r = mysqli_fetch_array($q);
    return $r;
}
function _like($con, $id, $uid) {
    $q = mysqli_query($con, "SELECT `id` FROM `like` WHERE `id` = $id AND `uid` = $uid");
    if (mysqli_num_rows($q) == 1) {
        return true;
    }
    else {
        return false;
    }
}

function fromTable($con, $table, $vars, $where) {
    $user_id = intval($user_id);
    $q = mysqli_query($con, "SELECT $vars FROM `$table` WHERE $where");
    $r = mysqli_fetch_array($q);
    return $r;
}
function valid_name($user) {
    if (preg_match('/\`|\~|\!| |\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\[|\{|\]|\}|\:|\;|\'|\"|\<|\>|\?\|\,|\/|\\\/', $user) || strstr($user, ",") || strlen($user) > 30) {
        return false;
    }
    else {
        return true;
    }
}
function numff($con, $uid, $type) {
    if ($type == 1) {
        $q = mysqli_query($con, "SELECT id FROM follow WHERE u1=$uid");
    }
    else {
        $q = mysqli_query($con, "SELECT id FROM follow WHERE u2=$uid");
    }
    $n = mysqli_num_rows($q);
    return intval($n);
}
function numfeeds($con, $uid) {
    $q = mysqli_query($con, "SELECT id FROM post WHERE user = $uid");
    return mysqli_num_rows($q);
}

function numlikes($con, $id) {
    $q = mysqli_query($con, "SELECT `id` FROM `like` WHERE `id` = '$id'");
    $n = mysqli_num_rows($q);
    return $n > 0 ? $n : "";
}

//$client_apps_array = array("","web","mobile","");
//	$client_apps_array = array("","http://muzikkitchen.com","http://muzikkitchen.com/m/","");
function post($id, $uid, $userid, $user, $name, $img, $date, $post, $var, $rid, $type, $client) {
    $client_apps_array = array(
        "",
        "web",
        "mobile",
        ""
    );
    $client_apps_url = array(
        "",
        "./?force_web=2",
        "./?force_mobile=2",
        ""
    );
    $rp = "";
    $client1 = $client_apps_array[$client];
    $clienturl = $client_apps_url[$client];
    $client = "<a href='$clienturl' class='small' target='_blank'>via $client1</a>";
    if ($type == 1) {
        $con = new db();
        $conc = $con->c();
        $q = mysqli_query($conc, "SELECT `post`.`id`,`users`.`user` FROM `post` INNER JOIN `users` ON (`users`.`id` = `post`.`user`) WHERE `post`.`id` = $rid ");
        $r = mysqli_fetch_array($q);
        $pid = $r[1];
        $rp = "<a href='" . PTH . "/?view=$rid&t=$type' class='del'  onclick='return _op($rid,$type)' title='in reply to $pid'><table><tr><td><div class='preply'></div></td><td>to $pid</td></tr></table></a>";
        $con->close_db_con($conc);
    }
    else if ($type == 2) {
        $con = new db();
        $conc = $con->c();
        $q = mysqli_query($conc, "SELECT `post`.`id`,`users`.`user` FROM `post` INNER JOIN `users` ON (`users`.`id` = `post`.`user`) WHERE `post`.`id` = $rid ");
        $r = mysqli_fetch_array($q);
        $pid = $r[1];
        $con->close_db_con($conc);
        $rp = "<a href='" . PTH . "/?view=$rid&t=$type' class='del' onclick='return _op($rid,$type)' title='refed from $pid'><table><tr><td><div class='prefeed'></div></td><td>from $pid</td></tr></table></a>";
    }
    $bb = ".";
    $imgclass = "smpdiv";
    $post_style = "";
    $url = "./$user";
    if ($_SESSION["mobile"] == 2) {

        //	$bb = "..";
        //				$url = "./?i=$user";
        $imgclass = "ssmpdiv";
    }
    if ($var == "pop") {
        $style = "style='width:400px;'";
        $var = "";
        $imgclass = "ssmpdiv";
        $post_style = "style='font-size:10px;'";
    }
    if ($_SESSION["uid"] != 0) {
        $con = new db();
        $conc = $con->c();
        $del = $uid == $userid ? "<a onclick='return _del(event,\"$id\")'><div title='delete' class='delete'></div></a>" : "";
        $nl = numlikes($conc, $id);
        $like = _like($conc, $id, $uid) ? " style='background-image:url(" . PTH . "/img/like.png);' class='like' title='unlike $nl'" : " title='like $nl' style='background:url(" . PTH . "/img/like_2.png) center no-repeat;' class='like'";
        $con->close_db_con($conc);
        $llike = " <div $like onclick='_like(event,$id,$userid)' class='like' onmouseover='_textgrow(event)' align='center'>" . $nl . "</div>";
        $reply = "<a href='" . PTH . "/?rep=$id&u=$user&t=1' class='del' onclick='return _reply(event)' rid='$id' u='$user'><div class='preply' title='reply $name'></div></a>";
        $repost = "<a href='" . PTH . "/?rep=$id&u=$user&t=2' class='del' onclick='return _repost(event)' rid='$id' u='$user'><div title='refeed' class='prefeed' ></div></a>";
    }
    $style = stripos($post, "@" . $_SESSION["user"]) !== false ? "style='border-left:2px solid #444;'" : "";

    //			$style = $userid == $uid?"style='border-right:1px solid #444;'":$style;
    //			$style = "";
    //_pop(event,$userid)
    return "<div class='post' id='post$id' $style onmouseover='_postOver(event)' >
				<table width='100%'><tr><td width='10%'><a href='$url' onclick='return _pop(event,\"$user\")' ><div class='$imgclass' style='background-image:url(" . PTH . "$img);'></div></a></td>
				<td width='90%'>
				<table width='100%'><tr><td width='100%'><a href='$url' onclick='return _pop(event,\"$userid\")' onmouseover='' >$user</a> <i style='_pn'>$name</i><br/><span class='_post' id='post_span_" . $id . "' $post_style>$post</span><br/></td></tr></table>
				<table style='float:right;'><tr><td valign='middle'><a class='del' style='display:none;' udate='" . date("U", $date) . "' title='" . date("r", $date) . "' href='" . PTH . "/?view=$id&t=0' onclick='return _op($id,0);'>" . gtime($date) . "</a></td><td valign='middle'>$rp</td><td valign='middle'>$client</td><td>$llike</td><td>$reply</td><td>$repost</td><td>$del</td><td valign='middle'>$var</td></tr></table></td></tr></table>
				</div> ";
}
function getVoteScreen($con, $cat, $qq) {

    //$c = $cat == NULL?"":"WHERE cat = $cat";
    //	$cat_array = array('Politics'=>"74cf3e",'Society-Lifestyle'=>"c708e3",'Entertainment'=>"e00909",'Sports-Soccer'=>"f0ad05", 'Youth'=>"d7d00b", 'World'=>"0878e4",'General'=>"5d5c5c");

    $res = "<b>$qq</b><br/><table width='100%'>";
    $cand = array();
    $n = 0;
    $q2 = mysqli_query($con, "SELECT `votes`,`uid` FROM cand WHERE cat = $cat");
    $i = 0;
    $total = 0;
    while ($r2 = mysqli_fetch_array($q2)) {
        $i++;
        $total = $r2[0] + $total;
        array_push($cand, array(
            $r2[0],
            $r2[1]
        ));
    }
    $q = mysqli_query($con, "SELECT `cand`.`uid`,`users`.`user`,`users`.`name` FROM cand INNER JOIN users on `users`.`id` = `cand`.`uid` WHERE `cand`.`cat` = $cat");
    while ($r = mysqli_fetch_array($q)) {
        $vote = 0;
        foreach ($cand as $a) {
            if (in_array($r[0], $a)) {
                $vote = $a[0];
            }
        }
        $no = mysqli_num_rows($q);
        $p = 0;
        $p = $total != 0 ? (($vote / $total) * 200) : 0;
        $text = round($p / 2);
        $res.= "<tr><td width='40%' height='20'><a href='./$r[0]' onclick='return _o(event,$r[0])' title='$r[2]' class='v_t_r'>$r[1]</a></td><td><div class='v_p' style='width:200px;background-color:#D7D7D7'><div class='v_p' style='width:" . $p . "px;background-color:#336699;'>$text%</div></div></td></tr>";
    }
    $res.= "</table><br/><i style='font-size:9px;'>Total votes: $total</i>";
    if ($i == 0) {
        $res = "<div align='center' style='font-size:30px;'>No Content</div>";
    }
    return $res;
}
function s_mail($v1, $v2, $v3, $con, $v4) {
    if ($v3) {
        $to = user($con, "`email`", $v3);
        $img = $_SESSION["img2"];
        $to = $to[0];
        $subject = "Muzik Kitchen | " . $v1 . ' ' . $v4;
        $message = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>muzik kitchen</title>
<style>
#containers{
	width:800px;
	height:400px;

	background:#fff url(http://muzikkitchen.com/img/container_home.jpg) right no-repeat;
	padding:10px;

font-size:25px;
font-family:Verdana, Geneva, sans-serif;
	border-radius:10px;
	box-shadow:inset 0 0 30px rgba(0,0,0,0.1), 0 0 20px rgba(0,0,0,0.2);
}
img
{
	border:0px;
}
a
{
	text-decoration:none;

}
a:hover
{
	text-decoration:overline;
}
</style>
</head>

<body>
<div id="containers">
<div style="width:80%"><table><tr><td valign="top"><img style="border-radius:10px;" src="http://muzikkitchen.com' . $img . '"/></td><td valign="top"><a href="http://muzikkitchen.com/' . $v1 . '"><b>' . $v1 . '</b></a><br/>' . $v2 . '</td></tr></table></div>
<div style="margin:10%;border-radius:10px;position:relative;bottom:5%;">
<br/>
<A href="http://muzikkitchen.com"><img src="http://muzikkitchen.com/img/logo_home.png" style="margin-left:60%"/></A></div>
    </div>
    <A href="http://muzikkitchen.com"><B style="font-size:10px;">Muzikkitchen.com</B></A>
</body>
</html>

				';
        $headers = 'From:Muzik Kitchen <chef@muzikkitchen.com>' . "\r\n" . 'Reply-To: info@muzikkitchen.com' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        return @mail($to, $subject, $message, $headers);

        //echo "$to <br/> $header <Br/> $subject <br/> $message <hr/>";

    }
}
$status_array = array(
    "",
    "Single",
    "Complicated",
    "Married",
    "In Relationship with:"
);
$color_array = array(
    "#afafaf",
    "#0099ff",
    "#fa4d6c",
    "#ffd700",
    "#777777",
    "#b591f1",
    "#f0bd20",
    "#76fe70",
    "#70fef2",
    "#b9fb52",
    "#fa982e",
    "#f89453",
    "#a95432",
    "#336699",
    "#663399",
    "#996633",
    "#447738",
    "#323842",
    "#463467",
    "#f483ff",
    "#11d100",
    "#99d900",
    "#8796dc",
    "#af0202",
    "#322323",
    "#545454",
    "#001188",
    "#008855",
    "#775588",
    "#6699ff"
);
$sex_array = array(
    "",
    "Male",
    "Female"
);
function mediaplaycount($type, $mediaID) {
    $con = new db();
    $r = $con->query("num_plays", "id", "type=$type and mediaID=$mediaID");
    $num = $r[0];
    $con->close_db_con($r[2]);
    $r = $con->query("num_plays", "id", "type=$type and mediaID=$mediaID and uid = " . $_SESSION["uid"]);
    $numb = $r[0];
    $con->close_db_con($r[2]);
    return "<div class='playcount'><i>played</i> <b>$num</b><i>time(s)</i> <i id='byme'><b>$numb</b> by you</i></div>";
}
?>