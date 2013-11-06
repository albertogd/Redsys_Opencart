<?php
class ControllerPaymentRedsys extends Controller {

	protected function index() {	
	
		// Redsys Config
		$this->data['action'] = $this->config->get('redsys_test') ? 'https://sis-t.redsys.es:25443/sis/realizarPago' : 'https://sis.sermepa.es/sis/realizarPago';	
		$this->data['terminal'] = $this->config->get('redsys_terminal');
		$this->data['merchantCode'] = $this->config->get('redsys_merchantCode');
		$password = $this->config->get('redsys_password');
		
		// Order Info
		$this->data['order'] = sprintf('%012d', $this->session->data['order_id']);
		$this->data['currency'] = '978';
		$this->currency->set('EUR');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$this->data['amount'] =  str_replace(array('.', ',') , '', $this->currency->format($order_info['total'], FALSE, FALSE, FALSE));
		$this->data['transaction_type'] = 0;
		
		// Language
		switch($this->language->get('code'))
		{
			case 'es':	$this->data['language'] = '001';
						break;
			
			case 'en':	$this->data['language'] = '002';
						break;
			
			case 'ca':	$this->data['language'] = '003';
						break;
						
			case 'fr':	$this->data['language'] = '004';
						break;
						
			case 'de':	$this->data['language'] = '005';
						break;
						
			default:	$this->data['language'] = '002';
		}
		
		// Urls
		$this->data['merchant_url'] = $this->url->link('payment/redsys/callback');
		$this->data['url_ok'] = $this->url->link('checkout/success');
		$this->data['url_ko'] = $this->url->link('checkout/error');
		
		// Button
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		
		// Signature: 0 = Complete SHA-1 || 1 = Extended Complete SHA-1
		if($this->config->get('redsys_digest'))
			$message = $this->data['amount'] . $this->data['order'] . $this->data['merchantCode'] . $this->data['currency'] . $this->data['transaction_type'] . $this->data['merchant_url'] . $password;
		else
			$message = $this->data['amount'] . $this->data['order'] . $this->data['merchantCode'] . $this->data['currency'] . $password;
			
		$this->data['signature'] = strtoupper(sha1($message));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/redsys.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/redsys.tpl';
		} else {
			$this->template = 'default/template/payment/redsys.tpl';
		}	

		$this->render();		
	}
	
	
	public function callback() {
	
		// Check if mandatory vars are sent
		if(!$this->areset('Ds_MerchantCode', 'Ds_Terminal', 'Ds_Order', 'Ds_Amount', 'Ds_Currency', 'Ds_TransactionType', 'Ds_Response', 'Ds_Signature'))
			return;
		
		$merchantCode = $this->request->post['Ds_MerchantCode'];
		$terminal = $this->request->post['Ds_Terminal'];
		$order = $this->request->post['Ds_Order'];
		$amount = $this->request->post['Ds_Amount'];
		$currency = $this->request->post['Ds_Currency'];
		$transaction = $this->request->post['Ds_TransactionType'];
		$response = $this->request->post['Ds_Response'];
		$signature = $this->request->post['Ds_Signature'];
		
		// Merchant Code Check
		if ($merchantCode != $this->config->get('redsys_merchantCode'))
			return;
			
		// Terminal Check
		if ($terminal != $this->config->get('redsys_terminal'))
			return;
			
		// Check Currency
		if ($currency != '978')
			return;
			
		// Check Amount
		$order_id = ltrim($order, '0');
		$this->load->model('checkout/order');
		$this->currency->set('EUR');
		$order_info = $this->model_checkout_order->getOrder($order_id);
		$order_amount = $this->currency->format($order_info['total'], FALSE, FALSE, FALSE);
		
		if ($amount != str_replace(array('.', ','), '', $order_amount))
			return;
				
		// Check Signature
		$password = $this->config->get('redsys_password');
		$message = $amount . $order . $merchantCode . $currency . $response . $password;
		
		if ($signature != strtoupper(sha1($message)))
			return;
			
		// Check Autorization Type
		if($transaction != 0)
			return;
		
		// Response
		$accepted = ($response >= 0 && $response <= 99);
		$order_status_id = ($accepted) ? $this->config->get('redsys_completed_status_id') : $this->config->get('redsys_failed_status_id');
		
		// Set language		
		$language = new Language($order_info['language_directory']);
		$language->load($order_info['language_filename']);
		$language->load('payment/redsys');
		
		// Order Comment
		$this->load->model('localisation/country');
		
		$date = isset($this->request->post['Ds_Date']) ? $this->request->post['Ds_Date'] : $language->get('unknown');
		$hour =  isset($this->request->post['Ds_Hour']) ? $this->request->post['Ds_Hour'] : $language->get('unknown');
		$authCode = isset($this->request->post['Ds_AuthorisationCode']) ? $this->request->post['Ds_AuthorisationCode'] : $language->get('unknown'); 
		$country_card = isset($this->request->post['Ds_Card_Country']) ? $this->model_localisation_country->getCountryByISO($language->get('country_n_' . $this->request->post['Ds_Card_Country'])) : $language->get('unknown');
		$card_type = isset($this->request->post['Ds_Card_Type']) ? ($this->request->post['Ds_Card_Type'] == 'C' ? $language->get('credit') : $language->get('debit')) : $language->get('unknown');
		$secure = isset($this->request->post['Ds_SecurePayment']) ? ($this->request->post['Ds_SecurePayment'] == 1 ? $language->get('yes') : $language->get('no')) : $language->get('unknown');
		$error = isset($this->request->post['Ds_ErrorCode']) ? ($this->request->post['Ds_ErrorCode']) : $language->get('unknown');
		
		if($accepted) {	
			$message_for_store_owner  = sprintf($language->get('payment_accepted'), $date, $hour, $order_amount, 'EUR', $authCode, $card_type, $country_card, $secure);
		} else {
			$message_for_store_owner  = sprintf($language->get('payment_denied'), $language->get('err_n_' . $response), $error);
		}
		
		// Confirm/Update order state
		if($accepted) {
			if (!$order_info['order_status_id'])
				$this->model_checkout_order->confirm($order_id, $order_status_id, '', TRUE, $message_for_store_owner);
			else
				$this->model_checkout_order->update($order_id, $order_status_id, '', TRUE);
		}
		else
		{
			if($this->config->get('redsys_process_failed') == 1)
				$this->model_checkout_order->confirm($order_id, $order_status_id, '', TRUE, $message_for_store_owner);
			else
			{
				if($this->config->get('redsys_send_mail_to_cutomer'))
					$this->model_checkout_order->sendCustomerMail($order_id, $order_status_id, '', TRUE);
				
				if($this->config->get('redsys_send_mail_to_store_owner'))
					$this->model_checkout_order->sendStoreOwnerMail($order_id, $order_status_id, $message_for_store_owner, TRUE);
			}
		}
	}
	
	private function areset() {
		$numargs = func_num_args();
		$arg_list = func_get_args();
		
		for ($i = 0; $i < $numargs; $i++) {
			if(!isset($this->request->post[$arg_list[$i]]))
				return false;
		}
		
		return true;
	}

}
?>