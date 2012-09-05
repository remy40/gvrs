<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

//$default_items = array_merge($default_items, $more_items);

echo '<ul class="elgg-menu elgg-menu-site elgg-menu-site-default clearfix">';
foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
}

echo '</ul>';
