<?php
/**
 * Elgg add like action
 *
 */

$entity_guid = (int) get_input('guid');

//check to see if the user has already liked the item
if (elgg_annotation_exists($entity_guid, 'likes')) {
	system_message(elgg_echo("likes:alreadyliked"));
	forward(REFERER);
}

//check to see if the user has already disliked the item
if (elgg_annotation_exists($entity_guid, 'dislikes')) {
	$dislikes = elgg_get_annotations(array(
	'guid' => $entity_guid,
	'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
	'annotation_name' => 'dislikes',
	));
	
	if ($dislikes) {
		if ($dislikes[0]->canEdit()) {
			$dislikes[0]->delete();
		}
	}
}

// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("likes:notfound"));
	forward(REFERER);
}

// limit likes through a plugin hook (to prevent liking your own content for example)
if (!$entity->canAnnotate(0, 'likes')) {
	// plugins should register the error message to explain why liking isn't allowed
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();
$annotation = create_annotation($entity->guid,
								'likes',
								"likes",
								"",
								$user->guid,
								$entity->access_id);

// tell user annotation didn't work if that is the case
if (!$annotation) {
	register_error(elgg_echo("likes:failure"));
	forward(REFERER);
}

// notify if poster wasn't owner and if entity is a user
if (($entity instanceof ElggEntity) && 
	($user instanceof ElggUser) &&
	($entity->getOwnerEntity() instanceof ElggUser) && 
	($entity->owner_guid != $user->guid)) {
	likes_notify_user($entity->getOwnerEntity(), $user, $entity);
}

system_message(elgg_echo("likes:likes"));

// Forward back to the page where the user 'liked' the object
forward(REFERER);
