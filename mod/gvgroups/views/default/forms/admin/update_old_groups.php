<?php
    $form_body = "<div>";
    $form_body .= "<p>" . elgg_echo('gvgroups:update_old_groups:explanation') . "</p>";
    $form_body .= elgg_view('input/submit', array('value' => elgg_echo('gvgroups:update_old_groups')));
    $form_body .= "</div>";

    echo $form_body;
