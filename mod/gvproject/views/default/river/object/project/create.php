<?php
$statement = $vars['item'];
$entity = get_entity($statement->object_guid);
$performed_by = get_entity($entity->container_guid);

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

$content = elgg_echo("gvprojects:river:created:by", array($owner_url, $question_url));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'summary' => $content,
));
