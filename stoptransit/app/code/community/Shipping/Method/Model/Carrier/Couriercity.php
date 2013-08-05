<?php
class Shipping_Method_Model_Carrier_Couriercity extends Mage_Shipping_Model_Carrier_Abstract
{
    protected $_code = 'courier_city';




    protected $_methodCode = 'courier_city_method';

    /**
     * Collect rates for this shipping method based on information in $request.
     *
     * @param Mage_Shipping_Model_Rate_Request $data Request model.
     *
     * @return object
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {

        if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        if (!($priceRange = Mage::getStoreConfig('carriers/' . $this->_code . '/total_for_free'))) {
            $priceRange = 0;
        }
        $title = Mage::getStoreConfig('carriers/' . $this->_code . '/title');
        if (!($shippingCost = Mage::getStoreConfig('carriers/' . $this->_code . '/shipping_cost'))) {
            $shippingCost = 0;
        }

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
//        $method->setCarrierTitle($title);

        $method->setMethod($this->_methodCode);
        $method->setMethodTitle($title);

        $method->setMethodDescription($this->getFreeDescription());

        if ($request->getBaseSubtotalInclTax() < $priceRange ) {
            $method->setMethodDescription($this->getPayDescription());
            $method->setPrice($shippingCost);
            $method->setCost($shippingCost);
        }

        $result->append($method);

        return $result;
    }

    public function getPayDescription()
    {
        return Mage::helper('core/data')->__('Если вы закажете болше чем на 100гривен доставка будет бесплатно');
    }

    public function getFreeDescription()
    {
        return Mage::helper('core/data')->__('Доставка за счет магазина Стоп-Транзит.');
    }

}
