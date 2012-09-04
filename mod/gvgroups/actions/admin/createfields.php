<?php

require_once(dirname(__FILE__) . "/../../lib/country.php");
require_once(dirname(__FILE__) . "/../../lib/profile.php");

// add country field
$field_options = array(
    "metadata_name" => "pays",
    "metadata_label" => elgg_echo('gvgroups:mycountry'),
    "metadata_hint" => "",
    "metadata_type" => "dropdown",
    "metadata_options" => get_country_list(),
    "show_on_register" => true,
    "mandatory" => false,
    "user_editable" => true,
    "output_as_tags" => false,
    "admin_only" => false,
    "blank_available" => false,
    "type" => "profile",
    );

var_dump($field_options);
edit_profile_field($field_options);

// add region field
$field_options = array(
    "metadata_name" => "region",
    "metadata_label" => elgg_echo('gvgroups:myregion'),
    "metadata_options" => get_region_list(),
    );

var_dump($field_options);
edit_profile_field($field_options);

// add departement field
$field_options = array(
    "metadata_name" => "departement",
    "metadata_label" => elgg_echo('gvgroups:mydepartement'),
    "metadata_options" => get_departement_list(),
    );

var_dump($field_options);
edit_profile_field($field_options);

system_message(elgg_echo('gvgroups:createfields:ok'));
forward(REFERER);
