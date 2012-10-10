<?php
$entity = $vars['entity'];
$limit = $entity->num_display;
	
//if no number has been set, default to 5
if(!$limit) $limit = 5;

$options = array(
	'type' => 'object',
	'subtype' => 'project',
	'limit' => $limit,
	'full_view' => FALSE,
	'pagination' => FALSE,
);

if (elgg_in_context('groups')) {
	$group = elgg_get_page_owner_entity();

	if ($group && ($group instanceof ElggGroup)) {
		$options['container_guid'] = $group->guid;
	}

	$url_more = "projects/group/$group->guid/all";
}
else {
	$url_more = "projects/all";
}
	
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$more_link = elgg_view('output/url', array(
		'href' => $url_more,
		'text' => elgg_echo("projects:more"),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo("projects:none");
}
