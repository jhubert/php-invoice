<?
/***************************************************************************
					payments.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Edit/Add a client. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : 0;
$invoiceID = isset($_REQUEST['iid']) ? $_REQUEST['iid'] : 0;

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_payments']);

if(isset($_POST['submit']))
{
    $ISL->InsertPayment($_POST['cid'],$_POST['invoiceid'],$_POST['amount'],$_POST['method']);

    $ISL->Insertinvoiceitem($_POST['invoiceid'],$lang['ii_payment_received'],'-'.$_POST['amount'],1);
 
    $tpl->set('message',sprintf($lang['payment_added'],SITE_ROOT.'admin/payments.php'));

    $tpl->set('tbody','action_complete.tpl');

} else {

    $tpl->set('tbody','admin/add_payment.tpl');

    if (!$invoiceID) {
        if (!$clientID) {
            $clients = $ISL->FetchClientList();
            $tpl->set('clients',$clients);
        } else {
            $tpl->set('client',$ISL->FetchClientCompany($clientID));
            $invoices = $ISL->FetchInvoiceList($clientID);
            $tpl->set('invoices',$invoices);
        }
        $tpl->set('clientID',$clientID);
    } else {
        $clientID = $ISL->FetchInvoiceClient($invoiceID);
        $client = $ISL->FetchClientCompany($clientID);
        $tpl->set('clientID',$clientID);
        $tpl->set('client',$client);
        $tpl->set('invoiceid',$invoiceID);
        $tpl->set('invoice_num',$ISL->FetchInvoiceNum($invoiceID));
    }

}

$tpl->display();
?>