<?php

session_start();

require_once '../arg.php';

$last_modified = date("D, d M Y H:i:s \G\M\T", filemtime("jquery/js/jquery.1.7.1.js"));
$expiration = date("D, d M Y H:i:s \G\M\T", strtotime('+1 year'));

header("Cache-Control: public, no-transform");
header("Expires: $expiration");
header("Last-Modified: $last_modified");





error_reporting(-1);


$img_req = '';



//COMM_15_DAY_NOTIFY_1



$zlib = false;


//header("Content-type: text/javascript");

if (!isset($_GET['id']) || !isset($_GET['xhash'])) {
    exit;
}




if(!isset($_SESSION[$uid.'xhash']) || ($_SESSION[$uid.'xhash']!=$_GET['xhash'])){
  $_SESSION[$uid . 'is_cached'] = false;
}

$_SESSION[$uid.'xhash']=$_GET['xhash'];

//-----------------------------------------------------------------------------
class FCC extends FreiChat {

    public $banned = false;

    public function __construct() {
        parent::__construct();
        $this->init_vars();
    }


    public function FCC_init() {
        require_once '../server/drivers/' . $this->driver . '.php';
        $this->freichat_debug("main.php  loaded");


        if (!isset($_SESSION[$this->uid . 'rtl'])) {
            $_SESSION[$this->uid . 'rtl'] = false;
        }

        if (!isset($_SESSION[$this->uid . 'freistatus'])) {
            $_SESSION[$this->uid . 'freistatus'] = 1;
        }

        if (!isset($_SESSION[$this->uid . 'custom_mesg'])) {
            $_SESSION[$this->uid . 'custom_mesg'] = $this->frei_trans['default_status'];
        }

        if (!isset($_SESSION[$this->uid . 'in_room'])) {
            $_SESSION[$this->uid . 'in_room'] = -1;
        }

        if (isset($_SESSION[$this->uid . 'ses_id']) == false) {

            $parameters = array(
                "id" => strip_tags($_GET['id']),
                "custom_mesg" => false,
                "first" => false
            );

            if (!isset($_SESSION[$this->uid . 'in_room'])) {
                $_SESSION[$this->uid . 'in_room'] = -1;
            }
            
            $sessions = new $this->driver($this->db);
            $sessions->uid = $this->uid;
            $sessions->permanent_name = $this->permanent_name;
            $sessions->permanent_id = $this->permanent_id;
            $sessions->online_time = $this->online_time;
            $sessions->online_time2 = $this->online_time2;
            $sessions->time_string = $this->time_string;
            $sessions->show_name = $this->show_name;
            $sessions->usr_list_wanted = false;
            $sessions->db_prefix = $this->db_prefix;
            $sessions->displayname = $this->displayname;
            $sessions->frei_trans = $this->frei_trans;
            $sessions->debug = $this->debug;
            $sessions->update_usr_info = true;
            $sessions->url = $this->url;
            $sessions->driver = $this->driver;
            $sessions->to_freichat_path = $this->to_freichat_path;
            $sessions->options = $parameters;
            $sessions->row_username = $this->row_username;
            $sessions->row_userid = $this->row_userid;
            $sessions->usertable = $this->usertable;

            $sessions->load_driver();
        }
    }

}

$cvs = new FCC;
$cvs->FCC_init();

$cvs->get_js_config();
$smileys = str_replace("'","\'",json_encode($cvs->get_smileys()));


if ($cvs->GZIP_handler == 'ON') {
    if (extension_loaded('zlib')) {
        $zlib = true;
        ob_start('ob_gzhandler');
    }
}



$_SESSION[$uid . 'is_cached'] = true;

if($cvs->banned == true)exit;

//var_dump($construct);

if (isset($_SESSION)) {
    $username = $_SESSION[$cvs->uid . 'usr_name'];
    $id = $_SESSION[$cvs->uid . 'usr_ses_id'];
} else {
    $cvs->freichat_debug("Session Not Yet Created in client side");
}
$frei_trans[] = Array();


require '../client/jquery/freichat_themes/defarg.php';
require '../client/jquery/freichat_themes/' . $cvs->freichat_theme . '/argument.php';
$frei_trans = $cvs->frei_trans;

$url = str_replace('client/main.php', '', $cvs->url);


if (isset($_SERVER['HTTP_REFERER'])) {
    $referer_url = $_SERVER['HTTP_REFERER'];
} else {
    $referer_url = $url;
}


if (strpos($referer_url, 'www.') == TRUE) {
    $url = str_replace('http://', 'http://www.', $url);
    $url = str_replace('https://', 'https://www.', $url);
} else {

    $url = str_replace('http://www.', 'http://', $url);
    $url = str_replace('https://www.', 'https://', $url);
}

if (strpos($url, 'www.www.') == TRUE) {
    $url = str_replace('http://www.www.', 'http://www.', $url);
    $url = str_replace('https://www.www.', 'https://www.', $url);
}

$pfromname = str_replace("'", "\'", $_SESSION[$uid . "usr_name"]);

$custom_mesg = "";


if (isset($_SESSION[$uid . "custom_mesg"])) {
    if ($_SESSION[$uid . "custom_mesg"] != "" && $_SESSION[$uid . "custom_mesg"] != "i am null" && $_SESSION[$uid . "custom_mesg"] != null) {
        $custom_mesg = $_SESSION[$uid . "custom_mesg"];
    }
} else {
    $custom_mesg = 'I am available';
}

$ACL = $cvs->get_acl();
if (($_SESSION[$uid . 'is_guest'] == 0 && $ACL['CHATROOM']['user'] == 'noallow') || ($_SESSION[$uid . 'is_guest'] == 1 && $ACL['CHATROOM']['guest'] == 'noallow')) { //is a user
    $show_chatroom_plugin = 'disabled';
}else{
    $show_chatroom_plugin = 'enabled';
}



 
require_once 'jquery/js/jquery.1.7.1.js';
require_once 'jquery/js/jquery-ui.js';
require_once 'plugins/translate/js/jquery.translate-1.3.9.min.js';
require_once 'jquery/js/combined.js'; //include SM 2_.2.97a + slick + dragx
$_SESSION[$cvs->uid . 'FreiChatX_init'] = true;
require_once 'jsdef.js';
require_once 'plugins.js';
 if ($cvs->show_videochat_plugin == 'enabled') {
  require_once 'plugins/videochat/videochat.js';
  require_once 'plugins/videochat/video_api.js';
}


require_once 'freichat.js';






if ($cvs->GZIP_handler == 'ON') {
    if ($zlib == true) {
        ob_end_flush();
    }
}
$_SESSION[$cvs->uid . 'main_loaded'] = true;
