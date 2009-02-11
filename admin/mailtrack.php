<?
/***************************************************************************
					mail.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Sends the invoice to the client via e-mail. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = isset($_GET['cid']) ? $_GET['cid'] : 0;
$invoiceID = isset($_GET['id']) ? $_GET['id'] : 0;

$send_history = $ISL->getEmailSendHistory($clientID);

$tpl = & new TemplateSystem();

foreach($send_history as $key=>$item) {
    $send_history[$key]['type'] = $emailType[$item['sendtype']];
    $send_history[$key]['datesent'] = date($SYSTEM["regional"]["datetime"],$item['datesent']);
    $send_history[$key]['firstopened'] = ($item['firstopened']) ? date($SYSTEM["regional"]["datetime"],$item['firstopened']) : $lang['never'];
    $send_history[$key]['lastopened'] = ($item['firstopened']) ? date($SYSTEM["regional"]["datetime"],$item['lastopened']) : $lang['never'];
}

$tpl->set('page_title',$lang['pt_mailtrack']);

$tpl->set('tbody','admin/mailtrack.tpl');

$tpl->set('history',$send_history);
$tpl->set('message','');

$tpl->display();

releaseConnection($db);
?>