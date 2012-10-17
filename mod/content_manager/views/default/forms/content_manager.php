<?php

$subtype_content_filter = get_input("subtype_content_filter");
$offset = get_input("offset", 0);
$limit = 50;

error_log('subtype_content_filter (forms): '.$subtype_content_filter);

$options = array('type' => 'object',
				 'subtypes' => $subtype_content_filter,
				 'pagination' => true,
				 'full_view' => false,
				 'count' => true);

$count = elgg_get_entities($options);

unset($options['count']);
$options['limit'] = $limit;
$options['offset'] = $offset;

$entities = elgg_get_entities($options);

echo "</br><label>".elgg_echo("content_manager:content")."</label>";
echo "<table class='elgg-table content-manager-table'>";
echo "<thead>";
echo "<tr>";
echo "<th class='center'>".elgg_echo("content_manager:select")."</td>";
echo "<th class='center'>".elgg_echo("content_manager:type")."</td>";
echo "<th class='center'>".elgg_echo("content_manager:creator")."</td>";
echo "<th class='center'>".elgg_echo("content_manager:container")."</td>";
echo "<th class='center'>".elgg_echo("content_manager:date")."</td>";
echo "<th class='center'>".elgg_echo("content_manager:title")."</td>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

$entities_guids = array();
foreach($entities as $entity) {
	$owner = $entity->getOwnerEntity();
	$container = $entity->getContainerEntity();
	$timeCreated = $entity->getTimeCreated();
	$entities_guids[] = $entity->guid;

	if ($container instanceof ElggGroup) {
		$container_type = "Group";
	}
	else {
		$container_type = "User";
	}
	
	echo "<tr>";
	echo "<td class='center'>".elgg_view('input/checkbox', array('name' => "entity-{$entity->guid}"))."</td>";
	echo "<td class='center'>".get_subtype_from_id($entity->subtype)."</td>";
	echo "<td class='center' title='$owner->name'>".$owner->username."</td>";
	echo "<td class='center' title='$container->name'>".$container_type."</td>";
	echo "<td class='center'>".date("Y-m-d", $timeCreated)."</td>";
	echo "<td>".$entity->title."</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "</table>";

echo elgg_view('navigation/pagination', array(
				'base_url' => 'admin/administer_utilities/content_manager',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
				'offset_key' => "offset",
			));

echo elgg_view('input/hidden', array('name' => 'entities_guids', 'value' => $entities_guids));
echo elgg_view('input/hidden', array('name' => 'subtype_content_filter', 'value' => $subtype_content_filter));
echo elgg_view('input/hidden', array('name' => 'offset', 'value' => $offset));
echo elgg_view('input/submit', array('value' => elgg_echo('content_manager:delete')));
