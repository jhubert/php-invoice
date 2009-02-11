<?
/***************************************************************************
					index.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    The starting point for the software. Login page. DO NOT EDIT unless 
    you know what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

securePage('none');

$tpl_main_file = 'login_framework.tpl';

$tpl = & new TemplateSystem();

if (isset($_POST['btnSubmit'])) {
    if ($_POST['email'] != '') {
        $method = 'email';
        $value = $_POST['email'];
    } elseif ($_POST['username'] != '') {
        $method = 'username';
        $value = $_POST['username'];
    }
    $client = $ISL->recoverPassword($method,$value);

    if (is_array($client)) {
        
        $e = new Emailer();
        $e->setMainFile('forms/email_forgotpass.tpl');
        $e->setFrom($SYSTEM['email']['from']);
        $e->setFromName($SYSTEM['email']['fromName']);
        $e->setSubject($lang['eml_subj_forgotpass']);

        $e->set('client', $client);

        $e->fetchMessage();
        $e->setRecipient($client['email']);
        $e->setPriority('High');
        $e->send();
        unset($e);

    } else {
        trigger_error($lang['no_client_found'],E_USER_WARNING);
        die();
    }
    $tpl->set('tbody','forgotpass_sent.tpl');
    $tpl->set('message',sprintf($lang['password_sent'],'index.php'));
} else {
    $tpl->set('tbody','forgotpass.tpl');
}

$tpl->set('toptext',$lang['password_recovery']);
$tpl->set('bottomtext','&nbsp;');
$tpl->set('page_title',$lang['recover_password']);

$tpl->display();
exit;
?>