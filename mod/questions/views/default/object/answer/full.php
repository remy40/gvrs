<?php
$answer = $vars['entity'];

$date = elgg_view_friendly_time($answer->time_created);
$poster = $answer->getOwnerEntity();
$poster_text = elgg_echo('answers:answered', array($poster->name));
$subtitle = "<div class='elgg-subtext'>$poster_text - $date</div>";

$image = elgg_view_entity_icon(get_entity($answer->owner_guid), 'small');

$body = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'answers',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$body .= $subtitle;
$body .= elgg_view('output/longtext', array('value' => $answer->description));

//feels hacky...
$river_item = new ElggRiverItem();
$river_item->object_guid = $answer->guid;
$body .= elgg_view('river/elements/footer', array('item' => $river_item));

echo elgg_view_image_block($image, $body);
