<?php
$num = $vars['entity']->num_display;

if (elgg_in_context('profile')) {
	$owner = elgg_get_page_owner_entity();
}
else {
	$owner = elgg_get_logged_in_user_entity();
}

$options = array(
	'subject_guid' => $owner->guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);

$content = elgg_list_river($options);

if ($content) {
    $url = "activity/owner/" . $owner->username;
    $content .= "<a href='$url'>" . elgg_echo('gvwidgets:seeall:my_activity'). "</a>";
}
else {
	$content = elgg_echo('river:none');
}

echo $content;
