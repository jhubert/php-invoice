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

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

securePage('none');

$message = '';

$tpl_folder = "_core";

if (isset($_POST['submit'])) {

    switch($_POST['itemtype']) {

        case 'v1_invoice':
            define('COL_COUNT',8);
            break;
        case 'v1_client':
            define('COL_COUNT',10);
            break;
    }

    if (empty($_FILES['csvfile'] ['name'])) {
        //file has not been selected
        trigger_error("Please select a file to upload",E_USER_WARNING);
    }
    elseif (empty($_FILES['csvfile'] ['size'])) {
        //file has been selected, but file size is 0 bytes
        trigger_error("The file you selected is empty, please choose a non-empty file",E_USER_WARNING);
    }
    elseif (($_FILES['csvfile'] ['type'] != 'application/octet-stream') && (substr($_FILES['csvfile']['name'],-3) != 'csv')) {
        //file has been selected, but file size is 0 bytes
        trigger_error("You must upload a CSV file.  Please choose the correct file and retry.",E_USER_WARNING);
    } else {
		$fp = fopen ($_FILES['csvfile']['tmp_name'],"r");
		$data = fgetcsv ($fp, 1000, ',');
        $colcount = count($data);
        fclose ($fp);

        if ($colcount != COL_COUNT) {
                //file has been selected, but file size is 0 bytes
                trigger_error("Your CSV file doesn't have the correct amount of columns.  Please make sure it is complete.",E_USER_WARNING);
        } else {

            $fp = fopen ($_FILES['csvfile']['tmp_name'],"r");

            $data = array();

            while($data[] = fgetcsv ($fp, 1000, ','));

            array_pop($data);

            fclose ($fp);

            switch($_POST['itemtype']) {

                case 'v1_invoice':
                    $sql_invoice = "INSERT INTO " . $db_prefix . "invoice (invoiceid,invoice_num,clientid,due_date,issue_date,tax,curr_status,visible) VALUES ";
                    $sql_invoiceitem = "INSERT INTO " . $db_prefix . "invoice_invoiceitem (invoiceid,invoiceitemid,qty) VALUES ";
                    $sql_item = "INSERT INTO " . $db_prefix . "invoiceitem (invoiceitemid,details,cost) VALUES ";
                    $sql_itmp = "";
                    $sql_iiitmp = "";
                    $sql_iitmp = "";
                    $x=0;
                    foreach($data as $item) {
                        $iseq = $item[0];
                        $tax = $item[5] / $item[4] * 100;
                        $x++;
                        $sql_itmp .= "('".$item[0]."','".$item[0]."','".$item[1]."','".$item[2]."','".$item[2]."','".$tax."','".$item[6]."','".$item[7]."'),";
                        $sql_iiitmp .= "('" . $item[0] . "'," . $x . ",1),";
                        $sql_iitmp .= "(" . $x . ",'".$item[3]."','".$item[4]."'),";
                    }
                    $sql_invoice .= substr($sql_itmp,0,-1);
                    $sql_invoiceitem .= substr($sql_iiitmp,0,-1);
                    $sql_item .= substr($sql_iitmp,0,-1);
                    
                    $message .= " - " . runSQL($sql_invoice,'Invoices Imported');
                    $message .= " - " . runSQL($sql_item,"Invoice Items Imported<br>");
                    $message .= " - " . runSQL($sql_invoiceitem,"Invoice Item Joined To Invoice<br>");
                    
                    $sql = "UPDATE " . $db_prefix . "invoice_seq SET id = $iseq;";
                    $message .= " - " . runSQL($sql,"Invoice Sequence Updated<br>");
                    
                    $sql = "UPDATE " . $db_prefix . "invoice_num_seq SET id = $iseq;";
                    $message .= " - " . runSQL($sql,"Invoice Number Sequence Updated<br>");

                    $sql = "UPDATE " . $db_prefix . "invoiceitem_seq SET id = $x;";
                    $message .= " - " . runSQL($sql,"Invoice Item Sequence Updated<br>");
                    break;
                case 'v1_client':
                    $sql_client = "INSERT INTO " . $db_prefix . "client (clientid,parentclientid,username,passwd,email,address,def_tax,ref,company,access,visible) VALUES ";
                    $sql_ctmp = "";
                    $adminid = $data[0][0];
                    foreach($data as $item) {
                        $seq = $item[0];
                        $sql_ctmp .= "('".$item[0]."','".$adminid."','".$item[1]."','".$item[1]."','".$item[3]."','".$item[4]."','".$item[5]."','".$item[6]."','".$item[7]."','".$item[8]."','".$item[9]."'),";
                    }
                    $sql_client .= substr($sql_ctmp,0,-1);

                    $message .= " - " . runSQL($sql_client,"Clients Imported<br>");

                    $sql = "UPDATE " . $db_prefix . "client_seq SET id = $seq;";
                    $message .= " - " . runSQL($sql,"Client Sequence Updated<br>");
                    break;
            }

        }
    }


}

$tpl = & new TemplateSystem();

$tpl->set('page_title','Import');

$tpl->set('toptext','Import Your Data');
$tpl->set('bottomtext','');

$tpl->set('message',$message);

$tpl->set('tbody','import.tpl');

$tpl->display();
exit;

function runSQL($query,$return) {
    global $db;

    $result = $db->query($query);

    if(DB::isError($result)) {
        return "MYSQL error:  ".$result->getMessage()." in query:<br />".$query."<br />";
    } else {
        return $return;
    }
}

?>