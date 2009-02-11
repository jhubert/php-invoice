<?
/*

include_once('./includes/lib/class.SendEmail.php');
$invoiceID=156;
$invoice = $ISL->FetchInvoiceDetails($invoiceID);
$client = $ISL->FetchClientDetails($invoice['clientid']);
$admin = $ISL->FetchAdminDetails($client['parentClientID']);

$e = new Emailer('forms/email_invoice.tpl', 'New Email', 'jon@typicalgeek.com');
$e->set('SYSTEM', $SYSTEM);
$e->set('invoice', $invoice);
$e->set('client', $client);
$e->set('admin', $admin);
$e->send('namonaki@shaw.ca', 'mail', 'High');
unset($e);
*/

class Emailer extends Template {
var $subject;
var $sender;
var $message;
var $errorMsg;
var $priority = 'normal';
var $method = 'mail';
var $recipient;
var $template;	

function Emailer() {
		global $tpl_main_file, $tpl_folder, $lang;

		$this->template_dir = SITE_ROOT . 'templates/'.$tpl_folder.'/';
        $this->default_dir = SITE_ROOT . "templates/_core/";

		// framework for the email layout
        $this->set('SITE_ROOT',SITE_ROOT);
        $this->set('HTTP_ROOT',HTTP_ROOT);
        $this->set('TEMPLATE_DIR',$this->template_dir);
        $this->set('IMAGE_DIR',$this->template_dir . 'images/');
        $this->set('lang',$lang);

        $this->set('session',$_SESSION);
	}
    
    function setFrom ($sender) {
        $this->from = $sender;
    }
	
    function setFromName ($name) {
        $this->fromName = $name;
    }

    function setRecipient($recipient) {
        $this->recipient = $recipient;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setPriority($priority) {
        $this->priority = $priority;
    }

    function useMail() {
        $this->method = 'mail';
    }

    function useSMTP() {
        $this->method = 'smtp';
    }

    function fetchMessage() {
        $this->message = $this->fetch();
        return true;
    }

    function appendMessage($message) {
        $this->message .= $message;
        return true;
    }

	function send($recipient=0) {

        if (!$this->message) {
            $this->errorMsg[] = "You must specify a message";
        }

        if (!$this->recipient) {
            if (!$recipient)
                $this->errorMsg[] = "You must specify a recipient";
            else 
                $this->recipient = $recipient;
        }

        if (count($this->errorMsg)) {
            return false;
        }

        $this->sender = (isset($this->fromName)) ? '"'.$this->fromName.'" <'.$this->from.'>' : $this->from;

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "X-Priority: 1\n";
		$headers .= "X-MSMail-Priority: {$this->priority}\n";
		$headers .= "X-Mailer: php\n";
		$headers .= "From: {$this->sender}\n";

		switch ($this->method) {
			case 'smtp':
				$result = 0;//dosmtp();
				break;
			default:
				$result = mail($this->recipient, $this->subject, $this->message, $headers);
				break;
		}
		return $result;
	}

}
/*

        global $tpl_main_file, $tpl_folder, $lang;

		$this->template_dir = SITE_ROOT . "templates/" . $tpl_folder . "/";
        $this->main_file = $tpl_main_file;

 //     $scriptName = set($_SERVER['SCRIPT_NAME'],'');
 //       $queryString = set($_SERVER['QUERY_STRING'],'');

//        $this->CachedTemplate($scriptName . $queryString);  

        $this->set('SITE_ROOT',SITE_ROOT);
        $this->set('HTTP_ROOT',HTTP_ROOT);
        $this->set('TEMPLATE_DIR',$this->template_dir);
        $this->set('IMAGE_DIR',$this->template_dir . 'images/');

        $this->set('lang',$lang);

        $this->set('session',$_SESSION);


class Emailer { 

	public $method;
	public $type;
	public $template;
	public $subject, $content;

	function Emailer($subj, &$template) {//$type='invoice',$method='mail' {
		$this->subject = $subj;
		$this->template = &$template;
	}

	function setTemplate($tpl) {
		$this->template->set('tbody', $tpl);
	}

	function send() {

		switch ($this->method) {
			case 'smtp':
				//send via smtp
				break;
			case 'mail':
				$this->mailSend();
				break;
			default:
				break;
		}
	}
}
*/
?>
