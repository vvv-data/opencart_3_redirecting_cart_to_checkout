<?php
class ModelExtensionModuleRedirectingCartToCheckout extends Model {
 
	protected $enabled, $checked;

	// Запись настроек в базу данных
	public function SaveSettings() {
	  $this->load->model('setting/setting');
	  $this->model_setting_setting->editSetting('module_redirecting_cart_to_checkout', $this->request->post);
	}
   
	// Загрузка настроек из базы данных
	public function LoadSettings() {
	  $this->load->model('setting/setting');
	  return $this->model_setting_setting->getSetting('module_redirecting_cart_to_checkout');
	}

	public function Enabled() {
		$this->load->model('setting/setting');
		if(!isset($this->enabled))
		  $this->enabled = $this->model_setting_setting->getSettingValue('module_redirecting_cart_to_checkout_status');
		return $this->enabled;
	  }	
	
	  // создаем таблицу
	public function CreateTable() {

		$sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'product_redirect` (
			`product_id` int NOT NULL,
			`product_redirecting_checked` int NOT NULL,
			`store_id` int NOT NULL,
			PRIMARY KEY (`product_id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;';
		  $this->db->query($sql);
	}

	  // удаляем таблицу
	public function DropTable() {

		$this->load->model('setting/setting');
		$sql = 'DROP TABLE IF EXISTS `' . DB_PREFIX . 'product_redirect`;';
		$this->db->query($sql);
	}
   
  }