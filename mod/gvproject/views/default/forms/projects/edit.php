<?php
/**
 * Project edit form body
 */

$user = elgg_get_logged_in_user_entity();
$entity = elgg_extract('entity', $vars);
$container_guid = elgg_extract('container_guid', $vars);

if ($entity) {
    $title = $entity->title;
    $short_desc = $entity->short_desc;
    $description = $entity->description;
    $tags = $entity->tags;
    $competencies = $entity->competencies;
}
else {
    $title = '';
    $short_desc = '';
    $description = '';
    $tags = '';
    $competencies = '';
}

echo "<div>";
echo "<label>".elgg_echo("gvprojects:title:label")."</label>";
echo elgg_view("input/text", array('name' => 'title', 'value' => $title));
echo "<label>".elgg_echo("gvprojects:short_desc:label")."</label>";
echo elgg_view("input/text", array('name' => 'short_desc', 'value' => $short_desc));
echo "<label>".elgg_echo("gvprojects:description:label")."</label>";
echo elgg_view("input/longtext", array('name' => 'description', 'value' => $description))."<br>";
echo "<label>".elgg_echo("gvprojects:competencies:label")."</label>";
echo elgg_view("input/longtext", array('name' => 'competencies', 'value' => $competencies))."<br>";
echo "<label>".elgg_echo("gvprojects:tags:label")."</label>";
echo elgg_view("input/tags", array('name' => 'tags', 'value' => $tags));
echo "</div>";

if ($entity) {
	echo elgg_view('input/hidden', array(
		'name' => 'project_guid',
		'value' => $entity->guid,
	));
}

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $container_guid,
));

echo elgg_view('input/submit', array('value' => elgg_echo('save')));
