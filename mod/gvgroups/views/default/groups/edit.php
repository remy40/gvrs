<?php
/**
 * Edit/create a group wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);
$group_type = elgg_extract('group_type', $vars, 'default');
$parent_guid = elgg_extract('parent_guid', $vars, 0);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array('entity' => $entity, 'group_type' => $group_type, 'parent_guid' => $parent_guid);
echo elgg_view_form('groups/edit', $form_vars, $body_vars);
