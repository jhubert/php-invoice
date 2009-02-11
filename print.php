<?php
/***************************************************************************
  print.php
  ------------
  product     : PHP Invoice
  version     : 1.0 build 1 (Beta)
  released    : Sunday September 7 2003
  copyright   : Copyright &copy; 2001-2009 Jeremy Hubert
  email     : support@illanti.com
  website     : http://www.illanti.com

  Automatically loads the invoice in the page with no other data for a
  clean print. DO NOT EDIT unless you know what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

securePage('client');

$invoiceID = isset($_GET['id']) ? $_GET['id'] : 0;

if ($invoiceID) {
  $invoice = $ISL->FetchInvoiceDetails($invoiceID);

  if (!is_array($invoice))
    message_die($lang['invalid_invoice']);

  $client = $ISL->FetchClientDetails($invoice['clientid']);

  if (($client['clientid'] == $_SESSION['ses_client_id']) or (isAdmin($_SESSION['ses_access']))) {
    $admin = $ISL->FetchAdminDetails($client['parentclientid']);

    $tpl = & new TemplateSystem();

    $invoice['show_tax'] = $invoice['calc_tax'] > 0 ? true : false;
    $invoice['show_tax2'] = $invoice['calc_tax2'] > 0 ? true : false;
    $invoice['show_shipping'] = $invoice['shipping'] > 0 ? true : false;
    $invoice['terms'] = ($invoice['terms'] ? $invoice['terms'] : ($client['def_terms'] ? $client['def_terms'] : ($admin['def_terms'] ? $admin['def_terms'] : $lang['terms'])));
    $invoice['comments'] = ($invoice['comments'] ? $invoice['comments'] : ($client['def_comments'] ? $client['def_comments'] : ($admin['def_comments'] ? $admin['def_comments'] : '')));
    $invoice['due_date'] = date($SYSTEM["regional"]["invoicedate"],$invoice['due_date']);
    $invoice['issue_date'] = date($SYSTEM["regional"]["invoicedate"],$invoice['issue_date']);
    $invoice['calc_tax'] = currency_format($invoice['calc_tax']);
    $invoice['calc_tax2'] = currency_format($invoice['calc_tax2']);
    $invoice['shipping'] = currency_format($invoice['shipping']);
    $invoice['cost'] = currency_format($invoice['cost']);
    $invoice['total'] = currency_format($invoice['total']);

    $tpl->setMainFile('print.tpl');

    $tpl->set('SYSTEM',$SYSTEM);
    $tpl->set('invoice',$invoice);
    $tpl->set('client',$client);
    $tpl->set('admin',$admin);
    $ispayed = (strtolower($invoice['curr_status']) == 'fully paid') ? true : false;
    $tpl->set('ispayed',$ispayed);

    $tpl->set('message',$tpl->fetch("forms/email_invoice.tpl"));

    $tpl->display();
  } else {
    echo $lang['invoice_inaccessable'];
  }
} else {
  echo $lang['no_invoice'];
}
?>