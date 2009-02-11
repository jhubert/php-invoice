<?php
define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common_admin.php');

error_reporting(E_ALL);

if (!isset($session['ses_user'])) {
    header('Location: ' . SITE_ROOT . 'admin/index.php');
}


// Setup Template System
$tpl = & new TemplateSystem($lang);

// Set Page Title
$tpl->set('page_title','Admin Panel');

// Begin Page Vars
$page = set($_REQUEST['page'],'');  
$mode = set($_REQUEST['mode']);
$id = set($_REQUEST['id'],0);
$o = set($_GET['o'],'layoutID');
$editorURL = set($_REQUEST['editorURL'],'');
$ext = set($_REQUEST['ext'],'');

$abs_image_dir = HTTP_ROOT . 'templates/';
$page_name = SITE_ROOT . 'templates/' . $page . '.' . $ext;
switch ($mode) {
    case "update":
        $msg = '';
        
        if (file_exists(realpath($page_name))) {
            $content = str_replace($abs_image_dir,'<?=$TEMPLATE_DIR?>',$_POST['content']);
            $content = str_replace('<!textarea!','<textarea',$content);
            $content = str_replace($editorURL,'',$content);
            $content = str_replace(dirname($editorURL).'/','',$content);
            $content = str_replace(SITE_ROOT,'<?=$SITE_ROOT?>',$content);
            $content = str_replace(HTTP_ROOT,'<?=$SITE_ROOT?>',$content);
            $content = str_replace('Text Area Has Been Hidden For Compatibility<!/textarea!','</textarea',$content);

            if ($fh = @fopen(realpath($page_name),"w")) {
                fputs($fh,stripslashes($content));
                fclose($fh);
            } else {
                die('Permissoin Denied.  Please contact the system admin');
            }
        } else {
            die('Incorrect File Specified');
        }

        $msg .= '<p>Page was sucessfully updated.</p>';
        $tpl->set('msg',$msg);
    	break;
    case "edit":
        if (file_exists(realpath($page_name))) {
            $content = join(" ",file(realpath($page_name)));
            $content = str_replace('<textarea','<!textarea!',$content);
            $content = str_replace('<?=$TEMPLATE_DIR?>',$abs_image_dir,$content);
            $content = str_replace('<?=$SITE_ROOT?>',SITE_ROOT,$content);
            $content = str_replace('</textarea','Text Area Has Been Hidden For Compatibility<!/textarea!',$content);
        } else {
            die('Incorrect File Specified');
        }

        if ($ext == 'tpl') {
            $tpl->set('editor',1);
        }
        $tpl->set('page',$page);
        $tpl->set('ext',$ext);
        $tpl->set('content',$content);
        $tpl->set('tbody','system/edit_page.tpl');

        $tpl->display('layout.tpl');
        exit;
        break;
	default:

    break;
}

$folders = array();
$files = array();
$filelist = array();
$dirlist = array();

$realDir = realpath(SITE_ROOT . 'templates/' . $lang . '/');

$filelist = array();
$files = array();

if (is_dir($realDir)) {

    $currentDir = realpath('.');

    chdir($realDir);

    $handle=opendir('.');
    while ($file = readdir($handle)) {
        if(is_file($file)) {
            $filelist[] = $file; 
        }
    }
    closedir($handle);

    asort($filelist);
    while (list ($key2, $file) = each($filelist)) {
            $ext = substr($file,strlen($file)-3);
            if ($ext == 'tpl') {
                $files[] = array(substr($file,0,strlen($file)-4),'tpl');
            } elseif ($ext == '.js') {
                $files[] = array(substr($file,0,strlen($file)-3),'js');
            }
    }

    chdir($currentDir);

}

$tpl->set('files',$files);
$tpl->set('tbody','system/list_pages.tpl');
$tpl->display('layout.tpl');
exit;
?>