<?php
    /**
     * Paypal IPN CakePHP component based on Micah Carrick <email@micahcarrick.com>
     * http://www.micahcarrick.com paypal_class
     *
     * @author Maulana Kurniawan <maulana.kurniawan@gmail.com>
     * @license Copyleft Maulana Kurniawan
     */

    class PaypalComponent extends Object{
        // Variable for payment request send
        var $options = array(
            'url'           => 'https://www.paypal.com/cgi-bin/webscr',
            'cmd'           => '_xclick',
            'lc'            => '',
            'currency_code' => 'USD',
            'business'      => '',
            'item_name'     => '',
            'item_number'   => '',
            'amount'        => '',
            'currency_code' => '',
            'return'        => '',
            'notify_url'    => '',
            'no_shipping'   => '',
            'no_note'       => '',
            'first_name'    => '',
            'last_name'     => '',
            'address1'      => '',
            'address2'      => '',
            'city'          => '',
            'zip'           => '',
            'night_phone_a' => '',
            'email'         => '',
            'custom'        => ''
        );

        // Variable that need to be filled before payment request send
        var $options_required = array(
            'url', 'cmd', 'business', 'item_name',
            'item_number', 'amount', 'return'
        );

        // holds the last error encountered
        var $last_error;

        // bool: log IPN results to text file?
        var $ipn_log;

        // filename of the IPN log
        var $ipn_log_file;

        // holds the IPN response from paypal
        var $ipn_response;

        // array contains the POST values for IPN
        var $ipn_data = array();

        function startup(&$controller){

        }

        function __construct() {
            parent::__construct();
        }

        function getFormData(){
            // Variable to hold data which we want to send
            $data = array();

            // Run through options and put it in data
            // if it has value(not empty)
            foreach($this->options as $name => $value){
                if(!empty($value)){
                    $data[$name] = $value;
                }
            }

            // Check required parameter before sending data
            foreach($this->options_required as $name){
                if(array_key_exists($name, $data) == false){
                    $this->log('PaypalComponent : '. $name .' data is required but not yet configured/filled');
                    return false;
                }
            }

            // Return data
            return $data;
        }

        // Configuring options for global use
        function configure($options = array()){
            foreach($options as $name => $value){
                $this->options[$name] = $value;
            }

            // Set last error if not configured by user
            if(empty($this->last_error)){
                $this->last_error = '';
            }

            // Set ipn log file path if not configured by user
            if(empty($this->ipn_log_file)){
                $this->ipn_log_file = 'ipn_log.log';
            }

            // Set ipn loggin if not set by user
            if(empty($this->ipn_log)){
                $this->ipn_log = false;
            }

            // Set ipn response to empty string to prevent notice/warning
            // from php
            if(empty($this->ipn_response)){
                $this->ipn_response = '';
            }
        }

        // Function to validate the ipn
        function validate_ipn() {
            // parse the paypal URL
            $url_parsed = parse_url($this->options['url']);

            // generate the post string from the _POST vars aswell as load the
            // _POST vars into an arry so we can play with them from the calling
            // script.
            $this->ipn_data = $_POST;

           /* // Read the post from PayPal and add 'cmd'
            $post_string = 'cmd=_notify-validate';
            if(function_exists('get_magic_quotes_gpc')){
                $get_magic_quotes_exits = true;
            }

            foreach ($_POST as $key => $value){
                // Handle escape characters, which depends on setting of magic quotes
                if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){
                    $value = urlencode(stripslashes($value));
                }else{
                    $value = urlencode($value);
                }
                $post_string .= "&$key=$value";
            }

            if ($url_parsed['scheme'] == 'https'){
                $url_parsed['port'] = 443;
                $ssl = 'ssl://';
            } else {
                $url_parsed['port'] = 80;
                $ssl = '';
            }

            // open the connection to paypal
            $fp = fsockopen($ssl.$url_parsed['host'], $url_parsed['port'], $err_num, $err_str, 30);
            if(!$fp) {
                // could not open the connection.  If loggin is on, the error message
                // will be in the log.
                $this->last_error = "fsockopen error no. $errnum: $errstr";
                $this->log_ipn_results(false);
                $this->log('cannot open socket');

                return false;
            } else {

                // Post the data back to paypal
                fputs($fp, "POST ".$url_parsed['path']." HTTP/1.1\r\n");
                fputs($fp, "Host: ".$url_parsed['host']."\r\n");
                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
                fputs($fp, "Content-length: ".strlen($post_string)."\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fputs($fp, $post_string . "\r\n\r\n");

                // loop through the response from the server and append to variable
                while(!feof($fp)) {
                    $this->ipn_response .= fgets($fp, 1024);
                }

                fclose($fp); // close connection

                if(eregi("VERIFIED",$this->ipn_response)) {
                    $success = true;
                } else {
                    $success = false;
                }
            }
*/
								// PHP 4.1
					
					// read the post from PayPal system and add 'cmd'
					$req = 'cmd=_notify-validate';
					
					foreach ($_POST as $key => $value) {
					$value = urlencode(stripslashes($value));
					$req .= "&$key=$value";
					}
					
					// post back to PayPal system to validate
					$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
					$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
					$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
					$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
					
					// assign posted variables to local variables
					$item_name = $_POST['item_name'];
					$item_number = $_POST['item_number'];
					$payment_status = $_POST['payment_status'];
					$payment_amount = $_POST['mc_gross'];
					$payment_currency = $_POST['mc_currency'];
					$txn_id = $_POST['txn_id'];
					$receiver_email = $_POST['receiver_email'];
					$payer_email = $_POST['payer_email'];
					
					if($payment_status=="Completed" or $payment_status=="completed" or $payment_status=="COMPLETED")
					{
					return true;
					}
					if (!$fp) {
					// HTTP ERROR
					} else {
					fputs ($fp, $header . $req);
					while (!feof($fp)) {
					$res = fgets ($fp, 1024);
					if (strcmp ($res, "VERIFIED") == 0) {
					 $success = true;
					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					}
					else if (strcmp ($res, "INVALID") == 0) {
					 $success = false;
					// log for manual investigation
					}
					}
					fclose ($fp);
					}

            if($success == true){
                // Valid IPN transaction.
                $this->log_ipn_results(true);
                return true;
            } else {
               // Invalid IPN transaction.  Check the log for details.
               $this->last_error = 'IPN Validation Failed.';
               $this->log_ipn_results(false);
               return false;
            }
        }

        function log_ipn_results($success) {
		$this->log(" in log result file:<br>");
            if (!$this->ipn_log){
                //return;  // is logging turned off?
            }

            // Timestamp
            $text = '['.date('m/d/Y g:i A').'] - ';
$this->log($text);
            // Success or failure being logged?
            if ($success){
                $text .= "SUCCESS!\n";
            }else{
                $text .= 'FAIL: '.$this->last_error."\n";
            }
$this->log($text);
            // Log the POST variables
            $text .= "IPN POST Vars from Paypal:\n";
            foreach ($this->ipn_data as $key=>$value) {
                $text .= "$key=$value, ";
            }
$this->log($text);
            // Log the response from the paypal server
            $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
			$this->log($text);
            // Write to log
           /* $fp = fopen($this->ipn_log_file,'a');
            fwrite($fp, $text . "\n\n");
            fclose($fp);  // close file*/
        }
    }
?>