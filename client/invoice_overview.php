<?
/***************************************************************************
					invoices.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    The main page for the invoice software. Lists all invoices in the db. 
    DO NOT EDIT unless you know what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('client');

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_invoice_overview']);

$tpl->set('SYSTEM',$SYSTEM);

$invoices = $ISL->FetchInvoices();

$tpl->set('tbody','client/invoice_overview.tpl');

$count['total'] = count($invoices);

foreach($invoices as $inv) {
    $count[$inv['curr_status']]++;
    
    $totals[$inv['curr_status']]['cost'] += $inv['cost'];
    $totals[$inv['curr_status']]['tax'] += $inv['tax'];
    $totals[$inv['curr_status']]['tax2'] += $inv['tax2'];
    $totals[$inv['curr_status']]['total'] += ($inv['cost'] + $inv['tax'] + $inv['tax2'] + $inv['shipping']);
}

$tpl->set('invoices',$invoices);

$tpl->set('count',$count);
$tpl->set('totals',$totals);

$tpl->display();

releaseConnection($db);
?>