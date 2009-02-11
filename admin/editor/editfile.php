<?
/***************************************************************************
					clients.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Lists the current clients in the database. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$sel_template = isset($_REQUEST['template']) ? $_REQUEST['template'] : 0;
$sel_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;



if (!$sel_template) 
    trigger_error($lang['valid_template'],E_USER_WARNING);
if (!$sel_page) 
    trigger_error($lang['valid_file'],E_USER_WARNING);

$message = '';
if (strstr($sel_page,'../')) {
    trigger_error('Incorrect File Specified',E_USER_WARNING);
} 
$page_name = SITE_ROOT . 'templates/' . $sel_template . '/' . $sel_page;

$tpl = & new TemplateSystem();

if (isset($_POST['btnSubmit'])) {
    $msg = '';
  
    $content = $_POST['content'];

    if (file_exists(realpath($page_name))) {
        $content = str_replace('<!textarea!','<textarea',$content);
        $content = str_replace('Text Area Has Been Hidden For Compatibility<!/textarea!','</textarea',$content);

        if ($fh = @fopen(realpath($page_name),"w")) {
            fputs($fh,stripslashes($content));
            fclose($fh);
        } else {
             trigger_error('Permissoin Denied.  Please contact the system admin',E_USER_WARNING);
        }
    } else {
        trigger_error('Incorrect File Specified',E_USER_WARNING);
    }

    $msg .= sprintf($lang['page_updated'],'pickfile.php?template=' . $sel_template);
    $tpl->set('msg',$msg);
    $tpl->set('page_title',$lang['editor']);

    $tpl->set('message',$msg);

    $tpl->set('tbody','action_complete.tpl');

    $tpl->display();
    exit;
}

if (file_exists(realpath($page_name))) {
    $content = join(" ",file(realpath($page_name)));
    $content = str_replace('<textarea','<!textarea!',$content);
    $content = str_replace('</textarea','Text Area Has Been Hidden For Compatibility<!/textarea!',$content);
} else {
    trigger_error('Incorrect File Specified',E_USER_WARNING);
}

$tpl->set('page_title',$lang['edit_file']);


$tpl->set('page',$sel_page);
$tpl->set('content',$content);
$tpl->set('template',$sel_template);
$tpl->set('tbody','admin/editor/editfile.tpl');

$tpl->display();
exit;

?>