<?php

    gatekeeper();

$category_string = elgg_get_plugin_setting('categories', 'gvcontact');
$category_string = str_replace(",", ";", $category_string);
$categories = explode(";", $category_string);

$category_options = array();
foreach($categories as $category) {
	$category_options[$category] = elgg_echo("gvcontact:$category"); 
}

$selected_category = get_input('category', 'bug');
$message = get_input('message', '');

echo "<p>" . elgg_echo('gvcontact:intro'). "</p>";
echo "<div class='contact-form'>";

if (count($categories) > 0) {
	echo "<div class='contact-category-container'><label>" . elgg_echo('gvcontact:category'). "</label>";
	echo elgg_view('input/dropdown', array('name' => 'category', 'options_values' => $category_options, 'value' => $selected_category)) . "</br>";
	echo "</div>";
}

echo "<label>" . elgg_echo('gvcontact:yourmessage'). "</label>";
echo elgg_view('input/longtext', array('name' => 'message', 'value' => $message));
echo elgg_view('input/submit', array('value' => elgg_echo('gvcontact:contactus')));
echo "</div>";
