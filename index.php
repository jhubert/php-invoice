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

    Login page. DO NOT EDIT unless 
    you know what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

if (isset($_SESSION['ses_client_id'])) 
{
    header("Location: " . SITE_ROOT . $_SESSION['ses_access'] . "/index.php");
    exit;
}

securePage('none');

$tpl_main_file = 'login_framework.tpl';

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['log_in']);
$tpl->set('toptext',$lang['pleaselogin']);
$tpl->set('bottomtext','<a href="' . SITE_ROOT .'forgotpass.php">' . $lang['forgot_password'] . '</a>');
$tpl->set('tbody','login.tpl');

$tpl->display();
exit;
?>