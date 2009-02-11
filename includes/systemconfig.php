<?
/***************************************************************************
					systemconfig.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Sets the system configuration options. DO NOT EDIT.

***************************************************************************/

/// Set the PEAR::DB DSN STRING
$main_dsn = "$db_type://$db_user:$db_pass@$db_host/$db_name";

$accessLevels = array('none'=>0, 'client'=>5, 'staff'=>15, 'admin'=>20);
$invoiceStatus = array();
$logEvents = array();

if (isset($_REQUEST['tpl'])) { 
    $_SESSION['ses_template'] = $_REQUEST['tpl']; 
}

if (isset($_REQUEST['lang'])) { 
    $_SESSION['ses_language'] = $_REQUEST['lang']; 
} 

// Has the user specified a different template & language
$tpl_folder = isset($_SESSION['ses_template']) ? $_SESSION['ses_template'] : $def_template;
$tpl_lang = (isset($_SESSION['ses_language']) && $_SESSION['ses_language'] != "") ? $_SESSION['ses_language'] : $def_lang;

if (!is_file(SITE_ROOT . 'languages/lang.' . $tpl_lang . '.php')) {
    $_SESSION['ses_language'] = $def_lang;
    $tpl_lang = $def_lang;
}
// Main template file for frame
$tpl_main_file = 'framework.tpl';

// Header Redirect Command
$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';

// Template System Instantiation
class TemplateSystem extends Template {
    function TemplateSystem() {

        global $tpl_main_file, $tpl_folder, $lang, $def_template;

        if ($tpl_folder == 'default') $tpl_folder = "_core";

		$this->template_dir = SITE_ROOT . "templates/" . $tpl_folder . "/";
        $this->main_file = $tpl_main_file;
        $this->default_dir = SITE_ROOT . "templates/_core/";

        $this->set('SITE_ROOT',SITE_ROOT);
        $this->set('HTTP_ROOT',HTTP_ROOT);
        $this->set('TEMPLATE_DIR',$this->template_dir);
        $this->set('IMAGE_DIR',$this->template_dir . 'images/');

        $this->set('lang',$lang);
        $this->set('session',$_SESSION);
    }
}
?>