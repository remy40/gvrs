<?php

$category = get_input('category');
$message  = get_input('message');

elgg_make_sticky_form('gvcontact');

if ($message != "") {
		// prepare admin guid array from a list of username 
		$admin_string = elgg_get_plugin_setting('admins', 'gvcontact');
		$admin_string = str_replace(",", ";", $admin_string);
		$admins = explode(';', $admin_string);
		
		$admin_guids = array();
		foreach ($admins as $admin) {
			$admin_user = get_user_by_username($admin);
			
			if ($admin_user && elgg_instanceof($admin_user, 'user')) {
				$admin_guids[] = $admin_user->guid;
			}
		}
		
		// prepare notification data
		$user 	 = elgg_get_logged_in_user_entity();
		$subject = "request - {$user->name} ({$user->username}) - ". elgg_echo("gvcontact:$category");
 		
		try {
			$method = elgg_get_plugin_setting('method', 'gvcontact');
			if (empty($method)) {$method = "email";}
			
			notify_user($admin_guids, elgg_get_logged_in_user_guid(), $subject, $message, NULL, $method); 
			elgg_clear_sticky_form('gvcontact');
		}
		catch(NotificationException $e) {
			register_error(elgg_echo('gvcontact:mail_error'));
		}
		
         system_message('gvcontact:mail_success');
}
else {
	register_error(elgg_echo('gvcontact:message_error'));
}

forward('contact');
