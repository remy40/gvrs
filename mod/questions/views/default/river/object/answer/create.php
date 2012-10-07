<?php
/**
 * River entry for new answers
 */
$statement = $vars['item'];
$performed_by = get_entity($statement->subject_guid);
$entity = get_entity($statement->object_guid);

$owner_url = elgg_view('output/url', array(
	'href' => $performed_by->getURL(),
	'text' => $performed_by->name,
	'encode_text' => TRUE,
));

$question_url = elgg_view('output/url', array(
	'href' => $entity->getURL(),
	'text' => $entity->title,
	'encode_text' => TRUE,
));

echo elgg_echo("questions:river:answer:created:by", array($owner_url, $question_url));
