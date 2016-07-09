<?php

class NoName_Gdn_Block_Pixel extends NoName_Gdn_Block_Abstract
{
    public function __construct()
    {
        parent::__construct();

        $this->_base_currency_code = $this->_store->getBaseCurrencyCode();
        $this->_curr_currency_code = $this->_store->getCurrentCurrencyCode();

        $this->_round           = Mage::getStoreConfigFlag(self::XML_PATH_ENABLE_ROUND, $this->_store_id);
        $this->_round_precision = Mage::getStoreConfig(self::XML_PATH_ROUND_PRECISION, $this->_store_id) ?: 0;

        $this->_dispaley_tax = Mage::getStoreConfig(self::XML_PATH_DISPLAY_TAXT_PRICE, $this->_store_id);

        $this->setTemplate('gdn/pixel.phtml');
    }

    public function getParams()
    {
        $this->prepareParams();

        return $this->_params;
    }

    protected function prepareParams()
    {
        $full_action_name = Mage::app()->getFrontController()->getAction()->getFullActionName();
        $options = $this->serializedOptionsToArray();

        if(!is_array($options)) {
            return false;
        }

        foreach ($options as $option) {

            if($option['action_name'] === $full_action_name) {
                switch ($option['data_type']) {

                    /* for product page */
                    case self::DATA_EXTRACT_PAGE_TYPE_PRODUCT:
                        $this->getOfferdetailPageData();
                        break;

                    /* for cart/checkout page */
                    case self::DATA_EXTRACT_PAGE_TYPE_CART_CHECKOUT:
                        $this->getConversionintentPageData();
                        break;

                    /* for success page */
                    case self::DATA_EXTRACT_PAGE_TYPE_SUCCESS:
                        $this->getConversionPageData();
                        break;

                    /* for other pages */
                    default:
                        $this->getOtherPageData();
                }

                $this->_params['dynx_pagetype']   = $option['page_type'];
            }
        }
    }

    /**
     * Prepare default
     */
    protected function getOtherPageData()
    {

    }

    protected function getOfferdetailPageData()
    {
        $_product = Mage::registry('current_product');

        if($_product instanceof Mage_Catalog_Model_Product) {

            $price = Mage::helper('directory')->currencyConvert(
                                                            $_product->getFinalPrice(),
                                                            $this->_base_currency_code,
                                                            $this->_curr_currency_code
                                                    );

            if($this->_display_tax) {
                $price = Mage::helper('tax')->getPrice($_product, $price);
            }

            if($this->_round) {
                $price = round($price, $this->_round_precision);
            }

            $this->_params['dynx_totalvalue'] = $price;
            $this->_params['dynx_itemid']     = $_product->getId();
        }
    }

    protected function getConversionintentPageData()
    {
        $cart   = Mage::getModel('checkout/cart')->getQuote();
        $items  = $cart->getAllVisibleItems();
        $prices = '';
        $ids    = '';

        foreach ($items as $item) {

            if($this->_display_tax) {
                $price = Mage::helper('directory')->currencyConvert(
                                        $item->getPriceInclTax(),
                                        $this->_base_currency_code,
                                        $this->_curr_currency_code
                                );
            } else {
                $price = Mage::helper('directory')->currencyConvert(
                                            $item->getPrice(),
                                            $this->_base_currency_code,
                                            $this->_curr_currency_code
                                    );
            }

            if($this->_round) {
                $price = round($price, $this->_round_precision);
            }

            $prices[] = $price;
            $ids[]    = $item->getProductId();
        }

        if(count($ids) > 1 && count($prices) > 1) {
            $this->_params['dynx_itemid']     = $ids;
            $this->_params['dynx_totalvalue'] = $prices;
        } else {
            $this->_params['dynx_itemid']     = implode(',', $ids);
            $this->_params['dynx_totalvalue'] = implode(',', $prices);
        }
    }

    protected function getConversionPageData()
    {
        $order = Mage::getSingleton('sales/order');
        $order->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());

        $items  = $order->getAllVisibleItems();
        $prices = '';
        $ids    = '';

        foreach ($items as $item) {

            if($this->_display_tax) {
                $price = Mage::helper('directory')->currencyConvert(
                                        $item->getPriceInclTax(),
                                        $this->_base_currency_code,
                                        $this->_curr_currency_code
                                );
            } else {
                $price = Mage::helper('directory')->currencyConvert(
                                            $item->getPrice(),
                                            $this->_base_currency_code,
                                            $this->_curr_currency_code
                                    );
            }

            if($this->_round) {
                $price = round($price, $this->_round_precision);
            }

            $prices[] = $price;
            $ids[]    = $item->getProductId();
        }

        if(count($ids) > 1 && count($prices) > 1) {
            $this->_params['dynx_itemid']     = $ids;
            $this->_params['dynx_totalvalue'] = $prices;
        } else {
            $this->_params['dynx_itemid']     = implode(',', $ids);
            $this->_params['dynx_totalvalue'] = implode(',', $prices);
        }
    }
}
