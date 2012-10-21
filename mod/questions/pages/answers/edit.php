<?php
/**
 * Add answer edit page
 */

$answer_guid = get_input('guid');
$answer = get_entity($answer_guid);

if (!elgg_instanceof($answer, 'object', 'answer') || !$answer->canEdit()) {
	register_error(elgg_echo('answers:unknown'));
	forward(REFERRER);
}

$question = get_entity($answer->container_guid);

if (!elgg_instanceof($question, 'object', 'question')) {
	register_error(elgg_echo('answers:unknown'));
	forward(REFERRER);
}

$title = elgg_echo('answers:edit');

elgg_push_breadcrumb($question->title, $question->getUrl());
elgg_push_breadcrumb($title);

$vars = array(
	'entity' => $answer,
);

$content = "<h2>$title</h2>";
$content .= elgg_view_form('object/answer/save', array(), $vars);

$body = elgg_view_layout('content', array(
'content' => $content,
        'title' => $title,
        'filter' => '',
        'header' => '',));
echo elgg_view_page($title, $body);
