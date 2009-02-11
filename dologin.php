<?
/***************************************************************************
					login.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Processes the login from the index page. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

$redir = SITE_ROOT . 'login.php'; 

if (isset($_POST['name']))
{
    $result = $ISL->doLogin($_POST['name'],$_POST['password']);

    if (is_array($result))
    {
        $_SESSION['ses_client_id'] = $result['clientid'];
        $_SESSION['ses_parent_id'] = $result['parentclientid'];
        $_SESSION['ses_client_name'] = $result['firstname'];
        $_SESSION['ses_client_company'] = $result['company'];
        $_SESSION['ses_access'] = $result['access'];
        $_SESSION['ses_template'] = ($result['template'] == 'default') ? $def_template : $result['template'];
        $_SESSION['ses_language'] = ($result['language'] == 'default') ? $def_lang : $result['language'];

        logItem(0,$_SESSION['ses_client_id'],2,10,$_SERVER['REMOTE_ADDR']);

        $redir = SITE_ROOT . $result['access'] . '/index.php';
    } else {
        $redir = SITE_ROOT . 'login.php?r=3';
    }

}

header("Location: " . $redir);
exit;
?>