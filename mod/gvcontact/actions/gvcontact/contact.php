<?php

$yourname = get_input('yourname');
$yourmail = get_input('yourmail');
$category = get_input('category');
$yourmessage = get_input('yourmessage');

if (isset($yourname) && isset($yourmail) && isset($category) && isset($yourmessage)) {
     $to      = elgg_get_plugin_setting('email', 'gvcontact');
     $subject = "De $yourname - $category";
     $headers = "From: $youremail" . "\r\n" .
     "Reply-To: $youremail" . "\r\n" .
     'X-Mailer: PHP/' . phpversion();

     if (mail($to, $subject, $yourmessage, $headers)) {
         system_message('gvcontact:mail_success');
        forward('dashboard');
     }
     else {
        error_log("mail sending error");
        register_error(elgg_echo('gvcontact:mail_error'));
        set_input('yourname', $yourname);
        set_input('yourmail', $yourmail);
        set_input('category', $category);
        set_input('yourmessage', $yourmessage);
        forward('contact');
     }
}
else {
    if (!isset($yourname)) {
        register_error(elgg_echo('gvcontact:yourname_error'));
    }
    if (!isset($yourmail)) {
        register_error(elgg_echo('gvcontact:yourmail_error'));
    }
    if (!isset($category)) {
        register_error(elgg_echo('gvcontact:category_error'));
    }
    if (!isset($yourmessage)) {
        register_error(elgg_echo('gvcontact:yourmessage_error'));
    }

    error_log("bad mail parameters");
    set_input('yourname', $yourname);
    set_input('yourmail', $yourmail);
    set_input('category', $category);
    set_input('yourmessage', $yourmessage);
    forward('contact');
}
