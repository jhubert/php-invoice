<?
/***************************************************************************
					payments.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Edit/Add a client. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : 0;

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_payments']);
$tpl->set('clientID',$clientID);

if (isset($_GET['delete'])) {

    $paymentID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
    
    if ($paymentID) {
        $ISL->DeletePayment($paymentID);
        $tpl->set('message',$lang['payment_deleted']);
    }
}

if ($clientID)
    $client = $ISL->FetchClientDetails($clientID);
else
    $client = array();

$payments = $ISL->GetPayments($clientID);

foreach($payments as $key=>$payment) {
    $payments[$key]['made_on'] = date($SYSTEM["regional"]["datetime"],$payment['made_on']);
}

$tpl->set('client',$client);
$tpl->set('payments',$payments);

$tpl->set('tbody','admin/payments.tpl');

$tpl->display();
?>