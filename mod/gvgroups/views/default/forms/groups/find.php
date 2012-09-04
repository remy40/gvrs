<?php
/**
 * Group tag-based search form body
 */

$params = array(
	'name' => 'searchstring',
	'class' => 'elgg-input-search mbm',
	'value' => '',
	'onclick' => "if (this.value=='$tag_string') { this.value='' }",
);
echo elgg_view('input/text', $params);

echo elgg_view('input/submit', array('value' => elgg_echo('search:go')));
