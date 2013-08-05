<?php
class Shipping_Method_Model_Carrier_Storepickup extends Mage_Shipping_Model_Carrier_Abstract
{
    protected $_code = 'store_pickup';

    protected $_methodCode = 'store_pickup_method';

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
        $method->setMethodDescription($this->getPayDescription());

        $result->append($method);

        return $result;
    }

}
