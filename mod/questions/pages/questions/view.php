<?php
/**
 * View a question
 *
 * @package ElggQuestions
 */

$question = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;

if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$page_owner->grouptype."groups"), "groups/".$page_owner->grouptype);
	elgg_push_breadcrumb($page_owner->name, "questions/group/".$page_owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($page_owner->name, "questions/owner/".$page_owner->username);
}

$title = $question->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($question, true);

$options = array(
	'type' => 'object',
	'subtype' => 'answer',
	'container_guid' => $question->guid,
	'count' => TRUE,
	'order_by' => 'time_created asc',
);

$answers = elgg_list_entities($options);
$count = elgg_get_entities($options);

$content .= elgg_view_module('info', "$count " . elgg_echo('answers'), elgg_view_menu('filter') . $answers);

if ($question->canWriteToContainer(0, 'object', 'answer')) {
	$user_icon = elgg_view_entity_icon(elgg_get_logged_in_user_entity(), 'small');
	$add_form = elgg_view_form('object/answer/add', array(), array('container_guid' => $question->guid));
	
	$add_block = elgg_view_image_block($user_icon, $add_form);
	
	$content .= elgg_view_module('info', elgg_echo('answers:addyours'), $add_block);
}

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
));

echo elgg_view_page($title, $body);
