<?
/***************************************************************************
					edit_client.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Edit/Add a client. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = isset($_GET['id']) ? $_GET['id'] : 0;

if (!$clientID)
    message_die($lang['no_client']);

$tpl = & new TemplateSystem();

$tpl->set('page_title','Client Details');

$tpl->set('client',$ISL->FetchClientDetails($clientID));

$tpl->set('tbody','admin/view_client.tpl');

$tpl->display();
?>