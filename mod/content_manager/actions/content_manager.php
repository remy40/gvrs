<?php

$entities_guids = explode(" ", get_input('entities_guids'));
$subtype_content_filter = explode(" ", get_input('subtype_content_filter'));
$offset = get_input('offset');

error_log('subtype_content_filter (actions): '.$subtype_content_filter);

$deleted_entities = 0;
foreach ($entities_guids as $entity_guid) {
	$checked = get_input("entity-".$entity_guid, 0);

	if ($checked) {
		$entity = get_entity($entity_guid);
		
		if ($entity) {
			$entity->delete();
			$deleted_entities += 1;
		}
	}
}

if ($deleted_entities) {
	system_message(elgg_echo("content_manager:delete_entities", array($deleted_entities)));
}
else {
	register_error(elgg_echo("content_manager:no_deleted_entities"));
}

return true;
