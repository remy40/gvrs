**************************************************************************
** ELGG: Web Portal System                                              **
** Module for 123 Flash Chat Server software                            **
** ==============================================                       **
**                                                                      **
** Copyright (c) by TopCMM 					        **
** Daniel Jiang (support@123flashchat.com)          			**
** http://www.topcmm.com						**
** http://www.123flashchat.com                                          **
** http://elgg.org/                                                     **
** ===============================================                      **
**                                                                      **
** Contributors: 123FlashChat                                           **
** Version: 1.0                                                         **
** Donate link: www.123flashchat.com                                    **
** Requires at least: 1.8.3                                             **
** Tested up to: 1.8.4                                                  **
** Tags: 123 Flash Chat, Chat Software, Flash Chat Hosting,             **
**      Video Webcam Audio, Chat Server, Live Help, IM,                 **
**      Facebook-like Messenger                                         **
**                                                                      **
**************************************************************************



####################################################################################################################
## Notes:                                                                                                         ##
##                                                                                                                ##
##     IMPORTANT!!!!                                                                                              ##
##     If you need to use the chat service on a local machine, before installing this module, please              ##
##     download 123FlashChat Server software first from this page:                                                ##
##     http://www.123flashchat.com/download.html                                                                  ##
##     You may get the latest free demo version of 123 flash chat server software at there.                       ##
##                                                                                                                ## 
##     And get professional support from: http://www.123flashchat.com/support.html                                ##
##     We provide email support, online live support, and phone support                     			  ##
##     etc.                                                                                                       ##
##                                                                                                                ##
####################################################################################################################

== Installation ==

Step 1.Upload :
	1. If your website supports online decompression:
		1. Please upload the plug-in to your website path: <root>/mod 
		2.Decompress the file to current path
	2. If your website does not support online decompression:
		1.Please decompress the file locally and get the 123flashchat folder
		2. FTP upload this folder to :<root>/mod 

Step 2.Activete:
	Login admin panel, and find to click Configure -> Plugins -> 123 Flash Chat 1.0, then click Activate.

Step 3.Configure module:
	(1) In Administration page , find 123 Flash Chat at sitebar Configure->settings,Click it.
	(2) Configure and save the Settings.

Step 4. Notice: If your server is not windows, you may need mod/123flashchat/cache is writeable.	

Step 5.Integrate your chat with elgg user database
	Intro: For those who chooses running chat on [host mode] or [localhost mode], database integration is necessary,
		please follow the instructions below.

				1. Admin Panel, Log in the Admin Panel of your 123FlashChat server using chat admin account.

				 OPEN: Server Settings-> Integration

				2. For DataBase, SELECT: URL, and click "edit"

				3. Change URL to:

				   http://<Your elgg root URL>/123flashchat/login_chat?username=%username%&password=%password%

				4. Press OK to save the setting.
				
				5. OPEN: Server Management -> Restart, to restart server.
				
Step 6. If you want to show the chat information in every page, please do the following steps:
	1.modify file: <root>/views/default/page/layouts/one_sidebar.php
		
		Find :
		
			<div class="elgg-sidebar">
				<?php
					echo elgg_view('page/elements/sidebar', $vars);

		After Add :
			
			/* 123 FLASH CHAT CODE START */
			require_once(elgg_get_plugins_path().'123flashchat/pages/123flashchat/sidebar.php');
			require_once(elgg_get_plugins_path().'123flashchat/lib/functions.php');
			global $CONFIG;
			$queryguid = "SELECT * FROM {$CONFIG->dbprefix}objects_entity WHERE title = '123flashchat'";
			$chatobject = get_data_row($queryguid);
			$query = "SELECT * FROM {$CONFIG->dbprefix}private_settings WHERE entity_guid = $chatobject->guid";
			$chatSettingarray = get_data($query);
			foreach ($chatSettingarray as $key => $value){
				$chatSetting[$value->name] = $value->value;
			}
			$chatSetting = (object)$chatSetting;
			echo getSideBar($chatSetting);
			/* 123 FLASH CHAT CODE END */
			
					
	2.modify file: <root>/mod/123flashchat/pages/123flashchat/index.php
			
		Find :
		
			$sidebar = getSideBar($chatSetting);
			
		change it with:
		
			//$sidebar = getSideBar($chatSetting);
			$sidebar = '';
					

If you have any question related chat room,please visit http://www.123flashchat.com/faq.html or contact our online supporter at http://www.123flashchat.com
