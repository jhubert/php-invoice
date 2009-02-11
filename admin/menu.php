<?
/***************************************************************************
					menu.php
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

$param = isset($_GET['param']) ? $_GET['param'] : 'invoiceid' ;
$invoiceID = isset($_GET['id']) ? $_GET['id'] : 0;

$message = '';

$tpl = & new TemplateSystem();

$tpl->set('page_title','Invoices');

$tpl->set('SYSTEM',$SYSTEM);

if (!isAdmin($_SESSION['ses_access']))
{
    $invoices = $ISL->FetchInvoicesByClient($_SESSION['ses_client_id'],$param);

    $total = count($invoices);
   
    $tpl->set('invoices',$invoices);
    
    $tpl->set('message',$message);

    $tpl->set('total',$total);

    $tpl->set('tbody','admin/menu_client.tpl');

} else {

    // Delete Selected Invoice
    if (isset($_GET['del']) AND isset($invoiceID)) {
        $ISL->DeleteInvoice($invoiceID);

        logItem($_SESSION['ses_client_id'],$invoiceID,1,3);

        $message = "<b>Invoice deleted</b><br><br>";
    }

    if (isset($_GET['item']) & isset($_GET['value']))
        switch ($_GET['item']) {
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

    $invoices = $ISL->FetchInvoices($_SESSION['ses_client_id'],$param,$sqlVals);

    $total = 0;

    foreach($invoices as $invoice){
        $total += $invoice['total'];
    }

    $tpl->set('invoices',$invoices);

    $tpl->set('message',$message);

    $tpl->set('total',$total);

    $tpl->set('tbody','admin/menu_admin.tpl');
}

$tpl->display();

releaseConnection($db);
?>