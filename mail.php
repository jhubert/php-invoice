<?
/***************************************************************************
  mail.php
  ------------
  product     : PHP Invoice
  version     : 1.0 build 1 (Beta)
  released    : Sunday September 7 2003
  copyright   : Copyright &copy; 2001-2009 Jeremy Hubert
  email       : support@illanti.com
  website     : http://www.illanti.com

    Sends the invoice to the client via e-mail. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

$passed = true;

if (!$invoiceID) {
  define('SITE_ROOT','./');
  require_once(SITE_ROOT . 'includes/common.php');

  securePage('admin');

  $invoiceID = isset($_GET['id']) ? $_GET['id'] : 0;

  $passed = false;
} 

if ($invoiceID) {
  $invoice = $ISL->FetchInvoiceDetails($invoiceID);

  $client = $ISL->FetchClientDetails($invoice['clientid']);

  $admin = $ISL->FetchAdminDetails($client['parentclientid']);

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

  $emailSendID = $ISL->addEmailSend($invoice['clientid'],$invoiceID,$client['email'],1);

  $e = new Emailer();
  $e->setMainFile('forms/email_invoice.tpl');
  $e->setFrom($SYSTEM['email']['from']);
  $e->setFromName($SYSTEM['email']['fromName']);
  $e->setSubject($lang['eml_subj_invoice']);

  $e->set('SYSTEM', $SYSTEM);
  $e->set('invoice', $invoice);
  $e->set('client', $client);
  $e->set('admin', $admin);
  $ispayed = (strtolower($invoice['curr_status']) == 'fully paid') ? true : false;
  $e->set('ispayed',$ispayed);
  
  $e->fetchMessage();
  $e->appendMessage('<img src="' . HTTP_ROOT . 'isop.php?sid=' . $emailSendID . '" width="1" height="1">');
  $e->setRecipient($client['email']);
  $e->setPriority('High');
  $result = $e->send();
  unset($e);

  $result = ($result) ? 'Successful' : 'Failed';

  if ($invoice['curr_status'] == 'unsent')
    $ISL->UpdateInvoiceStatus($invoiceID,'pending');

  logItem($_SESSION['ses_client_id'],$invoiceID,1,5,$client['email'] . ": " . $result);

  if (!$passed) echo "Mail to " . $client['email'] . ".<br>Status: " . $result;
} else {
  if (!$passed) echo "No invoice ID provided.";
}

if (!$passed) exit;

?>