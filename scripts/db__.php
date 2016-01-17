<?php
class db
{
    function __construct() {
    }
    public function c() {
        $con = mysqli_connect("localhost", "root", "<db_password>", "mk");
        return $con;
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
            mysqli_kill($nc, mysqli_thread_id($nc));
            mysqli_close($nc);
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
    return stripslashes(htmlentities($input, ENT_QUOTES));
}
function str_fix($in) {
    $_out = str_replace("'", "&rsquo;", $in);
    $_out = str_replace('"', "&quot;", $_out);
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

    //}

}

//if u2 is following u1//
function isFollowing($con, $u1, $u2) {
    $q = mysqli_query($con, "SELECT id FROM follow WHERE u1 = $u1 anD u2 = $u2");
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
    $aTime = $yy == 0 ? $MM == 0 ? $ww == 0 ? $dd == 0 ? $hh == 0 ? $mm == 0 ? ($ss == 1 ? " a second ago" : "$ss seconds ago") : ($mm == 1 ? " a minute ago" : " $mm minutes ago") : ($hh == 1 ? " an hour ago" : " $hh hours ago") : ($dd == 1 ? " a day ago" : " $dd days ago") : date("D d M h:ia", $date) : date("h:ia D d M Y", $date) : date("D d M h:ia Y", $date);
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
function _hstr_($str) {
    $pr = explode(" ", $str);
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
    return $str;
}

function user($con, $vars, $user_id) {
    $user_id = intval($user_id);
    $q = mysqli_query($con, "SELECT $vars FROM `users` WHERE id=$user_id");
    $r = mysqli_fetch_array($q);
    return $r;
}

function fromTable($con, $table, $vars, $where) {
    $user_id = intval($user_id);
    $q = mysqli_query($con, "SELECT $vars FROM `$table` WHERE $where");
    $r = mysqli_fetch_array($q);
    return $r;
}
function post($id, $uid, $userid, $user, $name, $img, $date, $post, $var, $rid, $type, $client) {
    $rp = "";
    if ($type == 1) {
        $con = new db();
        $conc = $con->c();
        $q = mysqli_query($conc, "SELECT `post`.`id`,`users`.`user` FROM `post` INNER JOIN `users` ON (`users`.`id` = `post`.`user`) WHERE `post`.`id` = $rid ");
        $r = mysqli_fetch_array($q);
        $pid = $r[1];
        $rp = "<a href='#' class='del'  onclick='return _op($rid,$type)' >in reply to $pid</a>";
        $con->close_db_con($conc);
    }
    else if ($type == 2) {
        $con = new db();
        $conc = $con->c();
        $q = mysqli_query($conc, "SELECT `post`.`id`,`users`.`user` FROM `post` INNER JOIN `users` ON (`users`.`id` = `post`.`user`) WHERE `post`.`id` = $rid ");
        $r = mysqli_fetch_array($q);
        $pid = $r[1];
        $con->close_db_con($conc);
        $rp = "<a href='#pwindow' class='del' name='modal' onclick='return _op($rid,$type)' >rePosted From $pid </a>";
    }
    $del = $uid == $userid ? "&middot;<a href='#' onclick='return _del(event,\"$id\")'><span class='del'>delete</span></a>" : "";
    if ($_SESSION["uid"] != 0) {
        $reply = "&middot;<a href='#' class='del' onclick='return _reply(event)' rid='$id' u='$user'> reply</a>";
        $repost = "&middot;<a href='#' class='del' onclick='return _repost(event)' rid='$id' u='$user'> repost</a>";
    }
    return "<div class='post' id='post$id'>
					<table><tr><td><a href='../home?i=$userid' onclick='return _o(event,$userid)' ><div class='smpdiv' style='background:url($img) center no-repeat'></div></a></td>
					<td>
					<table><tr><td><a href='../home?i=$userid' onclick='return _o(event,$userid)' onmouseover='_pop(event,$userid);' >$user</a> <i style='_pn'>$name</i><br/><span class='_post'>$post</span><br/>$rp <a href='#' target='_blank' class='del'>via $client</a> <a class='del' href='#?post=$id' onclick='return _op($id,0);'>" . gtime($date) . "</a><Br/>$del $reply $repost</td></tr></table>
					</td></tr></table>
					  </div> $var";
}
function getVoteScreen($con, $cat, $qq) {

    //$c = $cat == NULL?"":"WHERE cat = $cat";
    $cat_array = array(
        'Politics' => "74cf3e",
        'Society-Lifestyle' => "c708e3",
        'Entertainment' => "e00909",
        'Sports-Soccer' => "f0ad05",
        'Youth' => "d7d00b",
        'World' => "0878e4",
        'General' => "5d5c5c"
    );

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
        $res.= "<tr><td width='40%' height='20'><a href='./?i=$r[0]' onclick='return _o(event,$r[0])' onmouseover='_pop(event,$r[0]);' title='$r[2]' class='v_t_r'>$r[1]</a></td><td><div class='v_p' style='width:200px;background-color:#D7D7D7'><div class='v_p' style='width:" . $p . "px;background-color:#336699;'>$text%</div></div></td></tr>";
    }
    $res.= "</table><br/><i style='font-size:9px;'>Total votes: $total</i>";
    if ($i == 0) {
        $res = "<div align='center' style='font-size:30px;'>No Content</div>";
    }
    return $res;
}
?>