<?php
/*
function quickAdd() {

}

Things to quick add:
Client
Invoice
InvoiceItem
All 3

Client cl_
---------
username
password
company
address
tax
tax2

Invoice iv_
---------
invoiceid
clientid
InvoiceItems (InvoiceItemID, Qty)
due_date
issue_date
shipping

InvoiceItem ii_
------------
details
cost

*/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$message = '';

if (isset($_POST['Submit'])) {

  $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 0;

  $value_cl = array();
  $value_iv = array();
  $value_ii = array();

  foreach($_POST as $key=>$val) {
    $tmpval = explode('_',$key,2); 
    ${'value_'.$tmpval[0]}[$tmpval[1]] = $val;
  }

  $admin = $ISL->fetchAdminDetails($_SESSION['ses_client_id']);

    switch($mode) {
    case 'client':
      if (!isset($value_cl['username'])) $message[] = $lang['req_username'];
      if (!isset($value_cl['passwd'])) $value_cl['passwd'] = $value_cl['username'];
      if (!isset($value_cl['company'])) $value_cl['company'] = $value_cl['username'];
      if (!isset($value_cl['tax'])) $value_cl['tax'] = $admin['def_tax'];
      if (!isset($value_cl['tax2'])) $value_cl['tax2'] = $admin['def_tax2'];
      if (!isset($value_cl['address'])) $value_cl['address'] = '';
            $value_cl['parentclientid'] = $_SESSION['ses_client_id'];

      $ISL->InsertClient($value_cl);
    break;
    case 'invoice':

      if (!isset($value_iv['invoiceid'])) $value_iv['invoiceid'] = $ISL->FetchNewInvoiceID;
      if (!isset($value_iv['clientid'])) $message[] = $lang['req_client'];
      if (!isset($value_iv['invoiceitems']) && !isset($value_iv['new_invoiceitems'])) $message[] = $lang['req_invoiceitems'];

      $client = $ISL->fetchClientDetails($value_iv['clientid']);

      if (!isset($value_iv['due_date'])) $value_iv['due_date'] = date('m/d/y',time());
      if (!isset($value_iv['issue_date'])) $value_iv['issue_date'] = date('m/d/y',strtotime(' + ' . $client['term_days'] . ' days'));
      if (!isset($value_iv['shipping'])) $value_iv['shipping'] = 0;
      if (!isset($value_iv['curr_status'])) $value_iv['curr_status'] = 'unsent';

           if (!count($message)) {

                $invoiceID = $ISL->InsertInvoice($value_iv);
                
                if (count($value_ii['new_invoiceitems'])) {
                    foreach($value_ii['new_invoiceitems'] as $key=>$item) {
                        $item['id'] = $ISL->InsertInvoiceItem($item['details'],$item['cost']);
                        $ISL->AddItemToInvoice($item['id'],$invoiceID,$item['qty']);
                    }
                }
                if (count($value_ii['invoiceitems'])) {
                    echo "Hello";
                    foreach($value_ii['invoiceitems'] as $key=>$item)   {                  
                        $ISL->AddItemToInvoice($item['id'],$invoiceid,$item['qty']);
                    }
                }
            } else {
                trigger_error(implode("<br>",$message),E_USER_WARNING);
            }
    break;
    case 'invoiceitem':
      if (!isset($value_ii['invoiceitems']) && !isset($value_ii['new_invoiceitems'])) $message[] = $lang['req_invoiceitems'];

            foreach($value_ii['new_invoiceitems'] as $key=>$item) {
                $ISL->InsertInvoiceItem($item['details'],$item['cost']);
            }
    break;
    case 'all':
            if (!isset($value_cl['username'])) $message[] = $lang['req_username'];
      if (!isset($value_cl['password'])) $value_cl['password'] = $value_cl['username'];
      if (!isset($value_cl['company'])) $value_cl['company'] = $value_cl['username'];
      if (!isset($value_cl['tax'])) $value_cl['tax'] = $admin['def_tax'];
      if (!isset($value_cl['tax2'])) $value_cl['tax2'] = $admin['def_tax2'];
      if (!isset($value_cl['address'])) $value_cl['address'] = '';
            if (!isset($value_cl['access'])) $value_cl['access'] = 'client';
            if (!isset($value_cl['language'])) $value_cl['language'] = 'english'; 
            if (!isset($value_cl['visible'])) $value_cl['visible'] = '1';
            
            $value_cl['parentclientid'] = $_SESSION['ses_client_id'];

      $value_iv['clientid'] = $ISL->InsertClient($value_cl);

      if (!isset($value_iv['invoiceid'])) $value_iv['invoiceid'] = $ISL->FetchNewInvoiceID;
      if (!isset($value_iv['clientid'])) $message[] = $lang['req_client'];
      if (!isset($value_iv['invoiceitems']) && !isset($value_iv['new_invoiceitems'])) $message[] = $lang['req_invoiceitems'];

      $client = $ISL->FetchClientDetails($value_iv['clientid']);

      if (!isset($value_iv['due_date'])) $value_iv['due_date'] = date('m/d/y',time());
      if (!isset($value_iv['issue_date'])) $value_iv['issue_date'] = date('m/d/y',strtotime(' + ' . $client['term_days'] . ' days'));
      if (!isset($value_iv['shipping'])) $value_iv['shipping'] = 0;
      if (!isset($value_iv['curr_status'])) $value_iv['curr_status'] = 'unsent';

           if (!count($message)) {

                $invoiceID = $ISL->InsertInvoice($value_iv);
                
                if (count($value_ii['new_invoiceitems'])) {
                    echo "Hello There";
                    foreach($value_ii['new_invoiceitems'] as $key=>$item) {
                        $item['id'] = $ISL->InsertInvoiceItem($item['details'],$item['cost']);
                        $ISL->AddItemToInvoice($item['id'],$invoiceID,$item['qty']);
                    }
                }
                if (count($value_ii['invoiceitems'])) {
                    echo "Hello";
                    foreach($value_ii['invoiceitems'] as $key=>$item)   {                  
                        $ISL->AddItemToInvoice($item['id'],$invoiceid,$item['qty']);
                    }
                }
            } else {
                trigger_error(implode("<br>",$message),E_USER_WARNING);
            }
    break;
    default:
      trigger_error($lang['invalid_mode'],E_USER_WARNING);
    break;
  }
}

exit;
?>