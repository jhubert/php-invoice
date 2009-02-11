<?
/***************************************************************************
					edit_client.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Edit/Add a client. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = set($_REQUEST['cid'],0);
$noteID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$tpl = & new TemplateSystem();

$tpl->set('page_title','Notes');
$tpl->set('clientID',$clientID);

if(isset($_POST['submit']))
{

    $ISL->InsertNote($_POST['cid'],$_POST['content'],$_POST['isprivate']);

    $tpl->set('message',"<p>Note added</p>");

    $tpl->set('tbody','action_complete.tpl');

} elseif (isset($_GET['delete'])) {
    
    if ($noteID)
        $ISL->DeleteNote($noteID);

    $tpl->set('message',"<p>Note deleted</p>");
}


$notes = $ISL->GetNotes($clientID);

foreach($notes as $key=>$note) {
    $notes[$key]['posted'] = date($SYSTEM["regional"]["datetime"],$notes[$key]['posted']);
}

$tpl->set('notes',$notes);

$tpl->set('tbody','admin/edit_notes.tpl');


$tpl->display();
?>