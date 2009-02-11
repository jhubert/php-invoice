<?
/***************************************************************************
					menu.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    The main page for the invoice software. Lists all invoices in the db. 
    DO NOT EDIT unless you know what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('client');

$clientID = isset($_GET['cid']) ? $_GET['cid'] : 0;

$eventItems = array();
$eventItems[1] = 'Invoice Created';
$eventItems[2] = 'Invoice Updated';
$eventItems[3] = 'Invoice Deleted';
$eventItems[5] = 'Invoice Mailed';
$eventItems[6] = 'Client Created';
$eventItems[7] = 'Client Updated';
$eventItems[8] = 'Client Deleted';
$eventItems[10] = 'Logged In';
$eventItems[11] = 'Logged Out';

$logItems = $ISL->FetchLogItems_Login($clientID);

$tpl = & new TemplateSystem();

$tpl->set('page_title','View Log Items');

$tpl->set('SYSTEM',$SYSTEM);
$tpl->set('logItems',$logItems);
$tpl->set('eventItems',$eventItems);
$tpl->set('tbody','admin/viewLog.tpl');

$tpl->display();

releaseConnection($db);
?>