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

securePage('admin');

$message = '';

$tpl = & new TemplateSystem();

$tpl->set('page_title','Templates');

$realDir = realpath(SITE_ROOT . 'templates/');

if (is_dir($realDir)) {

    $handle=opendir($realDir);
    while ($file = readdir($handle)) {
        echo $file . "<br>";
        if(is_dir($realDir.'/'.$file) AND ($file != '.' && $file !='..')) {
            $templates[] = $file;
        }
    }
    closedir($handle);

}

$tpl->set('templates',$templates);
$tpl->set('message',$message);

$tpl->set('tbody','admin/editor/index.tpl');

$tpl->display();
exit;

?>