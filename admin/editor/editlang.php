<?
/***************************************************************************
					clients.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Lists the current clients in the database. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../../');
require_once(SITE_ROOT . 'includes/common.php');
require_once(SITE_ROOT . 'includes/lib/class.TypicalConfig.php');

securePage('admin');

$sel_language = isset($_REQUEST['pass_lang']) ? $_REQUEST['pass_lang'] : 0;

if (!$sel_language) 
    trigger_error($lang['valid_language'],E_USER_WARNING);

if (isset($_POST['btnSubmit'])) {
    $msg = '';

    $TC = new TypicalConfig(SITE_ROOT . 'languages/lang.' . $sel_language . '.php');

    $TC->loadConfig();
    $TC->clearValue('arr');
    $TC->setArrayName('lang');

    foreach($_POST as $key=>$val) {
        if (strpos($_POST['skip'],$key)===false) {
             $TC->setArray($key,$val);
        }
    }

    $TC->saveConfig();

    $msg .= sprintf($lang['language_updated'],SITE_ROOT.'admin/editor/index.php');
    $tpl = & new TemplateSystem();

    $tpl->set('msg',$msg);
    $tpl->set('page_title',$lang['editor']);

    $tpl->set('message',$msg);

    $tpl->set('tbody','action_complete.tpl');

    $tpl->display();
    exit;
}

$message = '';

$TC = new TypicalConfig(SITE_ROOT . 'languages/lang.' . $sel_language . '.php');

$TC->loadConfig();

$topComment = $TC->topinfo;
$langVars = $TC->getVars('arr');

unset($TC);

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['edit_language']);

$tpl->set('topinfo',$topComment);
$tpl->set('language',$sel_language);
$tpl->set('langVars',$langVars);
$tpl->set('message',$message);

$tpl->set('tbody','admin/editor/editlang.tpl');

$tpl->display();
exit;
?>