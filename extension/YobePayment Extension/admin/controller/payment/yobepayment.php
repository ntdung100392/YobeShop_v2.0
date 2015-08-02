<?php 
class ControllerPaymentyobepayment extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/yobepayment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('yobepayment', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_rate'] = $this->language->get('tab_rate');

		$data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_edit'] = $this->language->get('text_edit');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_browse'] = $this->language->get('text_browse');
        $data['text_clear'] = $this->language->get('text_clear');
        $data['text_image_manager'] = $this->language->get('text_image_manager');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_yobepayment'] = $this->language->get('entry_yobepayment');
		$data['entry_total'] = $this->language->get('entry_total');	
		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_number_method'] = $this->language->get('entry_number_method');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_image'] = $this->language->get('entry_image');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }
		
		$this->load->model('localisation/language');

        $data['token'] = $this->session->data['token'];
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (isset($this->error['yobepayment_' . $language['language_id']])) {
				$data['error_yobepayment_' . $language['language_id']] = $this->error['yobepayment_' . $language['language_id']];
			} else {
				$data['error_yobepayment_' . $language['language_id']] = '';
			}
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/yobepayment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$data['action'] = $this->url->link('payment/yobepayment', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/language');

        for($i=1;$i<=$this->config->get('yobepayment_number_method');$i++)
        {

            if (isset($this->request->post['yobepayment_name'.$i])) {
                $data['yobepayment_name'.$i] = $this->request->post['yobepayment_name'.$i];
            } else {
                $data['yobepayment_name'.$i] = $this->config->get('yobepayment_name'.$i);
            }

            foreach ($languages as $language) {
                if (isset($this->request->post['yobepayment_' . $language['language_id']])) {
                    $data['yobepayment_' . $language['language_id'] . '_'.$i] = $this->request->post['yobepayment_' . $language['language_id'] . '_'.$i];
                } else {
                    $data['yobepayment_' . $language['language_id'] . '_'.$i] = $this->config->get('yobepayment_' . $language['language_id'] . '_'.$i);
                }
            }

            $data['languages'] = $languages;

            if (isset($this->request->post['yobepayment_image'.$i]) && !isset($this->error['image'])) {
                $data['yobepayment_image'.$i] = $this->request->post['yobepayment_image'.$i];
            } else {
                $data['yobepayment_image'.$i] = $this->config->get('yobepayment_image'.$i);
            }

            $this->load->model('tool/image');

            if (isset($this->request->post['yobepayment_image'.$i]) && file_exists(DIR_IMAGE . $this->request->post['yobepayment_image'.$i]) && !isset($this->error['image'])) {
                $data['thumb'.$i] = $this->model_tool_image->resize($this->request->post['yobepayment_image'.$i], 100, 100);
            } elseif (!empty($this->data['yobepayment_image'.$i]) && $data['yobepayment_image'.$i] && file_exists(DIR_IMAGE . $this->config->get('yobepayment_image'.$i))) {
                $data['thumb'.$i] = $this->model_tool_image->resize($this->config->get('yobepayment_image'.$i), 100, 100);
            } else {
                $data['thumb'.$i] = $this->model_tool_image->resize('no_image.png', 100, 100);
            }

            $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['yobepayment_order_status_id'])) {
            $data['yobepayment_order_status_id'] = $this->request->post['yobepayment_order_status_id'];
        } else {
            $data['yobepayment_order_status_id'] = $this->config->get('yobepayment_order_status_id');
        }

        if (isset($this->request->post['yobepayment_geo_zone_id'])) {
            $data['yobepayment_geo_zone_id'] = $this->request->post['yobepayment_geo_zone_id'];
        } else {
            $data['yobepayment_geo_zone_id'] = $this->config->get('yobepayment_geo_zone_id');
        }
		
		$this->load->model('localisation/geo_zone');
										
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['yobepayment_status'])) {
			$data['yobepayment_status'] = $this->request->post['yobepayment_status'];
		} else {
			$data['yobepayment_status'] = $this->config->get('yobepayment_status');
		}

		if (isset($this->request->post['yobepayment_sort_order'])) {
			$data['yobepayment_sort_order'] = $this->request->post['yobepayment_sort_order'];
		} else {
			$data['yobepayment_sort_order'] = $this->config->get('yobepayment_sort_order');
		}

        if (isset($this->request->post['yobepayment_number_method'])) {
            $data['yobepayment_number_method'] = $this->request->post['yobepayment_number_method'];
        } else {
            $data['yobepayment_number_method'] = $this->config->get('yobepayment_number_method');
        }

		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/yobepayment.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/yobepayment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

        $this->load->model('tool/image');

        for($i=1;$i<=$this->config->get('yobepayment_number_method');$i++)
        {
            foreach ($languages as $language) {

                if ((utf8_strlen($this->request->post['yobepayment_name'.$i]) < 2 )) {
                    $this->error['warning'] = $this->language->get('error_name');
                }

                if ((utf8_strlen($this->request->post['yobepayment_' . $language['language_id'].'_'.$i]) < 4 )) {
                    $this->error['warning'] = $this->language->get('error_western_union');
                }

                if (!$this->request->post['yobepayment_image'.$i]) {
                    $this->error['warning'] = $this->language->get('error_logo');
                }
            }

            return !$this->error;
        }

		return !$this->error;
	}
}
?>