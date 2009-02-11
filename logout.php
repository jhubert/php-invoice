<?
/***************************************************************************
					logout.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Logs the user out.  Destroys the session. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
session_start();
session_destroy();
header("Location: " . SITE_ROOT . "index.php");
?>
