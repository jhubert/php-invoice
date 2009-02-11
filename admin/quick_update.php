<?
/***************************************************************************
					quick_update.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Allows for quick updating of an invoice's status. DO NOT EDIT unless 
    you know what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$invoiceID = set($_REQUEST['id'],0);
$status = isset($_REQUEST['st']) ? strtolower($_REQUEST['st']) : 0;

if (!$invoiceID)
   trigger_error('No Invoice ID Provided',E_USER_ERROR);

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['update_invoice']);

if($invoiceID and $status)
{
    $ISL->UpdateInvoiceStatus($invoiceID,$status);

    logItem($_SESSION['ses_client_id'],$invoiceID,1,2,'Satus changed to ' . $status);

    $tpl->set('message',$lang['invoice_updated']);

    $tpl->set('tbody','action_complete.tpl');
} else {
    $tpl->set('message',$lang['no_status']);

    $tpl->set('tbody','action_complete.tpl');
}

$tpl->display('simple_framework.tpl');
?>