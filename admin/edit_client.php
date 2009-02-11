<?
/***************************************************************************
					edit_client.php
					------------
	product			: TypicalInvoice Professional
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Edit/Add a client. DO NOT EDIT unless you know
    what you are doing.

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$clientID = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$set_access = isset($_REQUEST['acs']) ? $_REQUEST['acs'] : 'client';

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_edit_client']);

if(isset($_POST['submit']))
{

    if ($clientID) {

        $ISL->UpdateClient($clientID,$_POST);

        logItem($_SESSION['ses_client_id'],$clientID,2,7);

        $tpl->set('message',sprintf($lang['client_updated'],'clients.php'));

    } else {

        $clientID = $ISL->InsertClient($_POST);

        logItem($_SESSION['ses_client_id'],$clientID,2,6);

        $tpl->set('message',sprintf($lang['client_created'],'clients.php'));
    }

    $tpl->set('tbody','action_complete.tpl');

} else {

    if ($clientID) {
        $client = $ISL->FetchClientDetails($clientID);
    } else {
        $client = array(
            'visible'=>1,
            'access'=>$set_access,
            'clientid'=>0,
            'company'=>'',
            'firstname'=>'',
            'lastname'=>'',
            'contacttitle'=>'',
            'email'=>'',
            'address'=>'',
            'phonenumber'=>'',
            'faxnumber'=>'',
            'url'=>'',
            'logo'=>'',
            'account_num'=>'',
            'ref'=>'',
            'username'=>'',
            'passwd'=>'',
            'template'=>$_SESSION['ses_template'],
            'language'=>$_SESSION['ses_language'],
            'def_tax'=>'',
            'def_tax2'=>'',
            'term_days'=>'',
            'def_terms'=>'',
            'def_comments'=>'',
            'terms_days'=>'30'
        );
    }

    $tpl->set('templateDD',getTemplatesDD($client['template']));
    $tpl->set('languageDD',getLanguagesDD($client['language']));

    $tpl->set('client',$client);

    $tpl->set('tbody','admin/edit_client.tpl');
}

$tpl->display();
?>