<?php

/**
 * chat script
 * params :
 *   - chat_title : title of the chat
 *   - channels : an array of default channels
 */

require_once dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/engine/start.php";
require_once dirname(__FILE__)."/src/phpfreechat.class.php";

$params["serverid"] =  md5($_SERVER['HTTP_REFERER']);
$params["language"] = "fr_FR";
$params["debug"] =  false;
$params["title"] = " ";
$params["nick"] =  elgg_get_logged_in_user_entity()->username;
$params["frozen_nick"] =  true;
$params["nickmeta"]    = array("avatar" => elgg_get_logged_in_user_entity()->getIconURL("medium"));
$params["isadmin"] = false;
$params["firstisadmin"] =  false;
$params["channels"] = array(elgg_echo("gvchat:defaultchannel"));
$params["max_channels"] = 10;
$params["refresh_delay"] =  2000;
$params["height"] =  "450px";
$params["theme"] =  "msn";
$params["theme_default_url"] = elgg_get_site_url()."mod/gvchat/vendors/phpfreechat/themes/";
$params["theme_path"] = dirname(__FILE__)."/themes";
$params["data_public_url"] = elgg_get_site_url()."mod/gvchat/vendors/phpfreechat/data/public";
$params["server_script_url"] = elgg_get_site_url()."mod/gvchat/vendors/phpfreechat/index.php";
$params["container_type"] = "File";
$params["container_cfg_chat_dir"] = dirname(__FILE__)."/data/private/chat";
$params["display_ping"] = false;
$params["displaytabimage"] = false;

$chat = new phpFreeChat( $params );

$chat->printChat();

?>
