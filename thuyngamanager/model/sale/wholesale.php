<?php

class ModelSaleWholesale extends Model
{

    public function updateSaleOffPercent($customer_group_id, $percent)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "customer_group SET sale_off_percent = '" . (float)$percent . "' WHERE customer_group_id = '" . (int) $customer_group_id . "'");


        // Update wholese Price
        foreach ($this->getAutoPriceProducts($customer_group_id) as $data)
        {
            $query = $this->db->query("SELECT product_id, price, xp  FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$data['product_id'] . "'");
            $product_info = $query->row;
            
            $query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$data['product_id'] . "' AND customer_group_id = 8");
            $special_default = $query->row;
            
            
            $DP = ($special_default && $customer_group_id !== 8) ? floatval($special_default['price']) : floatval($product_info['price']);

            $XP = floatval($product_info['xp']);
            $BP = $DP - $XP;  
            
            $X = floatval($percent) / 100;
            $WP = (1-$X)*$BP + $XP;
     

            $this->db->query("UPDATE " . DB_PREFIX . "product_special SET price = '" . round($WP,2) . "', discount_rate = '" . (float)$percent . "' WHERE product_id = '" . intval($data['product_id']) . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND use_global_rate = 1");
        }
    }

    private function getAutoPriceProducts($customer_group_id)
    {
        $query = $this->db->query("SELECT product_id, price  FROM " . DB_PREFIX . "product_special WHERE use_global_rate = 1 AND customer_group_id = '" . $customer_group_id . "'");
        return $query->rows;
    }

    public function getWholesale($customer_group_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int) $customer_group_id . "' AND cgd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getWholesales()
    {
        // Check sale_off_percent exists
        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "customer_group LIKE 'sale_off_percent'");

        if (!$query->rows)
        {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "customer_group ADD sale_off_percent FLOAT NOT NULL DEFAULT '0' AFTER customer_group_id");
        }

        // Check discount_rate exists
        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_special LIKE 'discount_rate'");

        if (!$query->rows)
        {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "product_special ADD discount_rate FLOAT NOT NULL DEFAULT '0' AFTER price");
        }

        // Check use_global_rate exists
        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_special LIKE 'use_global_rate'");

        if (!$query->rows)
        {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "product_special ADD use_global_rate TINYINT NOT NULL DEFAULT '0' AFTER price");
        }

        // Check xp exists
        $query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product LIKE 'xp'");

        if (!$query->rows)
        {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "product ADD xp INT NOT NULL DEFAULT '0' AFTER price");
        }

        $sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int) $this->config->get('config_language_id') . "'";


        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalCustomers()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group WHERE customer_group_id != 8");

        return $query->row['total'];
    }

}

?>