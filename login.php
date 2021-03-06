<?
/***************************************************************************
  login.php
  ------------
  product     : PHP Invoice
  version     : 1.0 build 1 (Beta)
  released    : Sunday September 7 2003
  copyright   : Copyright &copy; 2001-2009 Jeremy Hubert
  email       : support@illanti.com
  website     : http://www.illanti.com

  Login page. DO NOT EDIT unless 
  you know what you are doing.

***************************************************************************/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

if (isset($_SESSION['ses_client_id'])) {
  header("Location: " . SITE_ROOT . $_SESSION['ses_access'] . "/index.php");
  exit;
}

if (isset($_GET['r'])) {
  switch($_GET['r']) {
    case 1:
      $message = 'I am silly'; // I don't know what this is all about
    break;
    case 2:
      $message = 'You don\'t have access';
    break;
    case 3:
      $message = 'Invalid Username / Password';
    break;
    default:
      $message = $_GET['r'];
  }
}

securePage('none');

$tpl_main_file = 'login_framework.tpl';

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['log_in']);
$tpl->set('toptext',$lang['pleaselogin']);
$tpl->set('message',$message);
$tpl->set('bottomtext','<a href="' . SITE_ROOT .'forgotpass.php">' . $lang['forgot_password'] . '</a>');
$tpl->set('tbody','login.tpl');

$tpl->display();
exit;
?>