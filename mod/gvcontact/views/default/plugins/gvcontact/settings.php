<?php
/**
 * GV Contact plugin settings
 */

echo '<div>';
echo elgg_echo('gvcontact:email');
echo ' ';
echo elgg_view('input/text', array('name' => 'params[email]', 'value' => $vars['entity']->email));
echo '</div>';
