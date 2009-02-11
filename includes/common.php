<?
/***************************************************************************
					common.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Contains all information that pertains to every loaded file. Includes, 
    page specs, error levels and the such. Also opens the db connection and
    instantiates the InvoiceSystemLibrary.
    
    DO NOT EDIT unless you know what you are doing.

***************************************************************************/

define('ERROR_LEVEL',E_ALL ^ E_NOTICE);

error_reporting(ERROR_LEVEL);

session_start();

require_once(SITE_ROOT . 'includes/error_handler.php');
require_once(SITE_ROOT . 'includes/lib/class.TypicalTemplate.php');
require_once(SITE_ROOT . 'includes/functions.php');

if (get_magic_quotes_gpc()) {
  remove_magic_quotes($_GET);
  remove_magic_quotes($_POST);
  remove_magic_quotes($_COOKIE);
  if (isset($_SESSION)) remove_magic_quotes($_SESSION);

  ini_set('magic_quotes_gpc', 0);
}

set_magic_quotes_runtime(0);

include_once(SITE_ROOT . 'includes/config.php');

if (!isset($SYSTEM)) {
    die('The installer has not been run.  Please <a href="' . SITE_ROOT . 'install/">run it now</a>.');
}

include_once(SITE_ROOT . 'includes/lib/lib.InvoiceSystem.php');
include_once(SITE_ROOT . 'includes/lib/class.Emailer.php');

require_once('DB.php'); // PEAR::DB

require_once(SITE_ROOT . 'includes/systemconfig.php');
//echo "Lang: " . $tpl_lang;
include_once(SITE_ROOT . 'languages/lang.' . $tpl_lang . '.php');

$invoiceStatus[0] = $lang['is_unsent'];
$invoiceStatus[1] = $lang['is_pending'];
$invoiceStatus[2] = $lang['is_partially_paid'];
$invoiceStatus[3] = $lang['is_fully_paid'];
$invoiceStatus[4] = $lang['is_over_paid'];
$invoiceStatus[5] = $lang['is_overdue'];

$logEvents[1] = $lang['le_invoice_added'];  
$logEvents[2] = $lang['le_invoice_updated'];
$logEvents[3] = $lang['le_invoice_deleted'];
$logEvents[5] = $lang['le_mail_sent'];      
$logEvents[6] = $lang['le_client_added'];   
$logEvents[7] = $lang['le_client_updated']; 
$logEvents[8] = $lang['le_client_deleted']; 
$logEvents[10]= $lang['le_user_logged_in'];

$emailType[1] = $lang['et_invoice'];
$emailType[2] = $lang['et_notify'];
$emailType[3] = $lang['et_reminder'];
$emailType[4] = $lang['et_overdue'];

acquireConnection($db,$main_dsn);

testConnection($db);

if (isset($_SESSION['ses_access']) && $_SESSION['ses_access'] == 'staff') {
    $adminid = $_SESSION['ses_parent_id'];
} else {
    $adminid = isset($_SESSION['ses_client_id']) ? $_SESSION['ses_client_id'] : 0;
}

$ISL = new InvoiceSystem($db,$adminid,$db_prefix,$invoicerpp,$debug);

?>