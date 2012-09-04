<?php
/**
 * Elgg subtitle element
 *
 * @uses $vars['title'] The page title
 * @uses $vars['class'] Optional class for heading
 */

$class= '';
if (isset($vars['class'])) {
	$class = " class=\"{$vars['class']}\"";
}

echo "<h3{$class}>{$vars['title']}</h3>";
