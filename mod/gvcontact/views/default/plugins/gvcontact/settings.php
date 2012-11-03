<?php
/**
 * GV Contact plugin settings
 */

global $NOTIFICATION_HANDLERS;

$method_options = array();
foreach ($NOTIFICATION_HANDLERS as $key => $handler) {
	$method_options[$key] = $key;
}

echo '<div>';
echo "<label>".elgg_echo('gvcontact:settings:admin')."</label><br>";
echo elgg_echo('gvcontact:settings:admin:description');
echo elgg_view('input/text', array('name' => 'params[admins]', 'value' => $vars['entity']->admins));
echo "<br><label>".elgg_echo('gvcontact:settings:category')."</label><br>";
echo elgg_echo('gvcontact:settings:category:description');
echo elgg_view('input/text', array('name' => 'params[categories]', 'value' => $vars['entity']->categories));
echo "<br><label>".elgg_echo('gvcontact:settings:method')."</label><br>";
echo elgg_view('input/dropdown', array('name' => 'params[method]', 'options_values' => $method_options, 'value' => $vars['entity']->method));
echo '</div>';
