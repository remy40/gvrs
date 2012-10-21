<?php
/* Data base details */
$con = 'mysql';
$username='root';
$password='9892959303';
$client_db_name='joomla';
$host='localhost';
$driver='Joomla';
$db_prefix='ypc2k_';
$uid='506efd4b3ff4d';

$PATH = 'freichat/'; // Use this only if you have placed the freichat folder somewhere else
$installed=false;
$admin_pswd='adminpass';

$debug = false;

/* email plugin */
$smtp_username = '';
$smtp_password = '';



/* Custom driver */
$usertable='login'; //specifies the name of the table in which your user information is stored.
$row_username='root'; //specifies the name of the field in which the user's name/display name is stored.
$row_userid='loginid'; //specifies the name of the field in which the user's id is stored (usually id or userid)
$avatar_field_name = 'avatar';
