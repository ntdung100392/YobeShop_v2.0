<?php
class ModelPaymentYobePayment extends Model
{
    public function getMethod($address)
    {
        $this->load->language('payment/yobepayment');

        //$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('yobepayment_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

//              if ($this->config->get('yobepayment_total') > $total) {
//                      $status = false;
//              } elseif (!$this->config->get('yobepayment_geo_zone_id')) {
//                      $status = true;
//              } elseif ($query->num_rows) {
//                      $status = true;
//              } else {
//                      $status = false;
//              }
//
//              $method_data = array();
//
//
//
//      return $method_data;

        $method_data = array();
        $quote_data = array();


        for ($i = 1; $i <= $this->config->get('yobepayment_number_method'); $i++) {


            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('yobepayment_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

            if (!$this->config->get('yobepayment_geo_zone_id')) {
                $status = true;
            } elseif ($query->num_rows) {
                $status = true;
            } else {
                $status = false;
            }


            if (!$this->config->get('yobepayment_status')) {
                $status = false;
            }

            if (!$this->config->get('yobepayment_name' . $i)) {
                $status = false;
            }

            if ($status) {
                $this->load->model('tool/image');

//                $quote_data['yobepayment_name' . $i] = array(
//                    'code'  => $i,
//                    'title' => $this->config->get('yobepayment_name'. $i),
//                    'image' => $this->model_tool_image->resize($this->config->get('yobepayment_image'.$i), 100, 100)
//                );
                $method_data[$i] = array(
                    'code'  => 'yobepayment',
                    'title' => $this->config->get('yobepayment_name'. $i),
                    'terms'  => $this->config->get('yobepayment_' . $this->config->get('config_language_id') . '_' . $i),
                    'image' => $this->model_tool_image->resize($this->config->get('yobepayment_image'.$i), 100, 100),
                    'error' => ''
                );
            }
        }
        $method_data['title']=$this->language->get('text_title');
        $method_data['count']=$this->config->get('yobepayment_number_method');
        $method_data['code']='yobepayment';
        $method_data['sort_order']=$this->config->get('yobepayment_sort_order');

//        $method_data = array(
//            'code' => 'yobepayment',
//            'title' => $this->language->get('text_title'),
//            'quote' => $quote_data,
//            'sort_order' => $this->config->get('yobepayment_sort_order'),
//            'error' => ''
//        );


        return $method_data;
    }
}

?>