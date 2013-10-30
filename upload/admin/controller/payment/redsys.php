<?php
class ControllerPaymentRedsys extends Controller {

	public function index() {
		$this->load->language('payment/redsys');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {		
			$this->model_setting_setting->editSetting('redsys', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_merchantCode'] = $this->language->get('entry_merchantCode');
		$this->data['entry_terminal'] = $this->language->get('entry_terminal');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_process_failed'] = $this->language->get('entry_process_failed');
		$this->data['entry_send_mail_to_cutomer'] = $this->language->get('entry_send_mail_to_cutomer');
		$this->data['entry_send_mail_to_store_owner'] = $this->language->get('entry_send_mail_to_store_owner');
		$this->data['entry_completed_status'] = $this->language->get('entry_completed_status');	
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/redsys', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/redsys', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['redsys_merchantCode'])) {
			$this->data['redsys_merchantCode'] = $this->request->post['redsys_merchantCode'];
		} else {
			$this->data['redsys_merchantCode'] = $this->config->get('redsys_merchantCode');
		}
		
		if (isset($this->request->post['redsys_terminal'])) {
			$this->data['redsys_terminal'] = $this->request->post['redsys_terminal'];
		} else {
			$this->data['redsys_terminal'] = $this->config->get('redsys_terminal');
		}

		if (isset($this->request->post['redsys_password'])) {
			$this->data['redsys_password'] = $this->request->post['redsys_password'];
		} else {
			$this->data['redsys_password'] = $this->config->get('redsys_password');
		}
		
		if (isset($this->request->post['redsys_test'])) {
			$this->data['redsys_test'] = $this->request->post['redsys_test'];
		} else {
			$this->data['redsys_test'] = $this->config->get('redsys_test');
		}
		
		if (isset($this->request->post['redsys_process_failed'])) {
			$this->data['redsys_process_failed'] = $this->request->post['redsys_process_failed'];
		} else {
			$this->data['redsys_process_failed'] = $this->config->get('redsys_process_failed');
		}

		if (isset($this->request->post['redsys_completed_status_id'])) {
			$this->data['redsys_completed_status_id'] = $this->request->post['redsys_completed_status_id'];
		} else {
			$this->data['redsys_completed_status_id'] = $this->config->get('redsys_completed_status_id');
		}
		
		if (isset($this->request->post['redsys_failed_status_id'])) {
			$this->data['redsys_failed_status_id'] = $this->request->post['redsys_failed_status_id'];
		} else {
			$this->data['redsys_failed_status_id'] = $this->config->get('redsys_failed_status_id');
		}
		
		if (isset($this->request->post['redsys_send_mail_to_cutomer'])) {
			$this->data['redsys_send_mail_to_cutomer'] = $this->request->post['redsys_send_mail_to_cutomer'];
		} else {
			$this->data['redsys_send_mail_to_cutomer'] = $this->config->get('redsys_send_mail_to_cutomer');
		}
		
		if (isset($this->request->post['redsys_send_mail_to_store_owner'])) {
			$this->data['redsys_send_mail_to_store_owner'] = $this->request->post['redsys_send_mail_to_store_owner'];
		} else {
			$this->data['redsys_send_mail_to_store_owner'] = $this->config->get('redsys_send_mail_to_store_owner');
		}

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['redsys_geo_zone_id'])) {
			$this->data['redsys_geo_zone_id'] = $this->request->post['redsys_geo_zone_id'];
		} else {
			$this->data['redsys_geo_zone_id'] = $this->config->get('redsys_geo_zone_id');
		} 
		
		$this->load->model('localisation/geo_zone');
									
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['redsys_status'])) {
			$this->data['redsys_status'] = $this->request->post['redsys_status'];
		} else {
			$this->data['redsys_status'] = $this->config->get('redsys_status');
		}
		
		if (isset($this->request->post['redsys_sort_order'])) {
			$this->data['redsys_sort_order'] = $this->request->post['redsys_sort_order'];
		} else {
			$this->data['redsys_sort_order'] = $this->config->get('redsys_sort_order');
		}
		
		$this->template = 'payment/redsys.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/redsys')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>