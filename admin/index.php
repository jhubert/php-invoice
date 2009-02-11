<?
/***************************************************************************
					index.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    The starting point for the software. Login page. DO NOT EDIT unless 
    you know what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('client');

$tpl = & new TemplateSystem();


$notes = $ISL->GetUserNotes($_SESSION['ses_client_id']);
$stats = $ISL->AdminStats();

$tpl->set('stats',$stats);
$tpl->set('notes',$notes);
$tpl->set('page_title',$lang['pt_index']);


$tpl->set('tbody','admin/index.tpl');

$tpl->display();
exit;
?>