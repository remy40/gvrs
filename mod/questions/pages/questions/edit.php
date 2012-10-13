<?php
/**
 * Add question page
 *
 * @package ElggQuestions
 */

$question_guid = get_input('guid');
$question = get_entity($question_guid);

if (!elgg_instanceof($question, 'object', 'question') || !$question->canEdit()) {
	register_error(elgg_echo('questions:unknown'));
	forward(REFERRER);
}

$title = elgg_echo('questions:edit');

$page_owner = elgg_get_page_owner_entity();
if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$page_owner->grouptype."groups"), "groups/".$page_owner->grouptype);
	elgg_push_breadcrumb($page_owner->name, "questions/group/".$page_owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($page_owner->name, "questions/owner/".$page_owner->username);
}
elgg_push_breadcrumb($title);

$vars = array(
	'entity' => $question,
);

$content = elgg_view_form('object/question/save', array(), $vars);

$body = elgg_view_layout('content', array(
'content' => $content,
        'title' => $title,
        'filter' => '',
        'header' => '',));
echo elgg_view_page($title, $body);
