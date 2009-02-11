<?
/***************************************************************************
					ipn/paypal.php
					------------
	product			: TypicalInvoice Professional Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Handles the reply from PayPal. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

// read the post from PayPal system and add 'cmd'
$pp_return = '';
$pp_send = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $pp_return = "$key=$value&";
    $pp_send  .= "&$key=$value";
}

// post back to PayPal system to validate
//$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header = "POST /testing/ipntest.php HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($pp_send) . "\r\n\r\n";
//$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
$fp = fsockopen ('www.eliteweaver.co.uk', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
    // HTTP ERROR
} else {
    fputs ($fp, $header . $pp_send);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        echo $res . "<br>";
        if (strcmp ($res, "VERIFIED") == 0) {
            // check the payment_status is Completed
            if (strtolower($payment_status) == 'completed') {
                // check that txn_id has not been previously processed
                // check that receiver_email is your Primary PayPal email
                // check that payment_amount/payment_currency are correct
                // process payment
                list($clientID,$invoiceID) = split('_',$item_number);
                $ISL->InsertPayment($clientID,$invoiceID,$payment_amount,'paypal');
                echo "Thank you for the payment."
            }
        } else if (strcmp ($res, "INVALID") == 0) {
            // log for manual investigation
            echo "There was an issue with the the PayPal Processing.  An e-mail has been sent to the administrator with details.";
            send_mail("Typical Invoice Error", EMAIL_ERR, EMAIL_ERR, "PayPal IPN Error", implode("<br>",$_GLOBAL))
        }
    }
    fclose ($fp);
}

function send_mail($myname, $myemail, $contactemail, $subject, $message) {
  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \"".$myname."\" <".$myemail.">\n";
  return(mail($contactemail, $subject, $message, $headers));
}
?>
