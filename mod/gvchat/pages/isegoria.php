<?php

$title = elgg_echo('gvchat:isegoria_chat');
$content = elgg_view('page/chat', array('view_id' => 'isegoria'));

$params = array(
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


