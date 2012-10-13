<?php
/**
 * Add bookmark page
 *
 * @package questions
 */

$title = elgg_echo('questions:add');

$page_owner_guid = get_input('guid');
$page_owner = get_entity($page_owner_guid);
elgg_set_page_owner_guid($page_owner_guid);

if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$page_owner->grouptype."groups"), "groups/".$page_owner->grouptype);
	elgg_push_breadcrumb($page_owner->name, "questions/group/".$page_owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($page_owner->name, "questions/owner/".$page_owner->username);
}
elgg_push_breadcrumb($title);

$content = elgg_view_form('object/question/save');

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'header' => '',
));

echo elgg_view_page($title, $body);
