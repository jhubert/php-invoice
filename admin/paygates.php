<?
/***************************************************************************
					preferences.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Modifies the preferences of the system. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');
require_once(SITE_ROOT . 'includes/lib/class.TypicalConfig.php');
$message = '';

$TC = new TypicalConfig(SITE_ROOT . 'includes/config.php');
$TC->loadConfig();

$paygates = $ISL->FetchPaygates();

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
	$TC->clearValue('array','paygate');

    foreach($paygates as $key=>$paygate) {

        if (isset($_POST[$paygate['paygateid'].'_enabled'])) {
            if ($paygate['enabled'] == 'no') {
                $ISL->EnablePaygate($paygate['paygateid'],true);
                $paygates[$key]['enabled'] = 'yes';
            }
        } else {
            if ($paygate['enabled'] == 'yes') {
                $ISL->EnablePaygate($paygate['paygateid'],false);
                $paygates[$key]['enabled'] = 'no';
            }
        }
        foreach(split(',',$paygate['variables']) as $var) {
            $TC->setArray('paygate.' . $paygate['paygateid'] . '.' . $var,$_REQUEST[$paygate['paygateid'].'_'.$var]);
            $SYSTEM["paygate"][$paygate['paygateid']][$var] = $_REQUEST[$paygate['paygateid'].'_'.$var];
        }
    }

	$TC->SaveConfig();
	$message = $lang['config_saved'];
}

foreach($paygates as $key=>$paygate) {
    $paygates[$key]['values'] = $SYSTEM["paygate"][$paygate['paygateid']];
}

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_paygates']);

$tpl->set('paygates',$paygates);
$tpl->set('message',$message);

$tpl->set('tbody','admin/paygates.tpl');

$tpl->display();


?>