<?php
/**
 * List all questions in a category
 */

// category is passed from page handler
$category = get_input('category', 'getting_started');

$title = elgg_echo("help:title:$category");

elgg_push_breadcrumb(elgg_echo('menu:home'), "dashboard");
elgg_push_breadcrumb(elgg_echo('help'), 'help');
elgg_push_breadcrumb($title);


// get the topics for this category
$options = array(
	'type' => 'object',
	'subtype' => 'help',
	'metadata_name' => 'category',
	'metadata_value' => $category,
	'limit' => NULL,
);

// first, creates the table of contents
$questions = elgg_get_entities_from_metadata($options);

$vars = array('full_view' => false,
			  'count' => count($questions),
			  'offset' => 0,
			  'list_class' => 'help-list',
			  'pagination' => false);
			  
$content  = "<div class='help-table-of-contents-container'>";
$content .= "<label id='help-table-of-contents-title'>".elgg_echo("help:tableofcontents")."</label>";
$content .= elgg_view_entity_list($questions, $vars);
$content .= "</div></br>";

// then, shows the entities
$vars['full_view'] = true;
$content .= elgg_view_entity_list($questions, $vars);

// create the sidebar
$vars = array('category' => $category);
$sidebar = elgg_view('help/sidebar', $vars);

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
	'filter' => false,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
