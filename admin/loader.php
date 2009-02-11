<?
/***************************************************************************
					mail.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Sends the invoice to the client via e-mail. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

if (isset($_GET['f'])) {
    $file = $_GET['f'];   
} else {
    trigger_error("No Template File Specified",E_USER_WARNING);
    die();
}

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_' . str_replace(".tpl","",$file)]);

$tpl->set('tbody','admin/'.$file . ".tpl");

$tpl->display();

releaseConnection($db);
?>