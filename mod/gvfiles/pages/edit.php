<?php
/**
 * Edit a file
 *
 * @package ElggFile
 */

elgg_load_library('elgg:file');

gatekeeper();

$file_guid = (int) get_input('guid');
$file = new FilePluginFile($file_guid);
if (!$file) {
	forward();
}
if (!$file->canEdit()) {
	forward();
}

$title = elgg_echo('file:edit');

$container = elgg_get_page_owner_entity();

if ($container instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$container->grouptype."groups"), "groups/".$container->grouptype);
	elgg_push_breadcrumb($container->name, "file/group/".$container->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($container->name, "file/owner/".$container->guid."/all");
}

elgg_push_breadcrumb($file->title, $file->getURL());
elgg_push_breadcrumb($title);

$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = file_prepare_form_vars($file);

$content = elgg_view_form('file/upload', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
