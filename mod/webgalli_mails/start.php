<?php

	/**
	 * Elgg mass mailout
	 * @package ElggMassMailout
	 * @author Dr Sanu P Moideen @ Team Webgalli
	 * @copyright Team Webgalli 2008-2015
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @link http://webgalli.com/
	 * Looking for Elgg free themes/pluggins/commercial support/elgg hosting? Visit http://webgalli.com/
	 */
	 
	 global $CONFIG;
		elgg_extend_view('metatags','webgalli_mails/metatags');
		register_page_handler('webgalli_mails','webgalli_mails_page_handler');
		function webgalli_mails_page_handler($page) {
			global $CONFIG;
			include($CONFIG->pluginspath . "webgalli_mails/index.php");
		}
		
		if (get_context() == 'admin' && isadminloggedin()) {
								add_submenu_item(elgg_echo('Sent mail to all'),$CONFIG->wwwroot."pg/webgalli_mails");
							}
							
		register_elgg_event_handler('init','system','webgalli_mails_init');
		register_elgg_event_handler('pagesetup','system','webgalli_mails_pagesetup');
							
		register_action("webgalli_mails/mailer",false,$CONFIG->pluginspath . "webgalli_mails/actions/mailer.php");
?>