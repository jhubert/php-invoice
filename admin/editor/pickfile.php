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

$sel_template = isset($_GET['template']) ? $_GET['template'] : 0;

if (!$sel_template) 
    trigger_error('You must select a valid template',E_USER_WARNING);

$message = '';

$realDir = realpath(SITE_ROOT . 'templates/' . $sel_template);

if (is_dir($realDir)) {
    $files = getFiles($realDir);
}

$tpl = & new TemplateSystem();

$tpl->set('page_title','Templates');

$tpl->set('template',$sel_template);
$tpl->set('files',$files);
$tpl->set('message',$message);

$tpl->set('tbody','admin/editor/pickfile.tpl');

$tpl->display();
exit;

function getFiles($dir,$subfolder='.') {
    $handle=opendir($dir);
    $templates = array();
    while ($file = readdir($handle)) {
        if(is_file($dir.'/'.$file) AND (substr($file,-3) == 'tpl')) {
            $templates[] = $subfolder . '/' . $file;
        } elseif (is_dir($dir .'/'.$file) AND ($file != '.' && $file !='..')) {
            $templates = array_merge($templates,getFiles($dir .'/'.$file, $subfolder . '/' . $file));
        }
    }
    closedir($handle);

    return $templates;
}
?>