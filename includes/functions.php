<?
/***************************************************************************
					functions.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Standard site functions. DO NOT EDIT unless you know what you are doing.

***************************************************************************/

function fixDate($val)
{
    $dateArray = explode("-", $val);
    $val = date("j M Y", mktime(0,0,0, $dateArray[1], $dateArray[2], $dateArray[0]));
    return $val;
}

// Checks if $var is set, if not returns default value
function set(&$var,$default='') {
    if (isset($var)) {
        if (is_null($var) or ($var === '')) {
            return $default;
        } else {
            return $var;
        }
    } else {
        return $default;
    }
}

function securePage($access='none')
{
    global $accessLevels;

    $userAccess = (isset($_SESSION['ses_access'])) ? $_SESSION['ses_access'] : 0;

    if ('none' != $access )
    {
        if (!$userAccess)
        {
            $_SESSION['ses_login_to'] = $_SERVER['PHP_SELF'];
            session_destroy();
            header("Location: " . SITE_ROOT . 'login.php?r=2');
            exit;
        } else {
            if ($accessLevels[$access] > $accessLevels[$_SESSION['ses_access']])
            {
                trigger_error('You must be an administrator to access this page',E_USER_WARNING);
            }
            $_SESSION['ses_log_to'] = '';
        }
    }
}

function isAdmin($access)
{
    global $accessLevels;

    if ($accessLevels[$access] >= $accessLevels['admin'])
    {
        return true;
    }
    return false;
}

// swap items out of the querystring
function qstrSwap($qstr,$key,$value) {
    $qstr[$key] = $value;

    $str = '';
    foreach($qstr as $k=>$v) {
        if ($v) $str .= "&$k=$v";
    }
    return substr($str,1);
}

function hasAccess($accessLevel)
{	
    global $accessLevels;

    if ($accessLevels[$_SESSION['ses_access']] >= $accessLevels[$accessLevel])
    {
        return true;
    } else {
        return false;
    }
}

function message_die($message)
{
    echo $message;
    exit;
}

function remove_magic_quotes(&$array) {
   foreach (array_keys($array) as $key) {
       if (is_array($array[$key])) {
          remove_magic_quotes($array[$key]);
       } else {
           if (is_string($array[$key])) {
               $array[$key] = stripslashes($array[$key]);
           }
       }
  }
}

function currency_format($price) {
    global $SYSTEM;
    return sprintf($SYSTEM["regional"]["currency_format"], $price);
}

function logItem($creator,$targetID,$targetType,$eventID,$details='')
{
    global $ISL;
    
    $ISL->logItem($creator,$targetID,$targetType,$eventID,$details);

}

function acquireConnection(&$db,$dsn)
{
    $db = DB::connect($dsn);

    //always check for errors
    checkDBError($db);
}

function releaseConnection(&$db)
{
    $db->disconnect();
}

function checkDBError(&$db)
{
    if (DB::isError($db)) {
      trigger_error($db->getMessage(),E_USER_ERROR);
    }
}

function testConnection(&$db) 
{
    global $table_prefix;
    $query = "SELECT count(*) FROM ${table_prefix}client";

    $db->getOne($query);

    checkDBError($db);

    return true;
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
?>