<?php
    $form_body = "<div>";
    $form_body .= "<p>" . elgg_echo('gvgroups:createfields:explanation') . "</p>";
    $form_body .= elgg_view('input/submit', array('value' => elgg_echo('gvgroups:createfields')));
    $form_body .= "</div>";

    echo $form_body;
