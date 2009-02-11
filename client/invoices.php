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

if ($item & $value)
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
else 
    $sqlVals = 1;

$invoices = $ISL->FetchInvoicesByClient($_SESSION['ses_client_id'],$param,$sqlVals);

$tpl->set('tbody','client/invoices.tpl');

foreach($invoices as $key=>$inv) {
    $invoices[$key]['issue_date'] = date($SYSTEM["regional"]["invoicedate"],$invoices[$key]['issue_date']);
    $invoices[$key]['due_date'] = date($SYSTEM["regional"]["invoicedate"],$invoices[$key]['due_date']);
    $invoices[$key]['tax'] = currency_format($inv['tax']);
    $invoices[$key]['tax2'] = currency_format($inv['tax2']);
    $invoices[$key]['shipping'] = currency_format($inv['shipping']);
    $invoices[$key]['cost'] = currency_format($inv['cost']);
    $invoices[$key]['total'] = currency_format($inv['total']);
    $invoices[$key]['pay'] = (strtolower($inv['curr_status']) == 'fully paid') ? false : true;
}

$tpl->set('item',$item);
$tpl->set('value',$value);
$tpl->set('search',$search);

$tpl->set('invoices',$invoices);

$tpl->set('message',$message);

$tpl->display();

releaseConnection($db);
?>