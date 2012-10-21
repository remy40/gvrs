<?php

date_default_timezone_set('America/Los_Angeles');


/* < Hard code */
require_once 'hardcode.php';
/* Hard code /> */



require_once 'define.php';

class FreiChat {

    public function __construct() {


        global $con, $host, $client_db_name, $username, $password, $driver, $db_prefix, $uid, $debug, $PATH;
        $this->con = $con;
        $this->username = $username;
        $this->password = $password;
        $this->client_db_name = $client_db_name;
        $this->host = $host;
        $this->driver = $driver;
        $this->db_prefix = $db_prefix;
        $this->uid = $uid;
        $this->PATH = $PATH;

        global $usertable, $row_username, $row_userid, $avatar_field_name;
        $this->usertable = $usertable;
        $this->row_username = $row_username;
        $this->row_userid = $row_userid;
        $this->avatar_field_name = $avatar_field_name;



        $this->db = DB_conn::get_connection($host, $client_db_name, $username, $password, $debug);
        //$this->init_vars();
    }

    public function build_vars() {
        $query = "SELECT * FROM frei_config";
        $variables = $this->db->query($query);
        $variables = $variables->fetchAll();
        $args = array();

        foreach ($variables as $variable) {

            if ($variable['subcat'] != 'NULL') {
                //    var_dump($variable);
                $args[$variable['key']][$variable['cat']][$variable['subcat']] = $variable['val'];
            } else if ($variable['cat'] != 'NULL') {
                $args[$variable['key']][$variable['cat']] = $variable['val'];
            } else {
                $args[$variable['key']] = $variable['val'];
            }
        }

        $this->db_vars = $args;
        return $args;
    }

    public function build_paths() {
        if (!defined('RDIR')) {
            define('RDIR', dirname(__FILE__));
            define('PARENTDIR', dirname(RDIR));
        }

        if (@$_SERVER["HTTPS"] == "on") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    }

    public function return_boolean($variable) {
        if ($variable == "true")
            return true;
        return false;
    }

    public function init_vars() {

        $parameters = $this->build_vars();

        $this->url = $this->build_paths();
        $this->show_name = $parameters['show_name']; //you can have guest or user
        $this->displayname = $parameters['displayname']; //you can have username / name(nickname)
        $this->debug = $this->return_boolean($parameters['debug']); //option for debugging ,default is false
        $this->freichat_theme = $parameters['freichat_theme'];
        $this->css = $this->freichat_theme; //background color
        $this->color = $this->css; //colour for chatbuttons
        $this->lang = $parameters['lang']; //Language please do not include .php here only file name
        $this->cache = 'disabled';

        $this->show_chatroom_plugin = 'enabled';
        $this->show_videochat_plugin = 'disabled';



        //long polling
        $this->long_polling = $parameters['polling'];
        $this->poll_time = $parameters['polling_time'];
        $this->chatspeed = $parameters['chatspeed'];

        //link profile
        $this->linkprofile = $parameters['link_profile'];
        //CUSTOM DRIVER
        $this->to_freichat_path = $this->PATH;


        $this->show_avatar = $parameters['show_avatar']; //Can have block or none
        $this->frei_trans = $this->inc_lang();
        $this->time_string = strtotime(date("Y-m-d H:i:s"));

        $this->online_time = ($this->time_string - 10);
        $this->online_time2 = ($this->time_string - 80);
        $this->permanent_id = time() + rand(100000, 500000);
        $this->permanent_name = $this->frei_trans['g_prefix'] . base_convert($this->permanent_id, 6, 36);

        /* if (isset($_SESSION)) {
          $this->frm_id = $_SESSION[$this->uid . 'usr_ses_id'];
          $this->frm_name = $_SESSION[$this->uid . 'usr_name'];
          } */
    }

    public function get_js_config() {

        $parameters = $this->db_vars;

        $this->fxval = $parameters['fxval']; //Set it to false if you do not want animations
        $this->draggable = $parameters['draggable'];
        $this->conflict = $parameters['conflict']; //Jquery Conflicts 'true' or ''
        $this->msgSendSpeed = $parameters['msgSendSpeed']; //Message are sent after 1 second of post, reducing it will increase FreiChat message sending speed but also will send more requests to the server! NOTE:: Do not decrease it below 1000


        $this->load = $parameters['load']; //chatbox
        $this->dyncss = 'disable'; //template patch
        $this->evnixpower = 'visible'; //powered by evnix
        $this->show_chatbox = '';
        $this->time = $parameters['time']; //In seconds
        $this->GZIP_handler = $parameters['GZIP_handler'];

        $this->JSdebug = $this->return_boolean($parameters['JSdebug']); // Javascript debug info shown in firebug (firefox extension). No quotes around true or false
        $this->busy_timeOut = $parameters['busy_timeOut']; //In seconds user will be switched to busy status
        $this->offline_timeOut = $parameters['offline_timeOut']; //In seconds user will be switched to offline status

        /* FreiChat plugins */

        // File sending
        $this->show_file_sending_plugin = $parameters['plugins']['file_sender']['show'];
        $this->file_size_limit = ($parameters['plugins']['file_sender']['file_size']) * 1024; //In Kilobytes
        $this->expirytime = $parameters['plugins']['file_sender']['expiry']; //In minutes after which the uploaded files will be deleted
        $this->valid_exts = $parameters['plugins']['file_sender']['valid_exts']; //valid extensions separated by comma
        $this->playsound = $parameters["playsound"];
        //coversation save
        $this->show_save_plugin = 'enabled';

        //smiley plugin
        $this->show_smiley_plugin = 'enabled';

        //send conversation plugin
        $this->show_mail_plugin = 'enabled';

        $this->mailtype = $parameters["plugins"]["send_conv"]["mailtype"];
        $this->smtp_server = $parameters["plugins"]["send_conv"]["smtp_server"];
        $this->smtp_port = $parameters["plugins"]["send_conv"]["smtp_port"];
        $this->smtp_protocol = $parameters["plugins"]["send_conv"]["smtp_protocol"];
        $this->mail_from_address = $parameters["plugins"]["send_conv"]["from_address"];
        $this->mail_from_name = $parameters["plugins"]["send_conv"]["from_name"];
    }

    public function get_acl() {

        $parameters = $this->db_vars;
        $ACL = array(
            'FILE' => array(
                'user' => $parameters['ACL']['filesend']['user'],
                'guest' => $parameters['ACL']['filesend']['guest']
            ),
            'TRANSLATE' => array(
                'user' => 'noallow',
                'guest' => 'noallow'
            ),
            'SAVE' => array(
                'user' => $parameters['ACL']['save']['user'],
                'guest' => $parameters['ACL']['save']['guest']
            ),
            'SMILEY' => array(
                'user' => $parameters['ACL']['smiley']['user'],
                'guest' => $parameters['ACL']['smiley']['guest']
            ),
            'MAIL' => array(
                'user' => $parameters['ACL']['mail']['user'],
                'guest' => $parameters['ACL']['mail']['guest']
            ),
            'VIDEOCHAT' => array(
                'user' => 'noallow',
                'guest' => 'noallow'
            ),
            'CHATROOM' => array(
                'user' => $parameters['ACL']['chatroom']['user'],
                'guest' => $parameters['ACL']['chatroom']['guest']
            )
        );
        return $ACL;
    }

    public function get_smileys() {

        $query = "SELECT symbol,image_name FROM frei_smileys";

        $result = $this->db->query($query);
        return $result->fetchAll();
    }

    public function get_all_vars() {
        $this->get_js_config();
        $this->get_acl();
    }

//------------------------------------------------------------------------------------------------
    public function freichat_debug($message) {
        if ($this->debug == true) {
            $dbgfile = fopen("../freixlog.log", "a");
            fwrite($dbgfile, "\n" . date("F j, Y, g:i a") . ": " . $message . "\n");
        }
    }

//----------------------------------------------------------------------------------------------
    public function bigintval($value) {
        $value = trim($value);
        if (ctype_digit($value)) {
            return $value;
        }
        $value = preg_replace("/[^0-9](.*)$/", '', $value);
        if (ctype_digit($value)) {
            return $value;
        }
        return 0;
    }

//----------------------------------------------------------------------------------------------

    public function inc_lang() {
        if ($this->lang != 'english') {
            if (empty($frei_trans)) {
                $EnglishLangInc = require 'lang/english.php';
                if ($EnglishLangInc != 1) {
                    $this->freichat_debug('Enlish language file could not be included');
                }
            } else {
                $this->freichat_debug('frei_trans array already in use!');
            }

            $OtherLangInc = require 'lang/' . $this->lang . '.php';

            if ($OtherLangInc != 1) {
                $this->freichat_debug('Some error while including' . $this->lang . ' language file');
            }
        } else if ($this->lang == 'english') {
            $EnglishLangInc = require 'lang/english.php';

            if ($EnglishLangInc != 1) {
                $this->freichat_debug('path to english language incorrect');
            }
        } else {
            $this->freichat_debug('Wrong filename given in parameter');
        }
        return $frei_trans;
    }

}
