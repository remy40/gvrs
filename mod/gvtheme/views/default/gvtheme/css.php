<?php
/**
 * Custom GV Theme style
 *
 */
?>

#widgets-reinitialize {
	margin-right: 10px;
}

/***************************
 ICONS
****************************/

.elgg-icon-thumbs-down {
	background-position: 0 -864px;
}

.elgg-icon-thumbs-down-alt:hover {
	background-position: 0 -864px;
}
.elgg-icon-thumbs-down:hover,
.elgg-icon-thumbs-down-alt {
	background-position: 0 -864px;
}

.elgg-icon-thumbs-up {
	background-position: 0 -882px;
}

.elgg-icon-thumbs-up-alt:hover {
	background-position: 0 -882px;
}
.elgg-icon-thumbs-up:hover,
.elgg-icon-thumbs-up-alt {
	background-position: 0 -882px;
}

.elgg-icon-friends {
	background-position: 0 -1494px;
}

.elgg-icon-group-open {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/gvtheme/icons/group-open.png) no-repeat left;
	width: 18px;
	height: 18px;
	margin: 0 2px;
}

.elgg-icon-group-closed {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/gvtheme/icons/group-closed.png) no-repeat left;
	width: 18px;
	height: 18px;
	margin: 0 2px;
}

/****************************************
	LOGIN PAGE
****************************************/
.gvtheme-main-title {
padding-left: 10px;
padding-top: 10px;
font-family: Georgia, times, serif;
font-size: 3.6em;
font-style: italic;
text-shadow: #333333 1px 2px 4px;
color: white;    
}

.gvtheme-tagline {
padding-left: 10px;
font-family: Georgia, times, serif;
font-size: 1.4em;
font-style: italic;
text-shadow: #333333 1px 2px 4px;
color: white;
}

.gvtheme-header-wrapper {
height: 100px;
background: #4690D6 url(<?php echo elgg_get_site_url(); ?>_graphics/header_shadow.png) repeat-x bottom left;
}

.elgg-form-login {
padding: 15px;
width: 50%;
margin: auto;
border-color: black;
border: 1px;
}

/****************************************
	PAGE LAYOUT
****************************************/

.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 100%;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	width: 100%;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 100%;
	padding: 0;
}

/****************************************
	TOPBAR MENU ITEMS
****************************************/

.elgg-menu-topbar > li > a.elgg-topbar-avatar {
  height:18px;
  width: 100%;
}

/****************************************
	TOPBAR DROPDOWN MENUS
****************************************/

.elgg-menu-topbar-child {
z-index: 10;
display: none;
position: absolute;
padding-top: 4px;
width: 150px;
-webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
-moz-box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
opacity: 0.95;
}

li:hover > .elgg-menu-topbar-child {
display: block;
}

/**** TOPBAR DROPDOWN MENU ****/

.gvtheme-profile-child-menu a {
background-color: #333;
color: #eee;
border-bottom: 1px solid #000;
font-weight: bold;
height: 22px;
padding-bottom: 0;
padding-left: 6px;
padding-top: 4px;
}

.gvtheme-profile-child-menu a:hover {
text-decoration: none;
color: #4690D6;
background-color: #2a2a2a;
}

/*** SITE DROPDOWN MENU ****/

.gvgroup-child-menu a {
color: #0046A9;
font-weight: bold;
height: 22px;
padding-bottom: 0;
padding-left: 6px;
}

.gvgroup-child-menu a:hover {
text-decoration: none;
color: #FFF;
background-color: #0046A9;
}

/********************************
 LIKE / DISLIKE ITEMS
********************************/
.elgg-menu-item-likes-count > a {
	font-weight: bold;
	color: #23aa00;
}

.elgg-menu-item-dislikes-count > a {
	font-weight: bold;
	color: #dd0000;
}
