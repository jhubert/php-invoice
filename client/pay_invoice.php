<?
/***************************************************************************
					pay_invoice.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    The intro page for the pay area. Not complete. DO NOT EDIT unless you 
    know what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('client');

$invoiceID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$invoice = $ISL->FetchInvoiceDetails($invoiceID);

$client = $ISL->FetchClientDetails($invoice['clientid']);

$invoice['total'] = number_format($invoice['total'], 2, '.', ''); 

$gates = array();

$paygates = $ISL->FetchPaygates();

foreach($paygates as $paygate) {
    if ($paygate['enabled'] == 'yes') {
        $tpl_pg = & new TemplateSystem();
        $tpl_pg->set('values',$SYSTEM['paygate'][$paygate['paygateid']]);
        $tpl_pg->set('invoice',$invoice);
        $tpl_pg->set('client',$client);
        $tpl_pg->setMainFile('paygates/' . $paygate['tplfile']);
        $gates[$paygate['company']] = $tpl_pg->fetch();
        unset($tpl_pg);
    }
}


$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_pay_invoice']);

$tpl->set('gates',$gates);
$tpl->set('SYSTEM',$SYSTEM);
$tpl->set('invoice',$invoice);
$tpl->set('client',$client);

$tpl->set('tbody','client/pay_invoice.tpl');

$tpl->display();
?>