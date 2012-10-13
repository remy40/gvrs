<?php
/**
 * Elgg questions plugin everyone page
 *
 * @package Questions
 */

$page_owner = elgg_get_page_owner_entity();

if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$page_owner->grouptype."groups"), "groups/".$page_owner->grouptype);
	elgg_push_breadcrumb($page_owner->name, "questions/group/".$page_owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($page_owner->name, "questions/owner/".$page_owner->username);
}

$title = elgg_echo('questions:owner', array($page_owner->name));

if ($page_owner instanceof ElggGroup) {
	elgg_register_menu_item('title', array(
		'name' => 'addquestion',
		'href' => "questions/add/".$page_owner->guid,
		'text' => elgg_echo('questions:add'),
		'link_class' => 'elgg-button elgg-button-action',
		'contexts' => array('questions'),
		 ));
}

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'question',
	'container_guid' => $page_owner->guid,
	'full_view' => false,
	'list_type_toggle' => false
));

if (!$content) {
	$content = elgg_echo('questions:none');
}

$vars = array(
	'title' => $title,
	'content' => $content,
);

// don't show filter if out of filter context
//if ($page_owner instanceof ElggGroup) {
	$vars['filter'] = false;
//}
/*else if ($page_owner instanceof ElggUser) {
	$vars['filter_context'] = 'mine';
}
*/
$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);
