<?php
class ModelShippingyobeshipping extends Model {
	function getQuote($address) {
		$this->load->language('shipping/yobeshipping');
		$this->load->model('setting/setting');
 		$custom_shippings = $this->model_setting_setting->getSetting('yobeshipping');

		$method_data = array();
		$status = $this->config->get('yobeshipping_status');
			$quote_data = array();
			if(!empty($custom_shippings['yobeshipping'])){
			foreach($custom_shippings['yobeshipping'] as $key => $custom_shipping){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$custom_shipping['yobeshipping_geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$custom_shipping['yobeshipping_geo_zone_id']) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		if ($status) {

			  $quote_data['yobeshipping_'.$key] = array(
				  'code'         => 'yobeshipping.yobeshipping_'.$key,
				  'title'        => $custom_shipping['shipping_description'][(int)$this->config->get('config_language_id')]['name'],
				  'cost'         => $custom_shipping['cost'],
				  'tax_class_id' => $custom_shipping['yobeshipping_tax_class_id'],
				  'text'         => $this->currency->format($this->tax->calculate($custom_shipping['cost'], $custom_shipping['yobeshipping_tax_class_id'], $this->config->get('config_tax')))
			  );
			}
		}
	}
	$titlearray = $this->config->get('yobeshipping_group_shipping'); 
			$method_data = array(
				'code'       => 'yobeshipping',
				'title'      => $titlearray[(int)$this->config->get('config_language_id')]['shipping_name'],
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('yobeshipping_sort_order'),
				'error'      => false
			);

		return $method_data;
	}
}