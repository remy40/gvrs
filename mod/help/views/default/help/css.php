<?php
/**
 * CSS for help pages
 *
 * 2 parts:
 * Help object - display single topic
 * Help categories - grid of categories
 * 
 */

?>
/************************* begin help *****************************/

.help-table-of-contents-container {
	border:1px solid #CCCCCC;
	background-color: #F8F8F8;
	padding: 5px;
}

#help-table-of-contents-title {
	display:block;
	text-align: center;
}

/*** Help object ***/
.help-list, .help-list > li {
	border: none;
}

/*** Help categories ***/
.help-categories li {
	float: left;
	margin: 0 30px 30px 0;
}
/* this makes it 3 across - remove to make it two across */
.help-categories > li:nth-child(3n+3) {
	margin-right: 0;
}
.help-category {
	float: left;
	display: block;
	width: 252px;
	height: 252px;
	padding: 20px;
	border: 1px solid #cccccc;
	background-color: #f8f8f8;
}
.help-category:hover {
	text-decoration: none;
	background: none;
}
.help-category span {
	display: block;
	margin-top: 4px;
	color: #4690D6;
}

.mbl h2 {
	border-bottom: 1px solid #cccccc;
}

/**************************** end help ****************************/
