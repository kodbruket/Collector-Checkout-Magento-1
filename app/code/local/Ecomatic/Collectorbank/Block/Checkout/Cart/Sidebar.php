<?php
class Ecomatic_Collectorbank_Block_Checkout_Cart_Sidebar extends Mage_Checkout_Block_Cart_Sidebar
{
    public function getCheckoutUrl()
    {
        if (!Mage::helper('collectorbank')->isActive()){
            return parent::getCheckoutUrl();
        }
        return Mage::getBaseUrl() . 'collectorcheckout';
    }
}
