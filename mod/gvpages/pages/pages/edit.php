<?php
/**
 * Edit a page
 *
 * @package ElggPages
 */

elgg_load_library('elgg:pages');

gatekeeper();

$page_guid = (int)get_input('guid');
$page = get_entity($page_guid);
if (!$page) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

$container = $page->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

elgg_set_page_owner_guid($container->getGUID());

if ($container instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$container->grouptype."groups"), "groups/".$container->grouptype);
	elgg_push_breadcrumb($container->name, "pages/group/".$container->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($container->name, "pages/owner/".$container->guid."/all");
}

elgg_push_breadcrumb($page->title, $page->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo("pages:edit");

if ($page->canEdit()) {
	$vars = pages_prepare_form_vars($page);
	$content = elgg_view_form('pages/edit', array(), $vars);
} else {
	$content = elgg_echo("pages:noaccess");
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
