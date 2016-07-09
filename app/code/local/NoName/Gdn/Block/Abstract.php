<?php

class NoName_Gdn_Block_Abstract extends Mage_Core_Block_Template
{
    const XML_PATH_GDN_ENABLE           = 'google/display_network/enable';
    const XML_PATH_GDN_CONVERSATION_ID  = 'google/display_network/conversation_id';
    const XML_PATH_OPTIONS              = 'google/display_network/options';
    const XML_PATH_ENABLE_ROUND         = 'google/display_network/enable_round';
    const XML_PATH_ROUND_PRECISION      = 'google/display_network/round_precision';
    const XML_PATH_DISPLAY_TAXT_PRICE   = 'google/display_network/enable_tax';

    const DATA_EXTRACT_PAGE_TYPE_PRODUCT        = 'offerdetail';
    const DATA_EXTRACT_PAGE_TYPE_CART_CHECKOUT  = 'conversionintent';
    const DATA_EXTRACT_PAGE_TYPE_SUCCESS        = 'conversion';
    const DATA_EXTRACT_PAGE_TYPE_OTHER          = 'other';

    protected $_params = array(
                        'dynx_itemid'     => '',
                        'dynx_pagetype'   => '',
                        'dynx_totalvalue' => ''
                    );

    protected $_store;
    protected $_store_id;
    protected $_round;
    protected $_round_precision;
    protected $_dispaley_tax;
    protected $_base_currency_code;
    protected $_curr_currency_code;
    protected $_options;

    public function __construct()
    {
        $this->_store    = Mage::app()->getStore();
        $this->_store_id = $this->_store->getStoreId();
    }

    /**
     * Retrieve GDN enable/disable
     *
     * @return string
     */
    public function getEnableGdn()
    {
        return Mage::getStoreConfig(self::XML_PATH_GDN_ENABLE, Mage::app()->getStore()->getId());
    }

    /**
     * Retrieve GDN conversation id
     *
     * @return string
     */
    public function getConversationId()
    {
        return Mage::getStoreConfig(self::XML_PATH_GDN_CONVERSATION_ID, Mage::app()->getStore()->getId());
    }

    /**
     * Convert serialized options to data array
     *
     * @return boolean|array
     */
    protected function serializedOptionsToArray()
    {
        $values = unserialize(Mage::getStoreConfig(self::XML_PATH_OPTIONS, Mage::app()->getStore()->getId()));

        if(is_array($values) && !empty($values)){

            foreach ($values['page_type'] as $key => $value) {

                if(!$value){ continue; }
                $this->_options[] = array(
                                    'data_type'   => $values['data_type'][$key],
                                    'page_type'   => $values['page_type'][$key],
                                    'action_name' => $values['action_name'][$key]
                                );
            }

            return $this->_options;
        }

        return false;
    }
}
