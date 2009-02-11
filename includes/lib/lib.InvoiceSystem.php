<?
/***************************************************************************
					InvoiceSystemLib.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    The core of the invoice system. 
    
    DO NOT EDIT unless you know what you are doing.

***************************************************************************/
/*
# -------- IGNORE EVERYTHING BELOW THIS LINE --------
$call_home_to="secure.typicalgeek.com";
$installed_directory="/licence";
$querystring="iaccess_ip=".base64_encode($_SERVER['SERVER_ADDR']);
$querystring.="&iaccess_host=".base64_encode($_SERVER['SERVER_NAME']);
$querystring.="&product_key=".urlencode("10f6f8c0f3fad50a21f4c6fc3a224337");
$querystring.="&license=".urlencode($license)."\n\n";

$fp=@fsockopen($call_home_to, 80, $errno, $errstr, 5);
if (!$fp) { return 1; }
else
   {
   $header="POST ".$installed_directory."/validate_internal.php HTTP/1.1\n";
   $header.="Host: ".$call_home_to."\n";
   $header.="Content-Length: ".strlen($querystring)."\n";
   $header.="Content-Type: application/x-www-form-urlencoded\n";
   $header.="Connection: Close\n\n";
   $header.=$querystring;

   fputs ($fp, $header);
   while (!feof($fp)) { $data.=@fgets($fp, 1024); }
   fclose ($fp);

   list($a, $b, $c)=explode("{{", $data);
   function parse_template($template)
      {
      $buffer="";
      $fh=file($template);
      foreach($fh as $line) { $buffer.=$line; }
      return $buffer;
      }

   $path_home="http://".$call_home_to.$installed_directory."/inc";
   if ($b==69) 
      { 
      echo parse_template($path_home."/license_invalid.tpl");
      exit; 
      }		
   else if ($b==2) 
      { 
      echo parse_template($path_home."/license_suspended.tpl"); 
      exit;	
      }
   else if ($b==3) 
      { 
      echo parse_template($path_home."/license_expired.tpl"); 
      exit; 
      }
   }
*/

class InvoiceSystem {
	
    var $db;
    var $debug = false;
    var $dbprefix;
    var $adminid;
    var $rpp; // results per page
    var $def_rpp; // default results per page
    var $page; // current result page

    function InvoiceSystem(&$db,$adminid, $dbprefix,$rpp,$debug=false) {
        if(!$db) {
            die("Invalid db object passed to InvoiceSystem constructor");  
        }
        $this->db = $db;
        $this->debug = $debug;
        $this->dbprefix = $dbprefix;
        $this->adminid = $adminid;
        $this->rpp = $rpp;
        $this->def_rpp = $rpp;
    }

    function setDebug($debug) {
        $this->debug = $debug;
        return true;
    }

    function setRPP($rpp=0) {
        if ($rpp) {
            $this->rpp = $rpp;
        } else {
            $this->rpp = $this->def_rpp;
        }
        return true;
    }

    function setPage($page) {
        $this->page = $page;
        return true;
    }

    function SqlError($query, $result) 
    {
        trigger_error("MYSQL error:  ".$result->getMessage().
                      " in query:<br />".$query."<br />",E_USER_ERROR);
    }

    function doLogin($username,$password) {
        $query = "SELECT `clientid` , `parentclientid`, `username` , `firstname`, `email` , `ref` , `company` , `access`, `template`, `language` FROM " . $this->dbprefix . "client WHERE username = '" . $username . "' AND passwd = '" . $password . "'";
    
        $retVal = $this->db->getRow($query,null,DB_FETCHMODE_ASSOC);
        
        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function recoverPassword($method,$value) {
        $query = "SELECT `clientid` , `username` , `firstname`, `email` , `passwd` FROM " . $this->dbprefix . "client WHERE " . $method . " = '" . $value . "'";
    
        $retVal = $this->db->getRow($query,null,DB_FETCHMODE_ASSOC);
        
        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }
    

    function FetchInvoices($page=0,$param='invoice_num',$where='1') {

        if (strtolower($param) == 'clientid') $param = 'i.' . $param;

        $query = "SELECT c.clientid,company,i.invoiceid, invoice_num,UNIX_TIMESTAMP(issue_date) as issue_date,UNIX_TIMESTAMP(due_date) as due_date,SUM(ii.cost*iii.qty) as cost , (SUM(ii.cost*iii.qty)+(shipping))*(tax/100) as tax, (SUM(ii.cost*iii.qty)+(shipping))*(tax2/100) as tax2, shipping , (IFNULL(SUM(ii.cost*iii.qty),0)+(shipping))*(1+(tax/100))*(1+(tax2/100)) as total,curr_status FROM " . $this->dbprefix . "invoice i INNER JOIN " . $this->dbprefix . "client c ON i.clientid = c.clientid LEFT JOIN " . $this->dbprefix . "invoice_invoiceitem as iii ON i.invoiceid = iii.invoiceid LEFT JOIN " . $this->dbprefix . "invoiceitem as ii ON ii.invoiceitemid = iii.invoiceitemid WHERE i.visible = '1' AND parentclientid = " . $this->adminid . " AND $where GROUP BY iii.invoiceid, i.invoiceid ORDER BY $param";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function FetchInvoicesByClient($clientID,$param='invoice_num',$where='1') {
        $query = "SELECT i.invoiceid, invoice_num,UNIX_TIMESTAMP(issue_date) as issue_date,UNIX_TIMESTAMP(due_date) as due_date,SUM(ii.cost*iii.qty) as cost , (SUM(ii.cost*iii.qty)+(shipping))*(tax/100) as tax, (SUM(ii.cost*iii.qty)+(shipping))*(tax2/100) as tax2, shipping , (SUM(ii.cost*iii.qty)+(shipping))*(1+(tax/100))*(1+(tax2/100)) as total,curr_status FROM " . $this->dbprefix . "invoice i LEFT JOIN " . $this->dbprefix . "invoice_invoiceitem as iii USING ( invoiceid ) LEFT JOIN " . $this->dbprefix . "invoiceitem as ii USING ( invoiceitemid ) WHERE visible = '1' AND clientid = '" . $clientID . "' AND curr_status <> 'unsent' AND $where GROUP BY iii.invoiceid ORDER BY $param";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function FetchInvoiceList($clientID=0) {

        if (!$clientID) {
            $where = '1';
        } else {
            $where = 'clientid = ' . $clientID;
        }

        $query = "SELECT invoiceid,invoice_num FROM " . $this->dbprefix . "invoice WHERE $where ORDER BY invoice_num";

        $retVal = $this->db->getAssoc($query,false,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchInvoiceClient($invoiceID) {

        $query = "SELECT clientID FROM " . $this->dbprefix . "invoice WHERE invoiceid = $invoiceID";

        $retVal = $this->db->getOne($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchInvoiceNum($invoiceID) {

        $query = "SELECT invoice_num FROM " . $this->dbprefix . "invoice WHERE invoiceid = $invoiceID";

        $retVal = $this->db->getOne($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchClientCompany($clientID) {

        $query = "SELECT company FROM " . $this->dbprefix . "client WHERE clientid = $clientID";

        $retVal = $this->db->getOne($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }


    function FetchClients($access='client',$display='active') {

        switch($display) {
            case 'all':
                $where = '1';
            break;
            case 'inactive':
                $where = "c.visible = '0'";
            break;
            default:
                $where = "c.visible = '1'";
            break;
        }
        
        $query = "SELECT c.`clientid` , `parentclientid` , `username` , `email` , `ref` , `company` , `firstname` , `lastname` , `contacttitle` , `phonenumber` , `faxnumber` , `term_days` , `def_terms` , `def_comments` , `account_num` , `template` , `language` , `access` , c.`visible`,count(invoiceID) as invoicecount FROM `" . $this->dbprefix . "client` as c LEFT JOIN `" . $this->dbprefix . "invoice` as i USING (clientid) WHERE $where AND access = '$access' AND parentclientid = " . $this->adminid . " GROUP BY c.clientID ORDER BY c.company";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchClientList() {

        $query = "SELECT clientid,company FROM " . $this->dbprefix . "client WHERE access = 'client' AND parentclientid = " . $this->adminid . " ORDER BY company";

        $retVal = $this->db->getAssoc($query,false,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FindNewInvoiceNumber($cid=0,$inum=0) {

        if (!$inum) 
            $inum = $this->db->nextid($this->dbprefix . 'invoice_num');
        
        $query = "SELECT invoiceid,invoice_num FROM " . $this->dbprefix . "invoice INNER JOIN " . $this->dbprefix . "client USING ( clientid ) WHERE parentclientid=" . $this->adminid . " AND invoice_num='" . $inum . "'";

        $retVal = $this->db->getRow($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        if (count($retVal)) {
            if ($retVal[0]==$cid) 
                return $inum;
            else
                return $this->FindNewInvoiceNumber($cid);
        } else {
            return $inum;
        }
    }

    function FetchClientOwner($clientID) {

        $query = "SELECT parentclientid FROM " . $this->dbprefix . "client WHERE clientid=" . $clientID;

        $retVal = $this->db->getOne($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchClientDetails($clientID) {

        $query = "SELECT * FROM " . $this->dbprefix . "client WHERE clientid=" . $clientID;

        $retVal = $this->db->getRow($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);
 
        return $retVal;

    }

    function FetchAdminDetails($adminID) {

        $query = "SELECT company,firstName,lastName,phoneNumber,faxNumber,address,logo,email,def_tax,def_tax2,term_days,def_terms,def_comments FROM " . $this->dbprefix . "client WHERE clientid=" . $adminID;

        $retVal = $this->db->getRow($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function FetchInvoiceDetails($invoiceID) {
        
        $query = "SELECT i.invoiceid, invoice_num, clientid , UNIX_TIMESTAMP(issue_date) as issue_date,UNIX_TIMESTAMP(due_date) as due_date , comments , SUM(ii.cost*iii.qty) as cost , (SUM(ii.cost*iii.qty)+(shipping))*(tax/100) as calc_tax, (SUM(ii.cost*iii.qty)+(shipping))*(tax2/100) as calc_tax2, shipping, (IFNULL(SUM(ii.cost*iii.qty),0)+(shipping))*(1+(tax/100))*(1+(tax2/100)) as total, tax, tax2, curr_status, comments, terms FROM " . $this->dbprefix . "invoice i LEFT JOIN " . $this->dbprefix . "invoice_invoiceitem as iii USING ( invoiceid ) LEFT JOIN " . $this->dbprefix . "invoiceitem as ii USING ( invoiceitemid ) WHERE i.invoiceid = " . $invoiceID . " GROUP BY iii.invoiceid";

        $retVal = $this->db->getRow($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        if (is_array($retVal))
            $retVal['items'] = $this->Fetchinvoiceitems($invoiceID);

        return $retVal;

    }

    function Fetchinvoiceitems($invoiceID) {
        
        $query = "SELECT  iii.`invoiceitemid` ,  iii.`qty`, `details`, `cost` FROM  `" . $this->dbprefix . "invoice_invoiceitem` iii INNER JOIN `" . $this->dbprefix . "invoiceitem` ii USING ( invoiceitemid ) WHERE 1  AND  iii.`invoiceid` = " . $invoiceID;

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        if (!is_array($retVal)) $retVal = array();

        return $retVal;

    }

    function InsertClient($values) {

        if ($values['def_tax'] == '') {
            $values['def_tax'] = 'NULL';
        }
        if ($values['def_tax2'] == '') {
            $values['def_tax2'] = 'NULL';
        }
        if ($values['term_days'] == '') {
            $values['term_days'] = 'NULL';
        }

        $id = $this->db->nextid($this->dbprefix . 'client');    

        $query = "INSERT INTO " . $this->dbprefix . "client (clientid, parentclientid, username, passwd, address, email, def_tax, def_tax2, ref , `firstName` , `lastName` , `contactTitle` , `company` , `phonenumber` , `faxnumber` , `url` , `logo` , `template` , `language` , `term_days` , `def_terms` , `def_comments` , `account_num` , `access` , `visible`) VALUES 
        ($id," . 
        addslashes($values['parentclientid']) . ",'" . 
        addslashes($values['username']) . "','" . 
        addslashes($values['passwd']) . "','" . 
        addslashes($values['address']) . "','" . 
        addslashes($values['email']) . "'," . 
        addslashes($values['def_tax']) . "," . 
        addslashes($values['def_tax2']) . ",'" . 
        addslashes($values['ref']) . "','" . 
        addslashes($values['firstname']) . "', '" . 
        addslashes($values['lastname']) . "', '" . 
        addslashes($values['contacttitle']) . "', '" .
        addslashes($values['company']) . "', '" . 
        addslashes($values['phonenumber']) . "', '" . 
        addslashes($values['faxnumber']) . "', '" . 
        addslashes($values['url']) . "', '" . 
        addslashes($values['logo']) . "', '" . 
        addslashes($values['template']) . "', '" . 
        addslashes($values['language']) . "', " . 
        addslashes($values['term_days']) . ", '" . 
        addslashes($values['def_terms']) . "', '" . 
        addslashes($values['def_comments']) . "', '" . 
        addslashes($values['account_num']) . "', '" . 
        addslashes($values['access']) . "', '" . addslashes($values['visible']) . "')";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $id;

    }

    function UpdateClient($clientID,$values) {

        if ($values['def_tax'] == '') {
            $values['def_tax'] = 'NULL';
        }
        if ($values['def_tax2'] == '') {
            $values['def_tax2'] = 'NULL';
        }
        if ($values['term_days'] == '') {
            $values['term_days'] = 'NULL';
        }

        $query = "UPDATE " . $this->dbprefix . "client SET
        parentclientid=" . addslashes($values['parentclientid']) . ",
        username='" . addslashes($values['username']) . "',
        passwd='" . addslashes($values['passwd']) . "',
        address='" . addslashes($values['address']) . "',
        email='" . addslashes($values['email']) . "',
        def_tax=" . addslashes($values['def_tax']) . ",
        def_tax2=" . addslashes($values['def_tax2']) . ",
        ref='" . addslashes($values['ref']) . "',
        firstname='" . addslashes($values['firstname']) . "',
        lastname='" . addslashes($values['lastname']) . "',
        contacttitle='" . addslashes($values['contacttitle']) . "',
        company='" . addslashes($values['company']) . "',
        phonenumber='" . addslashes($values['phonenumber']) . "',
        faxnumber='" . addslashes($values['faxnumber']) . "',
        url='" . addslashes($values['url']) . "',
        logo='" . addslashes($values['logo']) . "',
        term_days=" . addslashes($values['term_days']) . ",
        def_terms='" . addslashes($values['def_terms']) . "',
        def_comments='" . addslashes($values['def_comments']) . "',
        account_num='" . addslashes($values['account_num']) . "',
        template='" . addslashes($values['template']) . "',
        language='" . addslashes($values['language']) . "',
        access='" . addslashes($values['access']) . "',
        visible='" . addslashes($values['visible']) . "'
        WHERE clientid=$clientID";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function DeleteClient($clientID,$soft=true) {

        if ($soft) {
            $query = "UPDATE " . $this->dbprefix . "client SET visible = '0' WHERE clientid=" . $clientID;
        } else {
            $query = "DELETE FROM " . $this->dbprefix . "client WHERE clientid=" . $clientID;
        }

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function InsertInvoice(&$values) {

        $id = $this->db->nextid($this->dbprefix . 'invoice');    

        if (!is_numeric($values['invoice_num']) || !$values['invoice_num'])
            $values['invoice_num'] = 0;

        $values['invoice_num'] = $this->FindNewInvoiceNumber($id,$values['invoice_num']);

        $query = "INSERT INTO " . $this->dbprefix . "invoice (invoiceid, clientid, issue_date, due_date, comments, cost, tax, tax2, shipping, curr_status, terms, invoice_num) VALUES ('$id','" . addslashes($values['clientid']) . "','" . date('Y-m-d h:i:s',strtotime($values['issue_date'])) . "','" . date('Y-m-d h:i:s',strtotime($values['due_date'])) . "','" . addslashes($values['comments']) . "','" . addslashes($values['cost']) . "','" . addslashes($values['tax']) . "','" . addslashes($values['tax2']) . "','" . addslashes($values['shipping']) . "','" . addslashes($values['curr_status']) . "','" . addslashes($values['terms']) . "','" . addslashes($values['invoice_num']) . "')";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $id; //array('id'=>$id,'num'=>$values['invoice_num']);

    }

    function Insertinvoiceitem($details,$cost) {

        $id = $this->db->nextid($this->dbprefix . 'invoiceitem');

        $query = "INSERT INTO " . $this->dbprefix . "invoiceitem (invoiceitemid, details, cost) VALUES ('$id','" . addslashes($details) . "','" . addslashes($cost) . "')";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $id;
    }

    function AddItemToInvoice($invoiceitemid,$invoiceid,$qty) {

        $query = "INSERT INTO " . $this->dbprefix . "invoice_invoiceitem (invoiceitemid, invoiceid, qty) VALUES ('$invoiceitemid','$invoiceid','$qty')";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function DeleteInvoiceItem($invoiceitemID) {

        $query = "DELETE FROM " . $this->dbprefix . "invoiceitem WHERE invoiceitemid = " . $invoiceitemID;

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function RemoveItemFromInvoice($invoiceitemID,$invoiceID) {

        $query = "DELETE FROM " . $this->dbprefix . "invoiceitem WHERE invoiceitemid = " . $invoiceitemID;

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function DeleteInvoice($invoiceID,$soft=true) {

        if ($soft) {
            $query = "UPDATE " . $this->dbprefix . "invoice SET curr_status = 'void' WHERE invoiceid = " . $invoiceID;
        } else {
            $query = "DELETE FROM " . $this->dbprefix . "invoice WHERE invoiceid = " . $invoiceID;
        }

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function UpdateInvoice($invoiceID,$values) {

        $values['invoice_num'] = $this->FindNewInvoiceNumber($invoiceID,$values['invoice_num']);

        $query = "UPDATE " . $this->dbprefix . "invoice SET invoice_num='" . addslashes($values['invoice_num']) . "',clientid='" . addslashes($values['clientid']) . "',issue_date='" . date('Y-m-d h:i:s',strtotime($values['issue_date'])) . "', due_date='" . date('Y-m-d h:i:s',strtotime($values['due_date'])) . "', comments='" . addslashes($values['comments']) . "',terms='" . addslashes($values['terms']) . "',cost='" . addslashes($values['cost']) . "',tax='" . addslashes($values['tax']) . "',tax2='" . addslashes($values['tax2']) . "',shipping='" . addslashes($values['shipping']) . "',curr_status='" . addslashes(strtolower($values['curr_status'])) . "' WHERE invoiceid=$invoiceID";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function UpdateInvoiceStatus($invoiceID,$status) {

        $query = "UPDATE " . $this->dbprefix . "invoice SET curr_status='" . addslashes($status) . "' WHERE invoiceid=$invoiceID";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function LogItem($creator,$targetID,$targetType,$eventID,$details='') {

        $query = "INSERT INTO " . $this->dbprefix . "log (creator,targetid,targettype,eventid,details) VALUES (" . $creator . "," . $targetID . "," . $targetType . "," . $eventID . ",'" . $details . "');";
    
        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function addEmailSend($clientID, $invoiceID, $emailaddress, $sendType) {

        $emailSendID = $this->db->nextid($this->dbprefix . 'emailsend');

        if ($invoiceID == 0) {
            $invoiceID == "NULL";
        }

        $query = "INSERT INTO `" . $this->dbprefix . "emailsend` ( `emailsendid` , `clientid` , `invoiceid` , `emailaddress` , `sendtype` , `datesent` , `opencount`) VALUES (" . $emailSendID . ", " . $clientID . ", "  . $invoiceID . " , '"  . $emailaddress . "' , " . $sendType . ", '" . date('Y-m-d H:i:s') . "', 0)";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $emailSendID;
    }

    function trackEmailSendOpen($emailSendID) {

        /*
        connect to the database and process opened issues
        */
        $sql = "SELECT count(emailsendid) FROM " . $this->dbprefix . "emailsend WHERE opencount > 0 AND emailsendid = " . $emailSendID;

        $retVal = $this->db->getOne($sql);

        if ($retVal) {
            $sql = "UPDATE " . $this->dbprefix . "emailsend SET opencount = opencount + 1, lastopened = '" . date('Y-m-d H:i:s') . "' WHERE emailsendid = " . $emailSendID;			
        } else {
            $sql = "UPDATE " . $this->dbprefix . "emailsend SET opencount = 1, firstopened = '" . date('Y-m-d H:i:s') . "', lastopened = '" . date('Y-m-d H:i:s') . "' WHERE emailSendID = " . $emailSendID;			
        }

        $retVal = $this->db->query($sql);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function getEmailSendHistory($clientID=0) {

        $where = ($clientID) ? 'AND c.`clientid`=' . $clientID : '';

        $sql = "SELECT `emailsendid` , `company`, c.`clientid` , `invoiceid` , `emailaddress` , `sendtype` , UNIX_TIMESTAMP(datesent) as datesent , `opencount` , UNIX_TIMESTAMP(firstopened) as firstopened, UNIX_TIMESTAMP(lastopened) as lastopened  FROM " . $this->dbprefix . "emailsend INNER JOIN `" . $this->dbprefix . "client` as c USING ( clientid ) WHERE parentclientid = " . $this->adminid . " $where ORDER BY emailsendid";			

        $retVal = $this->db->getAll($sql,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

	function FetchLogItems($date=null) {
		
		$query = "SELECT `logid` , client.`clientid` , `company` , `invoiceid` , `eventid` , UNIX_TIMESTAMP(`occured`) as occured , `details` FROM `" . $this->dbprefix . "log` INNER JOIN `client` USING ( `clientid` ) WHERE parentclientid = " . $this->adminid;

		$retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

		if(DB::isError($retVal)) $this->SqlError($query,$retVal);

		return $retVal;
	}

	function FetchLogItemsByClient($clientID=0,$date=null) {
		
		$query = "SELECT `logid` , `creator` , `company` , `targetid` , `targettype` , `eventid` , UNIX_TIMESTAMP(occured) as occured, `details` FROM `" . $this->dbprefix . "log` INNER JOIN `" . $this->dbprefix . "client` ON clientid = creator WHERE creator=" . $clientID . " AND parentclientid = " . $this->adminid;

		$retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

		if(DB::isError($retVal)) $this->SqlError($query,$retVal);

		return $retVal;
	}

	function FetchLogItems_Login($clientID=0,$date=null) {
		
		$query = "SELECT `logid` , `creator` , `targetid` , `targettype` , `eventid` , UNIX_TIMESTAMP(occured) as occured, `details`, `company` FROM `" . $this->dbprefix . "log` INNER JOIN `" . $this->dbprefix . "client` ON clientid = targetid WHERE eventid IN ( 10,11 ) AND parentclientid = " . $this->adminid;
        
        if ($clientID)
            $query .= " AND clientID = " . $clientID;

        $query .= " ORDER BY occured";

		$retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

		if(DB::isError($retVal)) $this->SqlError($query,$retVal);

		return $retVal;
	}
	function SearchClients($criteria, $qs, $access='client') {

		for ($i=0, $end=sizeof($qs), $subq=''; $i<$end; $i++) {
			$subq .= $criteria . " LIKE '%{$qs{$i}}%'"; 
			$subq .= ($i != ($end-1)) ? ' OR ' : '';
		}

        $query = "SELECT * FROM " . $this->dbprefix . "client WHERE ($subq) AND visible = '1' AND access = '$access' AND parentclientid = " . $this->adminid;

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function InsertNote($clientID, $content, $private) {

        if ($private) {
            $private = 'yes';
        } else {
            $private = 'no';
        }

        $query = "INSERT INTO " . $this->dbprefix . "note (s_clientid, r_clientid, content, posted, isprivate) VALUES (" . $this->adminid . "," . $clientID . ",'" . addslashes($content) . "',NOW(),'" . $private . "');";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function DeleteNote($noteID) {

        $query = "DELETE FROM " . $this->dbprefix . "note WHERE noteid = " . $noteID;

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function GetNotes($clientID=null) {
        
        if (!$clientID) {
            $where = '1';
        } else {
            $where = 'r_clientid = ' . $clientID;
        }

        $query = "SELECT noteid, r_clientid, content, UNIX_TIMESTAMP(posted) as posted, isprivate FROM " . $this->dbprefix . "note WHERE " . $where . " ORDER BY posted DESC";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function GetUserNotes() {
        
        $query = "SELECT noteid, r_clientid, content, UNIX_TIMESTAMP(posted) as posted, isprivate FROM " . $this->dbprefix . "note WHERE r_clientid = " . $this->adminid . " AND isprivate = 'no' ORDER BY posted DESC";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;

    }

    function GetPayments($clientID) {
        if (!$clientID) {
            $where = '1';
        } else {
            $where = 'c.clientid = ' . $clientID;
        }

        $query = "SELECT `paymentid` , p.`invoiceid` , `invoice_num`, p.`clientid`, `company` , `amount` , `method` , UNIX_TIMESTAMP(made_on) as made_on FROM " . $this->dbprefix . "payment p INNER JOIN " . $this->dbprefix . "client c USING ( clientid ) LEFT JOIN " . $this->dbprefix . "invoice i ON i.invoiceid = p.invoiceid WHERE " . $where . " ORDER BY made_on DESC";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;        
    }

    function InsertPayment( $clientID, $invoiceID, $amount, $method) {

        $query = "INSERT INTO " . $this->dbprefix . "payment (clientid, invoiceid, amount, method, made_on) VALUES (" . $clientID . "," . $invoiceID . ",'" . $amount . "','" . addslashes($method) . "',NOW());";

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;

    }

    function DeletePayment($paymentID) {

        $query = "DELETE FROM " . $this->dbprefix . "payment WHERE paymentid = " . $paymentID;

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;
    }

    function FetchPaygates() {
        $query = "SELECT * FROM " . $this->dbprefix . "paygate ORDER BY company";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function FetchRecurrances() {
        $query = "SELECT `recurranceid` , `invoiceid` , `days` , `months` , UNIX_TIMESTAMP(`until`) as until, action FROM `" . $this->dbprefix . "recurrance`";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return $retVal;
    }

    function EnablePaygate($paygateID,$enabled) {
        $status = ($enabled) ? 'yes' : 'no';

        $query = "UPDATE " . $this->dbprefix . "paygate SET enabled = '" . $status . "' WHERE paygateid = " . $paygateID;

        $retVal = $this->db->query($query);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        return true;        
    }

    function AdminStats() {
        $query = "SELECT `logid` , `creator` , `targetid` , `targettype` , `eventid` , UNIX_TIMESTAMP(occured) as occured, `details`, `company` FROM `" . $this->dbprefix . "log` INNER JOIN `" . $this->dbprefix . "client` ON clientid = targetid WHERE eventid IN ( 10,11 ) AND `occured` >= '" . date('Y-m-d h:i:s',strtotime("1 day ago")) . "' AND parentclientid = " . $this->adminid;

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        $stats['logins'] = $retVal;

        $query = "SELECT `paymentid` , p.`invoiceid` , `invoice_num`, p.`clientid`, `company` , `amount` , `method` , UNIX_TIMESTAMP(made_on) as made_on FROM " . $this->dbprefix . "payment p INNER JOIN " . $this->dbprefix . "client c USING ( clientid ) LEFT JOIN " . $this->dbprefix . "invoice i ON i.invoiceid = p.invoiceid WHERE `made_on` >= '" . date('Y-m-d h:i:s',strtotime("1 day ago")) . "' ORDER BY made_on DESC";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        $stats['payments'] = $retVal;

        $query = "SELECT (IFNULL( SUM( ii.cost * iii.qty ) , 0 ) + ( shipping ) ) * ( 1 + ( tax /100 ) ) * ( 1 + ( tax2 /100 ) ) AS total FROM " . $this->dbprefix . "invoice i INNER JOIN " . $this->dbprefix . "client c ON i.clientid = c.clientid LEFT JOIN " . $this->dbprefix . "invoice_invoiceitem AS iii ON i.invoiceid = iii.invoiceid LEFT JOIN " . $this->dbprefix . "invoiceitem AS ii ON ii.invoiceitemid = iii.invoiceitemid WHERE i.visible = '1' AND parentclientid = " . $this->adminid . " AND `curr_status` NOT LIKE 'fully paid'";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        $stats['owed'] = $retVal;

        $query = "SELECT c.clientid,company,i.invoiceid, invoice_num,UNIX_TIMESTAMP(issue_date) as issue_date,UNIX_TIMESTAMP(due_date) as due_date,SUM(ii.cost*iii.qty) as cost , (SUM(ii.cost*iii.qty)+(shipping))*(tax/100) as tax, (SUM(ii.cost*iii.qty)+(shipping))*(tax2/100) as tax2, shipping , (IFNULL(SUM(ii.cost*iii.qty),0)+(shipping))*(1+(tax/100))*(1+(tax2/100)) as total,curr_status FROM " . $this->dbprefix . "invoice i INNER JOIN " . $this->dbprefix . "client c ON i.clientid = c.clientid LEFT JOIN " . $this->dbprefix . "invoice_invoiceitem as iii ON i.invoiceid = iii.invoiceid LEFT JOIN " . $this->dbprefix . "invoiceitem as ii ON ii.invoiceitemid = iii.invoiceitemid WHERE i.visible = '1' AND parentclientid = " . $this->adminid . " AND `curr_status` LIKE 'overdue' GROUP BY iii.invoiceid, i.invoiceid ORDER BY due_date";

        $retVal = $this->db->getAll($query,null,DB_FETCHMODE_ASSOC);

        if(DB::isError($retVal)) $this->SqlError($query,$retVal);

        $stats['overdue'] = $retVal;
        
        return $stats;
    }
}

?>
