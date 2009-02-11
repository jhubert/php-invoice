<?
/***************************************************************************
					invoices.php
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

securePage('admin');

$param = isset($_GET['param']) ? $_GET['param'] : 'invoice_num' ;
$invoiceID = isset($_GET['id']) ? $_GET['id'] : 0;

$item = isset($_GET['item']) ? $_GET['item'] : 0;
$value = isset($_GET['value']) ? $_GET['value'] : 0;
$search = isset($_GET['search']) ? $_GET['search'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : 0;

$message = '';

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_invoices']);

$tpl->set('SYSTEM',$SYSTEM);

// Delete Selected Invoice

if ( isset($_GET['del']) && isset($_GET['id']) )
{
    $inv = $ISL->FetchInvoiceDetails($_GET['id']);

    if ($inv['curr_status'] == 'unsent') {
        $ISL->DeleteInvoice($_GET['id'],false);

        $message = $lang['invoice_deleted'];
    } else {
        $ISL->DeleteInvoice($_GET['id']);

        $message = $lang['invoice_set_void'];
    }
    logItem($_SESSION['ses_client_id'],$invoiceID,1,3);
}

if ($item & $value)
    if ($search) {
        switch ($item) {
            case 'invoice_num':
                $sqlVals = 'i.invoice_num LIKE "%' . $_GET['value'] . '%"';
            break;
            case 'client':
                $sqlVals = 'i.clientID LIKE "%' . $_GET['value'] . '%"';
            break;
            case 'month':
                $sqlVals = "month(i.due_date)=month('" . date('Y-m-d',strtotime($_GET['value'])) . "') AND year(i.due_date)=year('" . date('Y-m-d',strtotime($_GET['value'])) . "')";
            break;
            case 'year':
                $sqlVals = "year(i.due_date)=year('" . date('Y-m-d',strtotime($_GET['value'])) . "')";
            break;
            case 'status':
                $sqlVals = "curr_status='" . $_GET['value'] . "'";
            break;
            default:
                $sqlVals = 1;
            break;
        }
    } else {
        switch ($item) {
            case 'client':
                $sqlVals = 'i.clientID=' . $_GET['value'];
            break;
            case 'month':
                $sqlVals = "month(i.due_date)=month('" . date('Y-m-d',strtotime($_GET['value'])) . "') AND year(i.due_date)=year('" . date('Y-m-d',strtotime($_GET['value'])) . "')";
            break;
            case 'year':
                $sqlVals = "year(i.due_date)=year('" . date('Y-m-d',strtotime($_GET['value'])) . "')";
            break;
            case 'status':
                $sqlVals = "curr_status='" . $_GET['value'] . "'";
            break;
            default:
                $sqlVals = 1;
            break;
        }
    }
else 
    $sqlVals = 1;

$invoices = $ISL->FetchInvoices($page,$param,$sqlVals);

$tpl->set('tbody','admin/invoices.tpl');


$totals['invoices'] = count($invoices);
$totals['tax'] = 0;
$totals['tax2'] = 0;
$totals['shipping'] = 0;
$totals['cost'] = 0;

foreach($invoices as $key=>$inv) {
    $totals['tax'] += $inv['tax'];
    $totals['tax2'] += $inv['tax2'];
    $totals['shipping'] += $inv['shipping'];
    $totals['cost'] += $inv['cost'];
    $invoices[$key]['issue_date'] = date($SYSTEM["regional"]["invoicedate"],$invoices[$key]['issue_date']);
    $invoices[$key]['due_date'] = date($SYSTEM["regional"]["invoicedate"],$invoices[$key]['due_date']);
    $invoices[$key]['tax'] = currency_format($inv['tax']);
    $invoices[$key]['tax2'] = currency_format($inv['tax2']);
    $invoices[$key]['shipping'] = currency_format($inv['shipping']);
    $invoices[$key]['cost'] = currency_format($inv['cost']);
    $invoices[$key]['total'] = currency_format($inv['total']);
}
$totals['total'] = $totals['cost'] + $totals['tax'] + $totals['tax2'] + $totals['shipping']; 

$totals['cost'] = currency_format($totals['cost']);
$totals['tax'] = currency_format($totals['tax']);
$totals['tax2'] = currency_format($totals['tax2']);
$totals['shipping'] = currency_format($totals['shipping']);
$totals['total'] = currency_format($totals['total']);

$tpl->set('item',$item);
$tpl->set('value',$value);
$tpl->set('param',$param);
$tpl->set('search',$search);

$tpl->set('invoices',$invoices);

$tpl->set('message',$message);

$tpl->set('totals',$totals);

$tpl->display();

releaseConnection($db);
?>