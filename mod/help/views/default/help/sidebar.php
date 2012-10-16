<?php
/**
 * Sidebar for a category's topics
 *
 * @uses $vars['category']
 */

$current_category = $vars['category'];
$categories = help_get_categories();

$heading = elgg_echo('help:categories');

echo "<ul class='help-categories-sidebar'>";
foreach($categories as $code => $name) {
	if ($code != $current_category) {
		$url = "help/category/$code";
		$link  = elgg_view("output/url", array('text' => $name, 'href' => $url));
		$body .= "<li>$link</li>";
	}
}
echo "<ul>";

echo elgg_view_module('aside', $heading, $body);
