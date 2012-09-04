<?php
	require_once(dirname(__FILE__) . "/../../lib/isegoria.php");

    $options["type"] = 'user';
    $options["limit"] = NULL;

    $entities = elgg_get_entities($options);

    foreach($entities as $entity) {
        $user = get_user($entity->guid);
        if($user){
            isegoria_add_default_widget($user->guid);
            system_message("l'utilisateur " . $user->name . " a été mis à jour!");
        }
        else {
            error_log("n'est pas un utilisateur valide");
        }
    }

    forward(REFERER);
