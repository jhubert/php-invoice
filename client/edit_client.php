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

securePage('client');

$clientID = $_SESSION['ses_client_id'];
$access = isset($_REQUEST['access']) ? $_REQUEST['access'] : 'client';

$tpl = & new TemplateSystem();

$tpl->set('page_title',$lang['pt_edit_account']);

if(isset($_POST['submit']))
{

        $client = $ISL->fetchClientDetails($clientID);

        foreach($_POST as $key=>$val) {
            $client[$key] = $val;
        }

        $ISL->UpdateClient($clientID,$client);

        logItem($_SESSION['ses_client_id'],$clientID,2,7);

        $tpl->set('message',sprintf($lang['account_updated'],'index.php'));

    $tpl->set('tbody','action_complete.tpl');

} else {

    if ($clientID) {
        $client = $ISL->FetchClientDetails($clientID);
    } else {
        $client = array(
            'visible'=>1,
            'access'=>'client',
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
            'language'=>$_SESSION['ses_lang'],
            'def_tax'=>'',
            'def_tax2'=>'',
            'def_terms'=>'',
            'def_comments'=>'',
            'terms_days'=>'30'
        );
    }

    $tpl->set('templateDD',getTemplatesDD($client['template']));
    $tpl->set('languageDD',getLanguagesDD($client['language']));

    $tpl->set('client',$client);

    $tpl->set('tbody','client/edit_client.tpl');
}

$tpl->display();
?>