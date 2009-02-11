<?php
/*
function processRecurrance($values) {

	$days = array();
	for($x=0;$x<=31;$x++)
		$days[$x] = (in_array($x,$values['days'])) ? 1 : 0;

	$months = array();
	for($x=0;$x<=12;$x++)
		$months[$x] = (in_array($x,$values['months'])) ? 1 : 0;

	$days = implode(',',$days);
	$months = implode(',',$months);
	$until = date('Y:m:d H:i:s',strtotime($values['until']));

	if ($values['id']) {
		$query = "UPDATE " . $this->dbprefix . "recurrance SET (months='" . $months . "',days='" . $days . "',until='" . $until . "', action='" . $action . "' WHERE recurranceid=" . $id . ";";
	} else {
		$query = "INSERT INTO " . $this->dbprefix . "recurrance (invoiceid, months, days, until, action) VALUES ('" . $values['invoiceid'] . "','" . $months . "','" . $days . "','" . $values['until'] . "','" . $values['action'] . "');";
	}
	
	$result = $this->db->query($query);

	if (DB:ERROR($result)) $this->sql_error($result);

	return true;
}


*/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$invoiceid = isset($_REQUEST['iid']) ? $request['iid'] : 0;
$message = '';

if (isset($_POST['submit']) {
	if (!$_POST['invoiceid'])
		$message .= $lang['req_invoiceid'] . "<br />";		
	
	if (!$message) {
		$ISL->processRecurrance($_POST);
		
		if (isset($_POST['redir']) && $_POST['redir'])
			header('Location: ' . $_POST['redir']);
			exit;
		else
			$message = $lang['saved'];
	} else {
		$recurrance = $_POST;
	}
} 

if (!$recurrance) {
	if ($id) {

		$recurrance = $ISL->FetchRecurranceDetails($id);

	} else {
		$recurrance = array();
		$recurrance['invoiceid'] = $invoiceid;
		$recurrance['id'] = $id;
	}
}

$days = split(',',$recurrance['days']);
$months = split(',',$recurrance['months']);

$sel_months = "<option value='0'>*</option>";

for($x=1;$x<=12;$x++) {
	$s = (in_array($x,$months)) ? ' selected' : '';
	$sel_months .= "<option value='$x'$s>" . date('M',strtotime('01/' . $x . '/2003')) . "</option>";
}

$sel_days = "<option value='0'>*</option>";

for($x=1;$x<=31;$x++) {
	$s = (in_array($x,$days)) ? ' selected' : '';
	$sel_days .= "<option value='$x'$s>" . date('D',strtotime($x . '/01/2003')) . "</option>";
}

if ($recurrance['action'] == 'mail') }
	$s_mail = ' selected';
	$s_create = '';
} else {
	$s_mail = '';
	$s_create = ' selected';
}

$sel_action = "<option value='create'$s_create>" . $lang['create'] . "</option>";
$sel_action .= "<option value='mail'$s_mail>" . $lang['mail'] . "</option>";

$tpl = new TemplateSystem();

$tpl->set('page_title',$lang['pt_add_recurrance']);
$tpl->set('recurrance',$recurrance);
$tpl->set('message',$message);
$tpl->set('sel_days',$sel_days);
$tpl->set('sel_months',$sel_months);
$tpl->set('sel_action',$sel_action);

$tpl->display();
exit;
?>