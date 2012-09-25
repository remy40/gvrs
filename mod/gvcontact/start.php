<?php
/**
 * GV contact plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvcontact_init');

/**
 * Initialize the GV contact plugin.
 */
function gvcontact_init() {

    // add page handler
    elgg_register_page_handler('contact', 'gvcontact_page_handler');

    // extend css view
	elgg_extend_view('css/elgg', 'gvcontact/css');

    // add a menu item in the footer
    elgg_register_menu_item('footer', array(
    'name' => 'contact',
    'href' => "contact",
    'text' => elgg_echo('gvcontact:contact'),
    ));
    
    // register a new action
	$action_base = elgg_get_plugins_path() . 'gvcontact/actions';
	elgg_register_action("gvcontact/contact", "$action_base/gvcontact/contact.php");
}

/**
 * gvcontact page handler
 *
 * @param array  $page    URL segements
 * @param string $handler Handler identifier
 * @return bool
 */
function gvcontact_page_handler($page, $handler) {
    $title = elgg_echo('gvcontact:contacttitle');
    $content = elgg_view_form('gvcontact/contact');
    $body = elgg_view_layout('one_column', array('content' => $content));
	echo elgg_view_page($title, $body);
}
