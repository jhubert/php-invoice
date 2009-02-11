<?
/***************************************************************************
					preferences.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Modifies the preferences of the system. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');
require_once(SITE_ROOT . 'includes/lib/class.TypicalConfig.php');

$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;

$configwrite = isset($_REQUEST['configwrite']) ? $_REQUEST['configwrite'] : false;

$TC = new TypicalConfig(SITE_ROOT . 'includes/config.php');
$TC->loadConfig();
$welcome_msg = "";
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
	$TC->clearValue('array','regional');
   	$TC->clearValue('array','email');

    $TC->addConstant('HTTP_ROOT',$_REQUEST['httproot']);

	$TC->addConstant('EMAIL_ERR',$_REQUEST['email_err']);
	$TC->addConstant('DIR_ERR',$_REQUEST['dir_error']);
	$TC->addConstant('DIR_EMAIL',$_REQUEST['dir_email']);

	$TC->setArray('regional.shortdate',$_REQUEST['shortdate']);
	$TC->setArray('regional.longdate',$_REQUEST['longdate']);
	$TC->setArray('regional.invoicedate',$_REQUEST['invoicedate']);
	$TC->setArray('regional.datetime',$_REQUEST['datetime']);
	$TC->setArray('regional.timeoffset',$_REQUEST['timeoffset']);
	$TC->setArray('regional.currency_sym',$_REQUEST['currencysymbol']);
	$TC->setArray('regional.currency_txt',$_REQUEST['currencytext']);
	$TC->setArray('regional.currency_format',$_REQUEST['currencyformat']);

    $TC->setArray('email.from',$_REQUEST['fromaddress']);
    $TC->setArray('email.fromName',$_REQUEST['fromname']);

	$TC->addVariable('def_lang',$_REQUEST['deflanguage']);
	$TC->addVariable('def_template',$_REQUEST['deftemplate']);
	$TC->addVariable('invoicerpp',$_REQUEST['invoicerpp']);

	$TC->SaveConfig();
	$welcome_msg = $lang['config_saved'];
}


$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_preferences']);

$tpl->set('configvars',$TC->getVars());
$tpl->set('message',$welcome_msg);

$tpl->set('tbody','admin/preferences.tpl');

$tpl->display();


?>