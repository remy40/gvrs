<?php

elgg_make_sticky_form('answer');

$guid = get_input('guid');

if ($guid) {
	$answer = get_entity($guid);
	$editing = true;
	$adding = false;
}
else {
	$answer = new ElggAnswer($guid);
	$editing = false;
	$adding = true;
}

if ($editing && !$answer->canEdit()) {
	register_error(elgg_echo('answers:edit_error'));
	forward(REFERER);
}

$container_guid = get_input('container_guid');
if (!$container_guid) {
	$container_guid = elgg_get_logged_in_user_guid();
}
/*
if ($adding && !can_write_to_container(0, $container_guid, 'object', 'answer')) {
	register_error("You do not have permission to answer that question!");
	forward(REFERER);
}
*/
$question = get_entity($container_guid);

$description = get_input('description');

if (empty($container_guid) || empty($description)) {
	register_error(elgg_echo('answers:empty_description'));
	forward(REFERER);
}

$answer->description = $description;
$answer->access_id = $question->access_id;
$answer->container_guid = $container_guid;

try {
	$answer->save();

	if ($adding) {
		add_to_river('river/object/answer/create', 'create', elgg_get_logged_in_user_guid(), $question->guid, $question->access_id);
	}
} catch (Exception $e) {
	register_error(elgg_echo('answers:save_error'));
	register_error($e->getMessage());
}

elgg_clear_sticky_form('answer');

forward(get_input('forward', $answer->getURL()));
