<?php
/**
 * GV friend request plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvfriendrequest_init');

/**
 * Initialize the GV friend request plugin.
 */
function gvfriendrequest_init() {
	elgg_unregister_event_handler("pagesetup", "system", "friend_request_pagesetup");
	elgg_register_event_handler("pagesetup", "system", "gvfriendrequest_pagesetup");
}

function gvfriendrequest_pagesetup() {
    $context = elgg_get_context();
    $page_owner = elgg_get_page_owner_entity();
    
    // Remove link to friendsof
    elgg_unregister_menu_item("page", "friends:of");
    
    if($user = elgg_get_logged_in_user_entity()){
        $options = array(
            "type" => "user",
            "count" => true,
            "relationship" => "friendrequest",
            "relationship_guid" => $user->getGUID(),
            "inverse_relationship" => true
        );
        
        if($count = elgg_get_entities_from_relationship($options)){
            $class = "elgg-icon elgg-icon-users";
            $text = "<span class='$class'></span>";
            $tooltip = elgg_echo('gvtheme:myfriends');
            if ($count > 0) {
                $text .= "<span class=\"messages-new\">$count</span>";
                $tooltip = elgg_echo("friend_request:unreadcount", array($count));
            }

            $params = array(
                "name" => "friends",
                "href" => "friend_request/" . $user->username,
                "text" => $text,
                "section" => 'alt',
                "title" => $tooltip,
            );
            
            elgg_register_menu_item("topbar", $params);
        }
    }
    
    // Show menu link in the correct context
    if(in_array($context, array("friends", "friendsof", "collections")) && !empty($page_owner) && $page_owner->canEdit()){
        $options = array(
            "type" => "user",
            "count" => true,
            "relationship" => "friendrequest",
            "relationship_guid" => $page_owner->getGUID(),
            "inverse_relationship" => true
        );
        
        if($count = elgg_get_entities_from_relationship($options)){
            $extra = " (" . $count . ")";
        } else {
            $extra = "";
        }
        
        // add menu item
        $menu_item = array(
            "name" => "friend_request",
            "text" => elgg_echo("friend_request:menu") . $extra,
            "href" => "friend_request/" . $page_owner->username,
            "contexts" => array("friends", "friendsof", "collections"),
            "section" => "friend_request"
        );
        
        elgg_register_menu_item("page", $menu_item);
    }
}
