<?php
/**
 * Count of who has disliked something
 *
 *  @uses $vars['entity']
 */


$list = '';
$num_of_dislikes = gvdislikes_count($vars['entity']);
$guid = $vars['entity']->getGUID();

// display the number of dislikes
if (($num_of_dislikes == 0) || ($num_of_dislikes == 1)) {
	$dislikes_string = elgg_echo('gvdislikes:dislikes:userdislikedthis', array($num_of_dislikes));
} else {
	$dislikes_string = elgg_echo('gvdislikes:dislikes:usersdislikedthis', array($num_of_dislikes));
}
$params = array(
	'text' => $dislikes_string,
	'title' => elgg_echo('gvdislikes:dislikes:see'),
	'rel' => 'popup',
	'href' => "#dislikes-$guid"
);
$list = elgg_view('output/url', $params);
$list .= "<div class='elgg-module elgg-module-popup elgg-dislikes hidden clearfix' id='dislikes-$guid'>";
$list .= elgg_list_annotations(array(
	'guid' => $guid,
	'annotation_name' => 'dislikes',
	'limit' => 99,
	'list_class' => 'elgg-list-dislikes'
));
$list .= "</div>";
echo $list;
