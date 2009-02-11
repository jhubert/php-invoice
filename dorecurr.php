<?php
/*
Recurring Billing
------------------

Database Items
---------------
Item to recurr
day
month
year

Items always recurr via cron job on day specified

Every Day
Every Week on X Day
Every Month on X day
Every X Months on X Day
The 1st and the 15th of every month
The 1st and the 15th of every X month
Every year on X month and X Day

Month
*,1,2,3,4,5,6,7,8,9,10,11,12

Day
*,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31

Year

Table - recurrance
-----------
recurranceid - int
invoiceid - int
days - varchar(61)
months - varchar(23)
until - date  (Selected as UNIXTIMESTAMP)
action - ENUM('mail','create')
*/

define('SITE_ROOT','./');
require_once(SITE_ROOT . 'includes/common.php');

$recurringItems = $ISL->FetchRecurrances();

print_r($recurringItems);

foreach($recurringItems as $recurr) {
	if ($recurr['until'] >= time()) {

        if (parseCron($recurr['days'], $recurr['months'])) {
            error_reporting(E_ALL);
            $mainInvoice = $ISL->FetchInvoiceDetails($recurr['invoiceid']);

            // increse InvoiceID             
            $mainInvoice['invoiceid'] = $ISL->FindNewInvoiceNumber($recurr['invoiceid'],$mainInvoice['invoiceid']);

            // increase due date
            // change issue date
            // fetch invoiceItems and modify as necessary

            $newInvoiceID = $ISL->InsertInvoice($mainInvoice);

            if ($recurr['action'] == 'mail')
                file(SITE_ROOT . 'mail.php?id=' . $newInvoiceID);

            unset($mainInvoice);
            unset($newInvoiceID);
        }
    }
}


function parseCron($day,$month) {
	$today = array();	
	$today['day'] = date('d');
	$today['month'] = date('m');

	if (!findMatch(date('d'),split(',',$day))) return false;
	if (!findMatch(date('m'),split(',',$month))) return false;
	
	return true;	
}

// cycle through the array to check if the d|m value is found.  
function findMatch($needle,$haystack) {
    print_r($haystack);
    // If * (0) is set, return true
    if ($haystack[0]) return true;
	foreach($haystack as $key=>$val) {		
        echo "true";
        // if the value is true, and the key matches the needle, return true
		if ($val && $key === $needle) return true;
	}
    echo "false";
	// nothing is found, return false
	return false;
}