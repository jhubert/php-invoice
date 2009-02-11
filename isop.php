<?
/***************************************************************************
					isop.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Tracks when an HTML e-mail is opened, and returns a spacer to the client
    so that they don't see anything.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

$sendID = (isset($_GET['sid']) ? $_GET['sid'] : 0);

error_reporting(0);

if ($sendID)
{
    $ISL->trackEmailSendOpen($sendID);
}

header($header_location . HTTP_ROOT . 'images/spacer.gif'); 
?>