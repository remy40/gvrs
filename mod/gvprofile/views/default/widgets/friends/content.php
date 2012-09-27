<?php
/**
 * Friend widget display view
 *
 */

// owner of the widget
$owner = $vars['entity']->getOwnerEntity();

// the number of friends to display
$num = (int) $vars['entity']->num_display;

// get the correct size
$size = $vars['entity']->icon_size;

$show_type = $vars['entity']->show_type;

if (elgg_instanceof($owner, 'user')) {
	$html = $owner->listFriends('', $num, array(
		'size' => $size,
		'list_type' => $show_type,
		'pagination' => false
	));
	if ($html) {
		echo $html;
	}
}
