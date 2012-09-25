<?php

    gatekeeper();

$category_options = array('bug' => elgg_echo('gvcontact:bug'),
                          'improvement' => elgg_echo('gvcontact:improvement'),
                          'help' => elgg_echo('gvcontact:help'),
                          'misc' => elgg_echo('gvcontact:misc'));

$yourname = get_input('yourname', '');
$yourmail = get_input('yourmail', '');
$category = get_input('category', 'bug');
$yourmessage = get_input('yourmessage', '');

echo "<p>" . elgg_echo('gvcontact:intro'). "</p>";
echo "<div class='contact-form'>";
echo "<label>" . elgg_echo('gvcontact:yourname'). "</label>";
echo elgg_view('input/text', array('name' => 'yourname', 'value' => $yourname));
echo "<label>" . elgg_echo('gvcontact:yourmail'). "</label>";
echo elgg_view('input/text', array('name' => 'yourmail', 'value' => $yourmail));
echo "<div class='contact-category-container'><label>" . elgg_echo('gvcontact:category'). "</label>";
echo elgg_view('input/dropdown', array('name' => 'category', 'options_values' => $category_options, 'value' => $category)) . "</br></div>";
echo "<label>" . elgg_echo('gvcontact:yourmessage'). "</label>";
echo elgg_view('input/longtext', array('name' => 'yourmessage', 'value' => $yourmessage));
echo elgg_view('input/submit', array('value' => elgg_echo('gvcontact:contactus')));
echo "</div>";
