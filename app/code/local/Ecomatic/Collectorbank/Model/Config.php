<?php

class Ecomatic_Collectorbank_Model_Config extends Varien_Object
{
	const COLLECTOR_DOC_URL	  			= 'https://merchant.collectorbank.se/integration/';
	const ONLINE_GUI_URL	  			= 'https://merchant.collectorbank.se/';

	const SERVER_MODE_LIVE 				= 'LIVE';
	const SERVER_MODE_DEMO 				= 'DEMO';

	
	const LICENSE_URL         			= 'https://merchant.collectorbank.se/modules/platforms/magento/collectorbank/license';
	const DOCUMENTATION_URL     		= 'https://merchant.collectorbank.se/modules/platforms/magento/collectorbank#documentation';

	
	
	const CUSTOMER_TYPE_PERSON 			= 'person';
	const CUSTOMER_TYPE_ORGANIZATION	= 'organization';

	

	private $store = null;
	
	
	

	public function setStore($storeId)
	{
		$this->store = $storeId;
	}

	public function getStore()
	{
		if($this->store != null)
			return $this->store;

		if(Mage::app()->getStore()->getId() == 0)
			return Mage::app()->getRequest()->getParam('store', 0);

		return $this->store;
	}
	
	public function getActiveShppingMethods()
	{
		$methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
		$options = array();

		foreach($methods as $_code => $_method)
		{
			if ($methods = $_method->getAllowedMethods()){
				foreach ($methods as $_mcode => $_mname){
					$code = $_code . '_' . $_mcode;
					$title = $_mname;
					$title = $_code;
					$options[] = $code;
				}
			}
	
		}

		return $options; // This array will have all the active shipping methods
	} 
	
	public function getConfigData($key, $default = false)
	{
		
		if (!$this->hasData($key) || $this->store != null){
			$value = Mage::getStoreConfig('ecomatic_collectorbank/general/'.$key, $this->getStore());
			if (is_null($value) || false === $value) {
	    		$value = $default;
			}
			$this->setData($key, $value);
		}
		
		return $this->getData($key);
	}
	
	public function getEnabled() 
	{
        return $this->getConfigData('active');
    }
	
	public function getTitle()
	{
		return "Collector Bank Payment";
	}
	
	public function getBusinessUsername() 
	{		
        return Mage::getStoreConfig('ecomatic_collectorbank/general/username');
    }
	
	public function getBusinessSecretkey() 
	{
        return Mage::helper('core')->decrypt(Mage::getStoreConfig('ecomatic_collectorbank/general/password_iframe'));
    }
	
	public function getBusinessStoreId() 
	{		
        return Mage::getStoreConfig('ecomatic_collectorbank/general/store_id_b2b');
    }
	
	public function getPrivateUsername() 
	{		
        return Mage::getStoreConfig('ecomatic_collectorbank/general/username');
    }
	
	public function getPrivateSecretkey() 
	{
        return Mage::helper('core')->decrypt(Mage::getStoreConfig('ecomatic_collectorbank/general/password_iframe'));
    }
	
	public function getPrivateStoreId() 
	{		
        return Mage::getStoreConfig('ecomatic_collectorbank/general/store_id_b2c');
    }
	
	public function getInitializeUrl() 
	{		
        return 'https://checkout-api-uat.collector.se';
    }
	
	public function isLive()
	{
		if($this->getConfigData('server') == self::SERVER_MODE_LIVE)
			return true;

		return false;
	}
	
	public function showDefaultCheckout()
	{
		return $this->getConfigData('default_checkout');
	}
	
	public function showGiftmessage()
	{
		return $this->getConfigData('show_giftmessage');
	}
	
	public function showNewsletter()
	{
		return $this->getConfigData('show_newsletter');
	}
	
	public function useAdditionalCheckbox()
	{
		return $this->getConfigData('additional_checkbox');
	}

	public function getAdditionalCheckboxText()
	{
		return $this->getConfigData('additional_checkbox_text');
	}
	
	public function getAdditionalCheckboxRequired()
	{
		return (bool)$this->getConfigData('additional_checkbox_required');
	}
	
	public function getAdditionalCheckboxChecked()
	{
		return (bool)$this->getConfigData('additional_checkbox_checked');
	}

	
	
	
	
	
}