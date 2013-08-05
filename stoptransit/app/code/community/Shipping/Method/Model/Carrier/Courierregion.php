<?php
class Shipping_Method_Model_Carrier_Courierregion extends Mage_Shipping_Model_Carrier_Abstract
{
    protected $_code = 'courier_region';

    protected $_methodCode = 'courier_region_method';

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
        $title = Mage::getStoreConfig('carriers/' . $this->_code . '/title');

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
//        $method->setCarrierTitle($title);

        $method->setMethod($this->_methodCode);
        $method->setMethodTitle($title);
        $method->setMethodDescription(Mage::helper('core/data')->__('Стоимость будет росчитывается 4 грн/км'));

        $result->append($method);

        return $result;
    }
}
