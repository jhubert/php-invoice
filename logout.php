<?
/***************************************************************************
					logout.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Logs the user out.  Destroys the session. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
session_start();
session_destroy();
header("Location: " . SITE_ROOT . "index.php");
?>
