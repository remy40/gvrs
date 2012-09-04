<?php
/**
 * Custom GV Theme style
 *
 */
?>

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

.elgg-page-default {
	width: 100%;
}


/****************************************
	TOPBAR DROPDOWN MENU
****************************************/

.elgg-child-menu {
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

li:hover > .elgg-child-menu {
display: block;
}

.elgg-child-menu a {
background-color: #333;
color: #eee;
border-bottom: 1px solid #000;
font-weight: bold;
height: 22px;
padding-bottom: 0;
padding-left: 6px;
padding-top: 4px;
}

.elgg-child-menu a:hover {
text-decoration: none;
color: #4690D6;
background-color: #2a2a2a;
}
