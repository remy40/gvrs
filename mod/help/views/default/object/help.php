<?php
/**
 * Entity view for a help topic
 * Type: object Subtype: help
 *
 * @uses $vars['entity'] ElggObject
 */

$item = $vars['entity'];
$question = $item->title;
$answer = $item->description;

$modify_link='';
if (elgg_is_admin_logged_in()) {
	$modify_link = elgg_view('output/url', array(
								'href' => "help/admin?guid=".$item->guid,
								'text' => elgg_echo("help:question:modify"),
								'class' => 'help-modify-link',
								'is_trusted' => true));
}

// full view means we display the question and answer
if ($vars['full_view']) {
	$body = elgg_view('output/longtext', array(
		'value' => $answer,
		'class' => 'mtn',
	));

	echo <<<HTML
<div class="mbl" id="$item->guid">
	<h2>$question</h2> $modify_link
	$body
</div>
HTML;

} else {
	// summary view is just a link
	$url = "help/category/$item->category#$item->guid";
	echo elgg_view('output/url', array(
		'href' => $url,
		'text' => $question,
		'is_trusted' => true,
	));
	echo $modify_link;
}
