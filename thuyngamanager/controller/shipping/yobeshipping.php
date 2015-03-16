<?php
class ControllerShippingyobeshipping extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('shipping/yobeshipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//echo "<pre>"; print_r($this->request->post); echo "<pre>"; die();
			$this->model_setting_setting->editSetting('yobeshipping', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_shipping_title'] = $this->language->get('entry_shipping_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/yobeshipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/yobeshipping', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['yobeshipping'])) {
			$data['multiple_shippings']['yobeshipping'] = $this->request->post['yobeshipping'];
		} else {
			$data['multiple_shippings'] = $this->model_setting_setting->getSetting('yobeshipping');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();


		//Error
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		
		if (isset($this->error['shipping_option'])) {
			$data['error_shipping_option'] = $this->error['shipping_option'];
		} else {
			$data['error_shipping_option'] = array();
		}
		
		if (isset($this->request->post['yobeshipping_group_shipping'])) {
			$data['yobeshipping_group_shipping'] = $this->request->post['yobeshipping_group_shipping'];
		} else {
			$data['yobeshipping_group_shipping'] = $this->config->get('yobeshipping_group_shipping');
		}

		if (isset($this->request->post['yobeshipping_status'])) {
			$data['yobeshipping_status'] = $this->request->post['yobeshipping_status'];
		} else {
			$data['yobeshipping_status'] = $this->config->get('yobeshipping_status');
		}

		if (isset($this->request->post['yobeshipping_sort_order'])) {
			$data['yobeshipping_sort_order'] = $this->request->post['yobeshipping_sort_order'];
		} else {
			$data['yobeshipping_sort_order'] = $this->config->get('yobeshipping_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/yobeshipping.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/yobeshipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['yobeshipping_group_shipping'] as $language_id => $value) {
			if ((utf8_strlen($value['shipping_name']) < 1) || (utf8_strlen($value['shipping_name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if (isset($this->request->post['yobeshipping'])) {
			foreach ($this->request->post['yobeshipping'] as $shipping_id => $shipping) { 
				foreach ($shipping['shipping_description'] as $language_id => $shipping_description) {
					if ((utf8_strlen($shipping_description['name']) < 1) || (utf8_strlen($shipping_description['name']) > 64)) {
						$this->error['shipping_option'][$shipping_id][$language_id] = $this->language->get('error_shipping_option');
					}
				}
			}
		}
		return !$this->error;
	}
}