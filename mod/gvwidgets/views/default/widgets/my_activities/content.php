<?php
$num = $vars['entity']->num_display;

$options = array(
	'subject_guid' => elgg_get_logged_in_user_guid(),
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);

$content = elgg_list_river($options);

if ($content) {
    $url = "activity/owner/" . elgg_get_logged_in_user_entity()->username;
    $content .= "<a href='$url'>" . elgg_echo('gvwidgets:seeall:my_activity'). "</a>";
}
else {
	$content = elgg_echo('river:none');
}

echo $content;
