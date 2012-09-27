<?php
/**
 * GV profile plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvprofile_init');

/**
 * Initialize the GV profile plugin.
 */
function gvprofile_init() {
	elgg_register_page_handler('profile', 'gvprofile_page_handler');
}

/**
 * Profile page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */
function gvprofile_page_handler($page) {

	if (isset($page[0])) {
		$username = $page[0];
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
	}

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}

	$action = NULL;
	if (isset($page[1])) {
		$action = $page[1];
	}

	if ($action == 'edit') {
		// use the core profile edit page
		$base_dir = elgg_get_root_path();
		require "{$base_dir}pages/profile/edit.php";
		return true;
	}

	// main profile page
	$params = array(
		'num_columns' => 3,
//        'show_add_widgets' => false,
	);
    $content = elgg_view('profile/wrapper');
	$content .= elgg_view_layout('widgets', $params);

	$body = elgg_view_layout('one_column', array('content' => $content));
	echo elgg_view_page($user->name, $body);
	return true;
}
