<?php

$title = elgg_echo("gvthewire:settings:title");

$character_limit = elgg_get_plugin_setting('character_limit', 'gvthewire');
if (!$character_limit) {
	$character_limit = 350;
}

$body = elgg_echo('gvthewire:settings:character_limit:title');
$body .= elgg_view('input/text',array('name'=>'params[character_limit]','value'=>$character_limit));

echo elgg_view_module("inline", $title, $body);
