<?
/***************************************************************************
					edit_invoice.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Allows you to add/edit an invoice. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$invoiceID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$clientID = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : 0;

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_edit_invoice']);

$isnew = isset($_POST['isnew']) ? $_POST['isnew'] : ($invoiceID ? 0 : 1);

$submit = false;

if (isset($_POST['posted'])){

    if (!$invoiceID) {

        $invoiceID = $ISL->InsertInvoice($_POST);

//        $_POST['invoice_num'] = $invoiceID;

        logItem($_SESSION['ses_client_id'],$invoiceID,1,1);

    }

    if(isset($_POST['addNewItem']))
    {
        
        $iid = $ISL->InsertInvoiceItem($_POST['newItemDetails'],$_POST['newItemCost']);

        $ISL->AddItemToInvoice($iid,$invoiceID,$_POST['newItemQty']);

        $ISL->UpdateInvoice($invoiceID,$_POST);

        $submit = false;

    } elseif(isset($_POST['delItems'])) {
    
        foreach($_POST['delItem'] as $itemID) {
            $ISL->RemoveItemFromInvoice($itemID,$invoiceID);
            $ISL->DeleteInvoiceItem($itemID);
        }

        $ISL->UpdateInvoice($invoiceID,$_POST);

        $submit = false;
    
    } elseif(isset($_POST['submit'])) {

        $ISL->UpdateInvoice($invoiceID,$_POST);

        $edit_reason = isset($_POST['reason']) ? $_POST['reason'] : 'No Reason';

		// check for action
		switch ($_POST['invoice_action']) {
			case 'send_inv':
				// send invoice
                include(SITE_ROOT . 'mail.php');

				break;
			case 'send_not':
				// send notice to user to login
				$invoice = $ISL->FetchInvoiceDetails($invoiceID);
				$client = $ISL->FetchClientDetails($invoice['clientid']);
                $admin = $ISL->FetchAdminDetails($client['parentclientid']);

                $emailSendID = $ISL->addEmailSend($invoice['clientid'],0,$client['email'],4);

				$e = new Emailer();
                $e->setMainFile('forms/email_newinvoice.tpl');
                $e->setFrom($SYSTEM['email']['from']);
                $e->setFromName($SYSTEM['email']['fromName']);
                $e->setSubject($lang['eml_subj_invoice']);

				$e->set('SYSTEM', $SYSTEM);
				$e->set('invoice', $invoice);
				$e->set('client', $client);
				$e->set('admin', $admin);
                
                $e->fetchMessage();
                $e->appendMessage('<img src="' . HTTP_ROOT . 'isop.php?sid=' . $emailSendID . '" width="1" height="1">');
                $e->setRecipient($client['email']);
                $e->setPriority('high');
                $e->send();

				unset($e);

				break;
			case 'mark':
				$status = "Fully Paid";
				$ISL->UpdateInvoiceStatus($invoiceID,$status);
				logItem($_SESSION['ses_client_id'],$invoiceID,1,2,'Status changed to ' . $status);
				break;
			default:
				//do nothing
				break;
		}

        if (!$isnew) {
            logItem($_SESSION['ses_client_id'],$invoiceID,1,2,$edit_reason);
            $tpl->set('message',sprintf($lang['invoice_updated'],'invoices.php'));
        } else
            $tpl->set('message',sprintf($lang['invoice_added'],'invoices.php'));

        $tpl->set('tbody','action_complete.tpl');

        $submit = true;
    }
}

if (!$submit) {

    if ($invoiceID) {
        $invoice = $ISL->FetchInvoiceDetails($invoiceID);
        $invoice['issue_date'] = date('m/d/Y',$invoice['issue_date']);
        $invoice['due_date'] = date('m/d/Y',$invoice['due_date']);
    } elseif($clientID)  {
        $client = $ISL->FetchClientDetails($clientID);

        $admin = $ISL->FetchAdminDetails($client['parentclientid']);      

        $term_days = (($client['term_days'])?$client['term_days']:$admin['term_days']);

        $invoice = array(
            'clientid'=>$clientID,
            'issue_date'=>date('m/d/Y'),
            'due_date'=>date('m/d/Y',strtotime("+ " . $term_days . " days")),
            'tax'=>($client['def_tax']!='')?$client['def_tax']:$admin['def_tax'],
            'tax2'=>($client['def_tax2']!='')?$client['def_tax2']:$admin['def_tax2'],
            'terms'=>(($client['def_terms'])?$client['def_terms']:$admin['def_terms']),
            'comments'=>(($client['def_comments'])?$client['def_comments']:$admin['def_comments']),
            'items'=>array(),
            'invoice_num'=>'',
            'cost'=>'0.00',
            'shipping'=>'0.00'
            );

    } else {
        $admin = $ISL->FetchAdminDetails($_SESSION['ses_client_id']);      

        $term_days = $admin['term_days'];

        $invoice = array(
            'issue_date'=>date('m/d/Y'),
            'due_date'=>date('m/d/Y',strtotime("+ " . $term_days . " days")),
            'tax'=>$admin['def_tax'],
            'tax2'=>$admin['def_tax2'],
            'terms'=>$admin['def_terms'],
            'comments'=>$admin['def_comments'],
            'items'=>array(),
            'invoice_num'=>'',
            'cost'=>'0.00',
            'shipping'=>'0.00'
            );
    }
    
    $clients = $ISL->FetchClientList();

    $tpl->set('invoiceID',$invoiceID);
    $tpl->set('invoiceStatus',$invoiceStatus);
    $tpl->set('clients',$clients);
    $tpl->set('invoice',$invoice);
    $tpl->set('SYSTEM',$SYSTEM);
    $tpl->set('isnew',$isnew);

    $tpl->set('tbody','admin/edit_invoice.tpl');
}

$tpl->display();
?>