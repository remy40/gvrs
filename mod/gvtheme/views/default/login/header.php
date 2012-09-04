<?php
/**
* Header view
*/
$site = elgg_get_site_entity();
$title = $site->name;
$tagline = $site->description;
echo "<div class=\"gvtheme-header-wrapper\">";
echo "<h1 class=\"gvtheme-main-title\"> $title </h1>";
echo "<h3 class=\"gvtheme-tagline\">$tagline</h3>";
echo "</div>";
