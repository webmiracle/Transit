<?php
class Shipping_Method_Block_Onepage_Payment_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{

    /**
     * Retrieve availale payment methods
     *
     * @return array
     */
    public function getMethods()
    {
        $methods = $this->getData('methods');
        if (is_null($methods)) {
            $quote = $this->getQuote();
            $store = $quote ? $quote->getStoreId() : null;
            $methods = $this->helper('payment')->getStoreMethods($store, $quote);
            $shippingMethpod = $this->getQuote()->getShippingAddress()->getShippingMethod();

            $total = $quote->getBaseSubtotal() + $quote->getShippingAddress()->getBaseShippingAmount();
            foreach ($methods as $key => $method) {

                if (($shippingMethpod == 'new_post_new_post_method' || $shippingMethpod == 'courier_region_courier_region_method') and $method->getCode() == 'checkmo') {
                    unset($methods[$key]);
                    continue;
                } elseif ($shippingMethpod != 'new_post_new_post_method' and $method->getCode() == 'cashondelivery') {
                    unset($methods[$key]);
                    continue;
                }

                if ($this->_canUseMethod($method)
                    && ($total != 0
                        || $method->getCode() == 'free'
                        || ($quote->hasRecurringItems() && $method->canManageRecurringProfiles()))
                ) {
                    $this->_assignMethod($method);
                } else {
                    unset($methods[$key]);
                }
            }
            $this->setData('methods', $methods);
        }

        return $methods;
    }

}
