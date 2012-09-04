<?php
    $form_body = "<div>";
    $form_body .= "<p>" . elgg_echo('gvisegoria:update_old_users:explanation') . "</p>";
    $form_body .= elgg_view('input/submit', array('value' => elgg_echo('gvisegoria:update_old_users')));
    $form_body .= "</div>";

    echo $form_body;
