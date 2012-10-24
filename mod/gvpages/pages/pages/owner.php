<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */

elgg_load_library('elgg:pages');

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('pages/all');
}

// access check for closed groups
group_gatekeeper();

$title = elgg_echo('pages:owner', array($owner->name));

elgg_pop_breadcrumb();

if ($owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$owner->grouptype."groups"), "groups/".$owner->grouptype);
	elgg_push_breadcrumb($owner->name, "pages/group/".$owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($owner->name, "pages/owner/".$owner->guid."/all");
}

if ($owner instanceof ElggGroup) {
	elgg_register_title_button();
}

$integrate_in_pages = elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes';

if ($owner instanceof ElggGroup) {
    $content = elgg_list_entities(array(
        'types' => 'object',
        'subtypes' => $integrate_in_pages ? array('page_top', 'etherpad') : array('page_top'),
        'container_guid' => elgg_get_page_owner_guid(),
        'full_view' => false,
    ));
}
else {
    $content = elgg_list_entities(array(
        'types' => 'object',
        'subtypes' => $integrate_in_pages ? array('page_top', 'etherpad') : array('page_top'),
        'owner_guid' => elgg_get_page_owner_guid(),
        'full_view' => false,
    ));
}
if (!$content) {
	$content = '<p>' . elgg_echo('pages:none') . '</p>';
}

$filter_context = '';
if (elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$sidebar = elgg_view('pages/sidebar/navigation');
$sidebar .= elgg_view('pages/sidebar');

if (($owner instanceof ElggGroup) && $integrate_in_pages && $owner->canWriteToContainer()) {
	$url = "etherpad/add/$owner->guid";
	elgg_register_menu_item('title', array(
			'name' => 'etherpad-add',
			'href' => $url,
			'text' => elgg_echo('etherpad:add'),
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 200,
	));
}

$params = array(
	'filter_context' => $filter_context,
	'filter' => '',
    'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
