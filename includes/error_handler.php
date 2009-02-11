<?php
//custom error reporting
error_reporting(ERROR_LEVEL);

// user defined error handling function
function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {
	
    global $tpl;

    //echo $errno. " & " . $errmsg. " & " . $filename. " & " . $linenum. " & " . $vars;
    //echo "ERROR ".$errno;
    // set return value to 0
    $retVal = 0;

	// define secondary error display
	$e_html = "./error.html";

	// define email 
	$e_email_subj = "TypicalInvoice Error [automated response]";

	// define error log
	$log_severe = "e_severe.log";
	$log_general = "e_general.log";
	$log_notice = "e_notice.log";

	// define error types
	$e_severe = array(E_ERROR, E_CORE_ERROR, E_WARNING, E_COMPILE_ERROR, E_CORE_WARNING, E_COMPILE_WARNING);
	$e_general = array(E_USER_ERROR,E_USER_WARNING, E_PARSE);
	$e_user = array(E_USER_NOTICE, E_NOTICE);

    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    $errortype = array (
                1   =>  "Error",
                2   =>  "Warning",
                4   =>  "Parsing Error",
                8   =>  "Notice",
                16  =>  "Core Error",
                32  =>  "Core Warning",
                64  =>  "Compile Error",
                128 =>  "Compile Warning",
                256 =>  "User Error",
                512 =>  "User Warning",
                1024=>  "User Notice"
                );

    $err = "<errorentry>\n";
    $err .= "\t<datetime>".$dt."</datetime>\n";
    $err .= "\t<errornum>".$errno."</errornum>\n";
    $err .= "\t<errortype>".$errortype[$errno]."</errortype>\n";
    $err .= "\t<errormsg>".$errmsg."</errormsg>\n";
    $err .= "\t<scriptname>".$filename."</scriptname>\n";
    $err .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\n";
	$err .= "</errorentry>\n\n";
	if (in_array($errno, $e_severe)) {
		@error_log($err, 3, DIR_ERR.$log_severe);
		mail(EMAIL_ERR, $e_email_subj, $err);
        if (class_exists('TemplateSystem')) {
            if (is_object($tpl) && $tpl->parsing) {
                $tpl2 = new TemplateSystem();
                $tpl2->set('page_title','Error');
                $tpl2->set('err_msg', $errmsg);
                $tpl2->setMainFile('error_general.tpl');
                $tpl2->display();
            } else {
                // instantiate new template object
                $tpl = new TemplateSystem();
                $tpl->set('page_title','Error');
                $tpl->set('tbody','error_general.tpl');
                $tpl->set('err_msg', $errmsg);
                $tpl->display();
            }
        } else {
            die($errmsg);
        }
        die();
	}
	elseif (in_array($errno, $e_general)) {
		@error_log($err, 3, DIR_ERR.$log_general);
        if (class_exists('TemplateSystem')) {
            if (is_object($tpl) && $tpl->parsing) {
                $tpl2 = new TemplateSystem();
                $tpl2->set('page_title','Error');
                $tpl2->set('err_msg', $errmsg);
                $tpl2->setMainFile('error_user.tpl');
                $tpl2->display();
            } else {
                $tpl = new TemplateSystem();
                $tpl->set('page_title','Error');
                $tpl->set('tbody','error_user.tpl');
                $tpl->set('err_msg', $errmsg);
                $tpl->display();
            }
        } else {
            die($errmsg);
        }
        die();
    }
	elseif (in_array($errno, $e_user)) {
        //echo $errmsg. " & " . basename($filename). " & " . $linenum;
        //@error_log($err, 3, DIR_ERR.$log_notice);
	} 



}

// set custom error handler
$old_error_handler = set_error_handler("userErrorHandler");
?>
