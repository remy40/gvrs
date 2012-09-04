<?php 

	$plugin = $vars["entity"];

    $limit_options = array ('0' => elgg_echo('gvgroups:settings:nolimit'),
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5');

    $title = elgg_echo("gvgroups:settings:local_limit_title");

    // national limit
    $body = "<div>";
	$body .= elgg_echo("gvgroups:settings:national_limit");
	$body .= elgg_view("input/dropdown", 
                        array("name" => "params[national_limit]", 
                              "options_values" => $limit_options, 
                              "value" => $plugin->national_limit));
    $body .= "</div>";

    // regional limit
    $body .= "<div>";
	$body .= elgg_echo("gvgroups:settings:regional_limit");
	$body .= elgg_view("input/dropdown", 
                        array("name" => "params[regional_limit]", 
                              "options_values" => $limit_options, 
                              "value" => $plugin->regional_limit));
    $body .= "</div>";

    // departemental limit
    $body .= "<div>";
	$body .= elgg_echo("gvgroups:settings:departemental_limit");
	$body .= elgg_view("input/dropdown", 
                        array("name" => "params[departemental_limit]", 
                              "options_values" => $limit_options, 
                              "value" => $plugin->departemental_limit));
    $body .= "</div>";

    // town limit
    $body .= "<div>";
	$body .= elgg_echo("gvgroups:settings:town_limit");
	$body .= elgg_view("input/dropdown", 
                        array("name" => "params[town_limit]", 
                              "options_values" => $limit_options, 
                              "value" => $plugin->town_limit));
    $body .= "</div>";

	echo elgg_view_module("inline", $title, $body);
