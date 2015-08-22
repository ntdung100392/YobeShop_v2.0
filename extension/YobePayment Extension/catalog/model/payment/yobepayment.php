<?php
class ModelPaymentYobePayment extends Model
{
    public function getMethod($address)
    {
        $this->load->language('payment/yobepayment');

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

                $quote_data[$i] = array(
                    'code'  => 'yobepayment_'. $i,
                    'title' => $this->config->get('yobepayment_name'. $i),
                    'terms'  => '',
                    'image' => $this->model_tool_image->resize($this->config->get('yobepayment_image'.$i), 100, 100),
                    'sort_order' => $this->config->get('yobepayment_sort_order'),
                    'error' => ''
                );
            }
        }
        $method_data['title']=$this->language->get('text_title');
        $method_data['count']=$this->config->get('yobepayment_number_method');
        $method_data['code']='yobepayment';
        $method_data['list']= $quote_data;
        $method_data['sort_order']=$this->config->get('yobepayment_sort_order');

        return $method_data;
    }
}

?>