<?php
class ControllerSaleWholesale extends Controller {
    private $error = array();

    public function index()
    {
        $this->load->language('sale/wholesale');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/wholesale');

        $this->getList();
    }

    public function update()
    {
        $this->load->language('sale/wholesale');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/wholesale');

        if (($this->request->server['REQUEST_METHOD'] == 'POST'))
        {
            $customer_groups = isset($_POST['customer_groups']) ? $_POST['customer_groups'] : array();
            
            foreach ($customer_groups as $customer_group_id => $percent) {
                $this->model_sale_wholesale->updateSaleOffPercent($customer_group_id,$percent);
            }
            
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('sale/wholesale', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    private function getList()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/wholesale', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $data['update_action'] = $this->url->link('sale/wholesale/update', 'token=' . $this->session->data['token'], 'SSL');

        $data['wholesales'] = array();
        

        $results = $this->model_sale_wholesale->getWholesales();

        foreach ($results as $result)
        {
            $data['customer_groups'][] = array(
                'customer_group_id' => $result['customer_group_id'],
                'name' => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_id')) ? $this->language->get('text_default') : null),
                'sale_off_percent' => $result['sale_off_percent']
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_percent'] = $this->language->get('column_percent');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        

        if (isset($this->error['warning']))
        {
            $data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success']))
        {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        }
        else
        {
            $data['success'] = '';
        }
      

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/wholesale_list.tpl', $data));
    }

    private function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_approval'] = $this->language->get('entry_approval');
        $data['entry_company_id_display'] = $this->language->get('entry_company_id_display');
        $data['entry_company_id_required'] = $this->language->get('entry_company_id_required');
        $data['entry_tax_id_display'] = $this->language->get('entry_tax_id_display');
        $data['entry_tax_id_required'] = $this->language->get('entry_tax_id_required');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning']))
        {
            $this->data['error_warning'] = $this->error['warning'];
        }
        else
        {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['name']))
        {
            $this->data['error_name'] = $this->error['name'];
        }
        else
        {
            $this->data['error_name'] = array();
        }

        $url = '';

        if (isset($this->request->get['sort']))
        {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order']))
        {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page']))
        {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/wholesale', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['wholesale_id']))
        {
            $this->data['action'] = $this->url->link('sale/wholesale/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        }
        else
        {
            $this->data['action'] = $this->url->link('sale/wholesale/update', 'token=' . $this->session->data['token'] . '&wholesale_id=' . $this->request->get['wholesale_id'] . $url, 'SSL');
        }

        $this->data['cancel'] = $this->url->link('sale/wholesale', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['wholesale_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST'))
        {
            $wholesale_info = $this->model_sale_wholesale->getWholesale($this->request->get['wholesale_id']);
        }

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['wholesale_description']))
        {
            $this->data['wholesale_description'] = $this->request->post['wholesale_description'];
        }
        elseif (isset($this->request->get['wholesale_id']))
        {
            $this->data['wholesale_description'] = $this->model_sale_wholesale->getWholesaleDescriptions($this->request->get['wholesale_id']);
        }
        else
        {
            $this->data['wholesale_description'] = array();
        }

        if (isset($this->request->post['approval']))
        {
            $this->data['approval'] = $this->request->post['approval'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['approval'] = $wholesale_info['approval'];
        }
        else
        {
            $this->data['approval'] = '';
        }

        if (isset($this->request->post['company_id_display']))
        {
            $this->data['company_id_display'] = $this->request->post['company_id_display'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['company_id_display'] = $wholesale_info['company_id_display'];
        }
        else
        {
            $this->data['company_id_display'] = '';
        }

        if (isset($this->request->post['company_id_required']))
        {
            $this->data['company_id_required'] = $this->request->post['company_id_required'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['company_id_required'] = $wholesale_info['company_id_required'];
        }
        else
        {
            $this->data['company_id_required'] = '';
        }

        if (isset($this->request->post['tax_id_display']))
        {
            $this->data['tax_id_display'] = $this->request->post['tax_id_display'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['tax_id_display'] = $wholesale_info['tax_id_display'];
        }
        else
        {
            $this->data['tax_id_display'] = '';
        }

        if (isset($this->request->post['tax_id_required']))
        {
            $this->data['tax_id_required'] = $this->request->post['tax_id_required'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['tax_id_required'] = $wholesale_info['tax_id_required'];
        }
        else
        {
            $this->data['tax_id_required'] = '';
        }

        if (isset($this->request->post['sort_order']))
        {
            $this->data['sort_order'] = $this->request->post['sort_order'];
        }
        elseif (!empty($wholesale_info))
        {
            $this->data['sort_order'] = $wholesale_info['sort_order'];
        }
        else
        {
            $this->data['sort_order'] = '';
        }

        $this->template = 'sale/wholesale_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>