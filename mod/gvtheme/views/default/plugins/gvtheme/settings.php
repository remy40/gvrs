<?php

$title = elgg_echo('gvtheme:website_presentation');

$body 	= "<label>".elgg_echo('gvtheme:website_description:title')."</label>";
$body  .= elgg_view('input/text', array('name' => 'params[website_description]', 'value' => $vars['entity']->website_description));
$body  .= "<label>".elgg_echo('gvtheme:website_thumbnail:title')."</label>";
$body  .= elgg_view('input/text', array('name' => 'params[website_thumbnail]', 'value' => $vars['entity']->website_thumbnail));

echo elgg_view_module("inline", $title, $body);
