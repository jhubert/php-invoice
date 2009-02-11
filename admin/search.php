<?
/***************************************************************************
					search.php
					------------
	product			: PHP Invoice
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright &copy; 2001-2009 Jeremy Hubert
	email			: support@illanti.com
	website			: http://www.illanti.com

    Search module

***************************************************************************/

define('SITE_ROOT','../');
require_once(SITE_ROOT . 'includes/common.php');

securePage('admin');

$tpl =& new TemplateSystem($tpl_main_file, $tpl_folder, $lang);
$tpl->set('SYSTEM',$SYSTEM);

// variables for search parameters
$qs = isset($_GET['query']) ? explode(' ', $_GET['query']) : false;
$search_type = isset($_GET['sub']) ? $_GET['sub'] : 'invoice';
$criteria = isset($_GET['criteria']) ? $_GET['criteria'] : '';
$param = isset($_GET['param']) ? $_GET['param'] : 'invoice_num' ;
$quick_search = isset($_GET['quick_search']) ? true : false;

// pagination
$page = ((isset($_GET['page'])) && (preg_match("/[0-9]+$/",$_GET['page']))) ? $_GET['page'] : 0;
$show = ((isset($_GET['show'])) && (preg_match("/[0-9]+$/",$_GET['show']))) ? $_GET['show'] : $invoicerpp;
$tpl->set('p_start', $page * $show);
$tpl->set('p_end', (($page + 1) * $show));
$tpl->set('page', $page);
$tpl->set('show', $show);

$message = "";
$totals = array();
switch ($search_type) {
	case 'invoice':
		if ($qs) {
			for ($i=0, $end=sizeof($qs), $subq="("; $i<$end; $i++) {
				$subq .= "i.".$criteria . " LIKE '%{$qs{$i}}%'";
				$subq .= ($i != ($end-1)) ? ' OR ' : '';
			}
			$subq .= ")";
			$search_results = $ISL->FetchInvoices($page,$param,$subq);
			$r_count = count($search_results);
			if (($r_count == 1)&&($quick_search)) {
				header('Location: invoice.php?id='.$search_results[0]['invoiceID']);
				exit;
			}
            $totals['invoices'] = count($search_results);
            $totals['tax'] = 0;
            $totals['tax2'] = 0;
            $totals['shipping'] = 0;
            $totals['cost'] = 0;

            foreach($search_results as $key=>$inv) {
                $totals['tax'] += $inv['tax'];
                $totals['tax2'] += $inv['tax2'];
                $totals['shipping'] += $inv['shipping'];
                $totals['cost'] += $inv['cost'];
                $search_results[$key]['issue_date'] = date($SYSTEM["regional"]["invoicedate"],$inv['issue_date']);
                $search_results[$key]['due_date'] = date($SYSTEM["regional"]["invoicedate"],$inv['due_date']);
                $search_results[$key]['tax'] = currency_format($inv['tax']);
                $search_results[$key]['tax2'] = currency_format($inv['tax2']);
                $search_results[$key]['shipping'] = currency_format($inv['shipping']);
                $search_results[$key]['cost'] = currency_format($inv['cost']);
                $search_results[$key]['total'] = currency_format($inv['total']);
            }
            $totals['total'] = $totals['cost'] + $totals['tax'] + $totals['tax2'] + $totals['shipping']; 

            $totals['cost'] = currency_format($totals['cost']);
            $totals['tax'] = currency_format($totals['tax']);
            $totals['tax2'] = currency_format($totals['tax2']);
            $totals['shipping'] = currency_format($totals['shipping']);
            $totals['total'] = currency_format($totals['total']);

			$message = sprintf($lang['search_results'],$_GET['query'],$_GET['criteria'],$r_count);

			$tpl->set('search_params', "&query=" . $_GET['query'] . "&criteria=" . $_GET['criteria']);
			$tpl->set('r_count', $r_count);
            $tpl->set('search_results', $search_results);
		}

		$tpl->set('page_title', $lang['pt_search_invoices']);
		$tpl->set('tbody','admin/search_invoices.tpl');
        $tpl->set('totals',$totals);
		break;
	case 'client':
		if ($qs) {
			$search_results = $ISL->SearchClients($criteria, $qs);
			$r_count = sizeof($search_results);
			if (($r_count == 1)&&($quick_search)) {
				header('Location: view_client.php?id='.$search_results[0]['clientid']);
				exit;
			}
			$message = sprintf($lang['search_results'],$_GET['query'],$_GET['criteria'],$r_count);
			$tpl->set('search_results', $search_results);
			$tpl->set('r_count', $r_count);
			$tpl->set('search_params', "&query={" . $_GET['query'] . "&criteria=" . $_GET['criteria']);
		}
		$tpl->set('page_title', $lang['pt_search_clients']);
		$tpl->set('tbody','admin/search_clients.tpl');
		break;
	default:
		die('whatever');
		break;
}

$tpl->set('message', $message);
//$tpl->set('results', $results);

$tpl->display();
exit;

?>
