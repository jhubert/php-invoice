<?
/***************************************************************************
					install.php
					------------
	product			: TypicalInvoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Installs the application. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
define('LOG_DIR','./log/');
define('ERR_DIR','./err/');

require_once(SITE_ROOT . 'includes/lib/class.TypicalConfig.php');

$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;

$configwrite = isset($_REQUEST['configwrite']) ? $_REQUEST['configwrite'] : false;

error_reporting(E_ALL);

?>
<html>
<head>
<title>Typical Invoice :: Installation</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body LEFTMARGIN=10 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<p>&nbsp;</p>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><img src="<?=SITE_ROOT?>images/site_logo.jpg" width="219" height="85">
    </td>
  </tr>
</table>
<br>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
        <table class="content" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 1px #000000 solid; border-right: 0px; border-bottom: 0px">
          <tr>
            <td style="background-color: #3C5D72; padding: 5px; color: #fff; font-weight: bold;"></td>
          </tr>
          <tr> 
            <td width="100%">
            <p>&nbsp;</p>
<?

switch($step) {
    case 1:
        displayStep1();
        break;
    case 2:
        runChecks(2);
        displayStep2();
        break;
    case 3:
        runChecks(3);
        setConfigValues(2);
        if ($_REQUEST['installtype'] <> 'upgrade') {
            addDBTables();
        }
        displayStep3();
        break;
    case 4:
        setConfigValues(3);
        displayStep4();
        break;
    case 5:
        displayComplete();
        break;
    default:
        echo "Invalid Step";
        break;
}

?>
<p>&nbsp;</p>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td background="<?=SITE_ROOT?>images/shdw_bottom.jpg"><img src="<?=SITE_ROOT?>images/shdw_left_corner.jpg" width=6 height=8 alt=""></td>
        <td background="<?=SITE_ROOT?>images/shdw_bottom.jpg"><img src="<?=SITE_ROOT?>images/spacer.gif" width="40" height="8"></td>
    </tr>
    </table>
</td>
	  <td width="6" valign="bottom" background="<?=SITE_ROOT?>images/shdw_right.jpg"><img src="<?=SITE_ROOT?>images/shdw_right_corner.jpg" width="6" height="8"></td>
	</tr>
</table>
<p align="center">
<a href="http://www.typicalgeek.com">powered by typical<b>Invoice</b></a>
</p>
<!-- 
Copyright Notice:

THIS COPYWRITE NOTICE AND THE TEXT ABOVE IT MUST APPEAR ON ALL PAGES

This script was written by Jeremy Hubert, and is protected under copywrite laws. 
Any improvements, please email typicalinvoice@typicalgeek.com. 
-->
<p>&nbsp;</p>
</body>
</html>
<?
//securePage('admin');

exit;

function displayStep1() {
?>
    <p>&nbsp;</p>
    <h3>Before continuting...</h4>
    <p>Please make sure you set the following files to 
writeable:<br>
<ol><li>./includes/config.php</li>
 <li>./err/</li>
 <li>./eml/</li>
</ol></p>
    <h1>Step 1 :: License Acceptance</h1>
    <div id="content">
        <div style="text-align: center; padding: 50px;">
        <form action="index.php" method="post">
        <div id="form">
            <p><textarea name="textarea" cols="80" rows="20">More detailed licence information coming soon.  In the meantime, by installing this software, you agree to the following:
            
-You will not re-distribute this software as your own.
-You will not re-sell the product without the express permission of the vendor.
-You will use 1 licence per installed copy.
-You won't do anything that jeopordizes the vendor's rights to the software.
-You will abide by the constraints of common sense and decency, as defined by the vendor.
-You won't make fun of me for my complete inability to write legal documents.
           
Enjoy.</textarea></p>
            <p><input type="submit" value="I Agree" />&nbsp;<input type="button" value="I Disagree" /></p>
            <input type="hidden" name="step" value="2" />
        </div>
        </form>
        </div>
    </div>
<?
}

function displayStep2() {
?>
    <p>&nbsp;</p>
    <h1>Step 2 :: System Settings</h1>
    <div id="content">
        <div>
        <form action="index.php" method="post">
        <div id="form">
            <p class="title">Install</p>	
            <p class="row">
                <span class="leftvalue" title="Select the type of install you are doing.  If you are upgrading from an old copy of TI Pro, it will not add any information to the database automatically.  If you are doing a clean install, or upgrading from TI Basic, it will populate the database with fresh information.">Install Type: [?]</span>
                <span class="rightvalue">
                <select name="installtype">
                    <option value="new">New Install</option>
                    <option value="upgrade">Upgrade from older Pro</option>
                    <option value="upgrade_basic">Upgrade from TI Basic</option>
                </select><br /></span>
            </p>
            <p class="title">Database Settings</p>
            <p class="row">
                <span class="leftvalue">Database Host:</span>
                <span class="rightvalue"><input type="text" name="db_host" value="localhost" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Database Name:</span>
                <span class="rightvalue"><input type="text" name="db_name" value="" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Database User:</span>
                <span class="rightvalue"><input type="text" name="db_user" value="" /></span>
            </p>				
            <p class="row">
                <span class="leftvalue">Database Password:</span>
                <span class="rightvalue"><input type="text" name="db_passwd" value="" /></span>
            </p>		
            <p class="row">
                <span class="leftvalue" title="This is the prefix on the tables in the database.">Database Prefix: [?]</span>
                <span class="rightvalue"><input type="text" name="db_prefix" value="ti_" /><br /></span>
            </p>
            <p class="row">
                <span class="leftvalue" title="The starting number for your invoices.  They will increment from this number up.">First Invoice #: [?]</span>
                <span class="rightvalue"><input type="text" name="inumstart" value="100" /><br /></span>
            </p>
            <p class="title">Server Settings</p>	
            <p class="row">
                <span class="leftvalue">HTTP Root:</span>
                <span class="rightvalue"><input type="text" name="httproot" value="<?=getHTTPRoot()?>" size="40" /></span>
            </p>
            <p class="row">
                <span class="leftvalue" title="This is the e-mail address that you want system error messages sent to.">Error Email Address: [?]</span>
                <span class="rightvalue"><input type="text" name="email_err" value="<?=getServerEmail()?>" size="40"/><br /></span>
            </p>
            <p class="row">
                <span class="leftvalue" title="This is the directory where error logs are kept. IT MUST BE WRITEABLE. (Relative to /)">Error Directory: [?]</span>
                <span class="rightvalue"><input type="text" name="dir_error" value="err/" /><br /></span>
            </p>
            <p class="row">
                <span class="leftvalue" title=This is the directory that e-mail copies are stored in. IT MUST BE WRITEABLE.(Relative to /)"">Email Directory: [?]</span>
                <span class="rightvalue"><input type="text" name="dir_email" value="eml/" /><br /></span>
            </p>
            <p class="title">Email Settings</p>	
            <p class="row">
                <span class="leftvalue" title="This is the e-mail address that you want invoices sent from.">From Address:</span>
                <span class="rightvalue"><input type="text" name="fromaddress" value="" size="40" /></span>
            </p>
            <p class="row">
                <span class="leftvalue" title="This is the name that you want the invoices sent from.">From Name: [?]</span>
                <span class="rightvalue"><input type="text" name="fromname" value="" size="40"/><br /></span>
            </p>
            <p class="row">
                <span class="rightvalue"><input type="submit" value="Next Step" /></span>
            </p>
            <input type="hidden" name="db_type" value="mysql" />
            <input type="hidden" name="step" value="3" />
        </div>
        </form>
        </div>
    </div>
<?
}

function displayStep3() {
?>
    <p>&nbsp;</p>
    <h1>Step 3 :: Program Preferences</h1>
    <div id="content">
        <div>
        <form action="index.php" method="post">
        <div id="form">
            <input type="hidden" name="installtype" value="<?=$_POST['installtype']?>">
            <p class="title">License Information</p>	
            <p class="row">
                <span class="leftvalue">License Key:</span>
                <span class="rightvalue"><textarea name="license"></textarea></span>
            </p>
            <p class="title">Regional Settings</p>	
            <p class="row">
                <span class="leftvalue">Currency Symbol:</span>
                <span class="rightvalue"><input type="text" name="currencysymbol" value="$" size="5" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Currency Text:</span>
                <span class="rightvalue"><input type="text" name="currencytext" value="USD" size="5" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Currency Format:</span>
                <span class="rightvalue"><input type="text" name="currencyformat" value="$ %01.2f" size="10" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Time Offset:</span>
                <span class="rightvalue"><input type="text" name="timeoffset" value="0" size="4" />&nbsp;The Current Server time is <?=date('g:i:s A')?></span>
            </p>
            <p class="row">
                <span class="leftvalue">Default Language:</span>
                <span class="rightvalue"><select name="deflanguage"><?=getLanguagesDD()?></select></span>
            </p>
            <p class="row">
                <span class="leftvalue">Short Date Format:</span>
                <span class="rightvalue"><input type="text" name="shortdate" value="d/m/y" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Long Date Format:</span>
                <span class="rightvalue"><input type="text" name="longdate" value="M d, Y" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Invoice Date Format:</span>
                <span class="rightvalue"><input type="text" name="invoicedate" value="d/m/y" /></span>
            </p>
            <p class="row">
                <span class="leftvalue">Date & Time Format:</span>
                <span class="rightvalue"><input type="text" name="datetime" value="d/m/y h:i:s a" /></span>
            </p>
            <p class="title">Display Settings</p>	
            <p class="row">
                <span class="leftvalue">Default Template:</span>
                <span class="rightvalue"><select name="deftemplate"><?=getTemplatesDD()?></select></span>
            </p>
            <p class="row">
                <span class="leftvalue">Results / Page:</span>
                <span class="rightvalue"><input type="text" name="invoicerpp" value="20" size="5" /></span>
            </p>
            <p class="row">
                <span class="rightvalue"><input type="submit" value="Next Step" /></span>
            </p>
            <input type="hidden" name="step" value="4" />
        </div>
        </form>
        </div>
    </div>
<?
}

function displayStep4() {
?>
    <p>&nbsp;</p>
    <h1>Step 4 :: Completed</h1>
    <div id="content">
        <div>
<?
    if ($_POST['installtype'] == 'new') :
    addAdminAccount();
?>
    <p>Thank you.  The install is complete.</p><br />
    <p>Please <a href="<?=SITE_ROOT?>/login.php">login</a> with the following information<br />
    Username: admin<br />
    Password: admin</p><br />
    <p>Once logged in, setup your account information by clicking "Edit Account" and then setup your paygates in the "Edit Paygates" area.</p><br />
    <p>For added security, please delete the /install/ directory from the server.</p><br />
<?
    elseif ($_POST['installtype'] == 'upgrade_basic') :
?>
    <p>Thank you.  The upgrade is complete.</p><br />
    <p>Please use the <a href="<?=SITE_ROOT?>import.php">Import</a> area to import your data from the Basic Version.</p><br />
    <p>If you haven't exported your data from the Basic version, please go to <a href="http://www.typicalgeek.com/help/tibasic/">TI Basic Support</a> for more information.</p><br />
    <p>Once logged in, setup your account information by clicking "Edit Account" and then setup your paygates in the "Edit Paygates" area.</p><br />
    <p>For added security, please delete the /install/ directory from the server.</p><br />
<?  
    else :
?>
    <p>Thank you.  The upgrade is complete.</p><br />
    <p>Please <a href="<?=SITE_ROOT?>/login.php">login</a> with your regular account information</p><br />
    <p>Your database information should still all be intact.</p><br />
    <p>For added security, please delete the /install/ directory from the server.</p><br />
<?
    endif;
?>
        </div>
    </div>
<?
}

function setConfigValues($step) {
    switch($step) {
        case 2:
            $TC = new TypicalConfig(SITE_ROOT . 'includes/config.php');

            $TC->loadConfig();

            $TC->clearValue('array','email');

            $TC->addConstant('HTTP_ROOT',$_REQUEST['httproot']);

            $TC->addVariable('db_type',$_REQUEST['db_type']);
            $TC->addVariable('db_host',$_REQUEST['db_host']);
            $TC->addVariable('db_name',$_REQUEST['db_name']);
            $TC->addVariable('db_user',$_REQUEST['db_user']);
            $TC->addVariable('db_pass',$_REQUEST['db_passwd']);
            $TC->addVariable('db_prefix',$_REQUEST['db_prefix']);
            $TC->addVariable('debug','0');

            $TC->setArray('email.from',$_REQUEST['fromaddress']);
            $TC->setArray('email.fromName',$_REQUEST['fromname']);

            $TC->addConstant('EMAIL_ERR',$_REQUEST['email_err']);
            $TC->addConstant('DIR_ERR',$_REQUEST['dir_error']);
            $TC->addConstant('DIR_EMAIL',$_REQUEST['dir_email']);

            $TC->SaveConfig();
            unset($TC);
            break;
        case 3:
            $TC = new TypicalConfig(SITE_ROOT . 'includes/config.php');

            $TC->loadConfig();

            $TC->clearValue('array','regional');

            $TC->setArray('regional.shortdate',$_REQUEST['shortdate']);
            $TC->setArray('regional.longdate',$_REQUEST['longdate']);
            $TC->setArray('regional.invoicedate',$_REQUEST['invoicedate']);
            $TC->setArray('regional.datetime',$_REQUEST['datetime']);
            $TC->setArray('regional.timeoffset',$_REQUEST['timeoffset']);
            $TC->setArray('regional.currency_sym',$_REQUEST['currencysymbol']);
            $TC->setArray('regional.currency_txt',$_REQUEST['currencytext']);
            $TC->setArray('regional.currency_format',$_REQUEST['currencyformat']);

            $TC->addVariable('license',$_REQUEST['license']);
            $TC->addVariable('def_lang',$_REQUEST['deflanguage']);
            $TC->addVariable('def_template',$_REQUEST['deftemplate']);
            $TC->addVariable('invoicerpp',$_REQUEST['invoicerpp']);

            $TC->SaveConfig();
            unset($TC);
            break;
        case 4:
            break;
    }
}

function runChecks($step) {
    switch($step) {
        case 2:
            checkWritePermissions();
            break;
        case 3:
			if (checkDirWritePermissions()) {
				checkDBConnection();
			} 
            break;
        case 4:
            displayStep4();
            break;
    }
}

function checkDirWritePermissions() {
	$pass = $fail = "";
	$success = true;
	if (is_writable(SITE_ROOT.$_REQUEST['dir_error'])) {
		$pass .= 'Testing if error directory is writable... PASSED!';
	} 
	else {
		$fail .= 'Testing if error directory is writable... FAILED!<br/>Please go back and make sure that the "'.$_REQUEST['dir_error'].'" directory is writable.';
		$success = false;
	}

	if (is_writable(SITE_ROOT.$_REQUEST['dir_email'])) {
		$pass .= '<br />Testing if email directory is writable... PASSED!<br/>';
	} 
	else {
		$fail .= '<br />Testing if email directory is writable... FAILED!<br/>Please make sure that the "'.$_REQUEST['dir_email'].'" directory is writable<br/>';
		$success = false;
	}
	echo '<p class="check_pass">'.$pass.'</p>';
	echo '<p class="check_fail">'.$fail.'</p>';
	return $success;
}
function checkWritePermissions() {
    global $configfile;
	if (is_writable(SITE_ROOT.'includes/config.php')) {
		echo '<p class="check_pass">Testing if config file is writable... PASSED!</p>';
	} 
	else {
		echo '<p class="check_fail">Testing if config file is writable... FAILED!<br/>Please make sure that the config.php file in the ./includes/ directory is writeable</p>';
	}
}

function checkPermissions($dir) {
    $filename = realpath(SITE_ROOT . $dir);
    echo fileperms($filename) . "    ";
    echo "<pre>";
    print_r(stat($filename));
    echo "</pre>";
    $perms = base_convert(fileperms($filename), 10, 8);
    $perms = substr($perms, (strlen($perms) - 3));
    echo $perms . "<br>";
}

function checkDBConnection() {
    require_once('DB.php'); 
    $dsn = $_REQUEST['db_type'] . "://" . $_REQUEST['db_user'] . ":" . $_REQUEST['db_passwd'] . "@" . $_REQUEST['db_host'] . "/" . $_REQUEST['db_name'];
    
    $check = acquireConnection($db,$dsn);
    if (!$check) {
        echo "<p class='check_pass'>Testing if db is accessible... PASSED!</p>";
        releaseConnection($db);
        return true;
    }
    echo "<p class='check_fail'>Testing if db is accessible... FAILED!<br />The error message was: " . $check . "<br />Please press back and check your settings</p>";
    return true;
}

function acquireConnection(&$db,$dsn)
{
    $db = DB::connect($dsn);

    //always check for errors
    return checkDBError($db);
}

function releaseConnection(&$db)
{
    $db->disconnect();
}

function checkDBError(&$db)
{
    if (DB::isError($db)) {
      return $db->getMessage();
    } else {
      return false;
    }
}

function getHTTPRoot() {
    return trim('http://' . $_SERVER['SERVER_NAME'] . str_replace("install",'',dirname($_SERVER['SCRIPT_NAME'])));
}

function getServerEmail() {
    return "webmaster@" . preg_replace('/^[a-zA-Z0-9]{3}\./','',$_SERVER['SERVER_NAME']);
}

function getTemplatesDD() {
    $templates = array();

    $realDir = realpath(SITE_ROOT . 'templates/');

    if (is_dir($realDir)) {

        $handle=opendir($realDir);
        while ($file = readdir($handle)) {
            if(is_dir($realDir.'/'.$file) AND ($file != '.' && $file !='..')) {
                $templates[] = $file;
            }
        }
        closedir($handle);

    }

    $retVal = '';

    sort($templates);

    foreach ($templates as $template) {
        $retVal .= '<option value="' . $template . '">' . $template . '</option>';
    }

    return $retVal;
}

function getLanguagesDD() {

    $retVal = '';

    $realDir = realpath(SITE_ROOT . 'languages/');

    if (is_dir($realDir)) {

        $handle=opendir($realDir);
        while ($file = readdir($handle)) {
            if(is_file($realDir.'/'.$file) AND (substr($file,0,5) == 'lang.')) {
                $language = explode('.',$file);
                $langs[] = $language[1];
            }
        }
        closedir($handle);

        sort($langs);

        foreach($langs as $language) {
                $retVal .= '<option value="' . $language . '">' . str_replace('_',' ',$language) . '</option>';
        }

    }

    return $retVal;
}

function addDBTables() {
    require_once('DB.php'); 
    $dsn = $_REQUEST['db_type'] . "://" . $_REQUEST['db_user'] . ":" . $_REQUEST['db_passwd'] . "@" . $_REQUEST['db_host'] . "/" . $_REQUEST['db_name'];
    
    $check = acquireConnection($db,$dsn);
    if (!$check) {
        echo "<p>Inserting SQL Data...</p>";
        $db_prefix = $_REQUEST['db_prefix'];
        $inum_start = $_REQUEST['inumstart'];
        include('sql_tables.php');
        echo "<p>Inserting Tables...";
        $error = array();
        foreach($sql as $query) {
            $result = $db->query($query);
            $err = checkDBError($result);
            if ($err) {
                $error[] = $err . " ::> " . $query;
                echo '<span class="check_fail">FAILED!</span></p><p>The error message was:<b> ' . $err . '</b><br>on the query:<br>' . $query;
                die();
            }
        }
        if (count($error)) {
                echo '<span class="check_fail">FAILED!</span></p><p>The error message was:<br> ' . implode("<br>",$error);
                die();
        } else {
            echo '<span class="check_pass">DONE!</span></p>';
        }
        include('sql_data.php');
        echo "<p>Inserting Data...";
        $error = array();
        foreach($sql as $query) {
            $result = $db->query($query);
            $err = checkDBError($result);
            if ($err) {
                $error[] = $err . " ::> " . $query;
                echo '<span class="check_fail">FAILED!</span></p><p>The error message was:<b> ' . $err . '</b><br>on the query:<br>' . $query;
                die();
            }
        }
        if (count($error)) {
                echo '<span class="check_fail">FAILED!</span></p><p>The error message was:<br> ' . implode("<br>",$error);
                die();
        } else {
            echo '<span class="check_pass">DONE!</span></p>';
        }
        releaseConnection($db);
        return true;
    }
    return false;
}

function addAdminAccount() {
    require_once('DB.php'); 

    $TC = new TypicalConfig(SITE_ROOT . 'includes/config.php');

    $TC->loadConfig();

    $config = $TC->getVars('var');
    
    unset($TC);

    $dsn = $config['db_type'] . "://" . $config['db_user'] . ":" . $config['db_pass'] . "@" . $config['db_host'] . "/" . $config['db_name'];
    
    $check = acquireConnection($db,$dsn);
    if (!$check) {
        $db_prefix = $config['db_prefix'];
        include('sql_admin.php');
        echo "<p>Inserting Admin Account...";
        $error = array();
        $result = $db->query($sql);
        $err = checkDBError($result);
        if ($err) {
            $error[] = $err . " ::> " . $sql;
            echo '<span class="check_fail">FAILED!</span></p><p>The error message was:<b> ' . $err . '</b><br>on the query:<br>' . $sql;
            die();
        }
        echo '<span class="check_pass">DONE!</span></p>';

        releaseConnection($db);
        return true;
    }
    return false;
}
?>
