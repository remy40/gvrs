<?php

$content = elgg_get_plugin_setting('website_description', 'gvtheme');
$thumbnail_link = elgg_get_plugin_setting('website_thumbnail', 'gvtheme');;

// add description
echo "<meta name='description' content='$content'></meta>";

// add a thumbnail for facebook (image 200x200)
echo "<link href='$thumbnail_link' rel='image_src'</link>";
