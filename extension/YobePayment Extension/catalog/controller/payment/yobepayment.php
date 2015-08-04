<?php
class ControllerPaymentYobePayment extends Controller {
	protected function index() {
		$this->language->load('payment/yobepayment');
		
		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_payment'] = $this->language->get('text_payment');
		
		$data['button_confirm'] = $this->language->get('button_confirm');
        for ($i = 1; $i <= $this->config->get('yobepayment_number_method'); $i++) {
            if(($this->config->get('yobepayment_name'.$i))==$this->session->data['payment_method']['title']){
                $data['yobepayment'] = nl2br($this->config->get('yobepayment_' . $this->config->get('config_language_id') . '_' . $i));
            }
        }

		$data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yobepayment.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/yobepayment.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/yobepayment.tpl', $data);
		}
	}

    public function confirm() {
        $this->language->load('payment/yobepayment');

        $this->load->model('checkout/order');

        $comment  = $this->language->get('text_instruction') . "\n\n";
        for ($i = 1; $i <= $this->config->get('yobepayment_number_method'); $i++) {
            if(($this->config->get('yobepayment_name'.$i))==$this->session->data['payment_method']['title']){
                $comment .= nl2br($this->config->get('yobepayment_' . $this->config->get('config_language_id') . '_' . $i)) . "\n\n";;
            }
        }
        $comment .= $this->language->get('text_payment');

        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('yobepayment_order_status_id'), $comment, true);
    }
}
?>