<?php
/*
@author vvv-data
@link   https://vvvdata.ru
*/

class ModelExtensionModuleRedirectingCartToCheckout extends Model
{

	protected $settings, $text_button, $redirect_url;



	function __construct($params)
	{
		parent::__construct($params);

		$this->settings = array();

		$this->load->model('setting/setting');
		$this->settings = $this->model_setting_setting->getSetting('module_redirecting_cart_to_checkout');

		if (isset($this->settings['module_redirecting_cart_to_checkout_status']) && $this->settings['module_redirecting_cart_to_checkout_status']) {
			if ($this->settings['module_redirecting_cart_to_checkout_button'])
			$this->text_button = $this->settings['module_redirecting_cart_to_checkout_button'];
			else $this->text_button = '';

			$this->redirect_url = '';
			if ($this->settings['module_redirecting_cart_to_checkout_url'])
			$this->redirect_url = $this->settings['module_redirecting_cart_to_checkout_url'];
			elseif ($this->model_setting_setting->getSettingValue('module_simple_status')) //проверяем simple
			$this->redirect_url = $this->url->link('checkout/simplecheckout');
			else
				$this->redirect_url = $this->url->link('checkout/checkout');
		}
	}

	public function GetTextButton()
	{
       return $this->text_button;
    }

	public function GetUrlRedirect($product_id)
	{	
		if (isset($this->settings['module_redirecting_cart_to_checkout_status']) && $this->settings['module_redirecting_cart_to_checkout_status']) {
			if ($this->settings['module_redirecting_cart_to_checkout_all']) {
				return $this->redirect_url;
			} 
			else {
				$result = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "` like '" . DB_PREFIX . "product_redirect'");
				if ($result->num_rows) {
					$query = $this->db->query("SELECT product_redirecting_checked FROM " . DB_PREFIX . "product_redirect WHERE `product_id` = '" . (int)$product_id . "'");
					if ($query->num_rows && $query->row['product_redirecting_checked'] > 0)
					return $this->redirect_url;
				}
			}
		} 
		return null;
	}
}
