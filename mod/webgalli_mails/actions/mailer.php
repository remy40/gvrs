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
	action_gatekeeper();
	admin_gatekeeper();
	$siteemail = $CONFIG->siteemail;
	$name = $CONFIG->sitename;
	$message = get_input('message');
	$message = html_entity_decode($message, ENT_COMPAT, 'UTF-8'); // Decode any html entities
	$message = strip_tags($message); // Strip tags from message
	$message = preg_replace("/(\r\n|\r)/", "\n", $message); // Convert to unix line endings in body
	$message = wordwrap($message);
	$subject = get_input('subject');
	$offset = (int)get_input('offset', 0);
	$limit = 9999;
	if(empty($subject) || empty($message)) {
			register_error(elgg_echo("webgalli_mails:requiredfieldsempty"));
			forward($_SERVER['HTTP_REFERER']);
	} else {
		$users = get_entities('user', '', 0, '', $limit, $offset);
		if ($users)	{
				// create the from address
				$site = get_entity($CONFIG->site_guid);
				if (($site) && (isset($site->email))) {
					$from = $site->email;
				} else {
					$from = 'noreply@' . get_site_domain($CONFIG->site_guid);
				}

			foreach ($users as $u) {
				$to = $u->email;
				$action = elgg_send_email($from, $to, $subject, $message);
	}
				if ($action) {	
				system_message(elgg_echo('webgalli_mails:mailssent'));
				} else {
				register_error(elgg_echo("webgalli_mails:mailfailure"));
				}				
		} 
	}

	forward($_SERVER['HTTP_REFERER']);

?>
