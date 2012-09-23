<?php

$group_error = false;
$groupguid = get_input("groupguid", 0);

if ($groupguid) {
    $group = get_entity($groupguid);
    
    if ($group && ($group instanceof ElggGroup)) {
        $title = elgg_echo('gvchat:group_chat', array($group->name));
        $content = elgg_view('page/chat', array('view_id'=> $group->name . "$groupguid"));
    }
    else {
        $group_error = true;
    }
}
else {
    $group_error = true;
}

if ($group_error) {
    $content = elgg_echo("gvchat:badgroup_content");
    $title = elgg_echo("gvchat:badgroup_title");
}

$params = array(
    'content' => $content,
    'title' => $title,
);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);


