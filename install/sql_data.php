<?

$sql = array();

$sql[] = "INSERT INTO `${db_prefix}client_seq` VALUES (1);";

$sql[] = "INSERT INTO `${db_prefix}invoice_num_seq` VALUES (${inum_start});";

$sql[] = "INSERT INTO `${db_prefix}invoiceitem_seq` VALUES (0);";

$sql[] = "INSERT INTO `${db_prefix}invoice_seq` VALUES (0);";

$sql[] = "INSERT INTO `${db_prefix}paygate` VALUES (1, 'PayPal', 'http://www.paypal.com/mrb/pal=N4VC5BJKLAGP8', 'paypalID,currency', 'paypal.tpl', 'yes');";

$sql[] = "INSERT INTO `${db_prefix}paygate` VALUES (2, '2checkout', 'http://www.2checkout.com/cgi-bin/aff.2c?affid=43982', 'sid', '2checkout.tpl', 'yes');";

$sql[] = "INSERT INTO `${db_prefix}paygate` VALUES (3, 'Cheque / Money Order', '', 'address', 'cheque.tpl', 'yes');";

?>