<?php

class NoName_Gdn_Block_Adminhtml_System_Config_Form_Tags extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected $_addRowButtonHtml = array();
    protected $_removeRowButtonHtml = array();

    protected $_types = array(
                        'other'            => 'other',
                        'offerdetail'      => 'product page',
                        'conversionintent' => 'cart/checkout page',
                        'conversion'       => 'success'
                    );

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $html = '<div id="gdn_tags_additional_label" style="display:none">';
        $html .= $this->_getRowTemplateHtml();
        $html .= '</div>';

        $html .= '<ul id="gdn_tags_additional_container">';
        if ($this->_getValue('page_type')) {
            foreach ($this->_getValue('page_type') as $i => $f) {
                if ($i) {
                    $html .= $this->_getRowTemplateHtml($i);
                }
            }
        }
        $html .= '</ul>';
        $html .= $this->_getAddRowButtonHtml('gdn_tags_additional_container','gdn_tags_additional_label', $this->__('Add'));

        return $html;
    }

    /**
     * Retrieve html template for shipping method row
     *
     * @param int $rowIndex
     * @return string
     */
    protected function _getRowTemplateHtml($rowIndex = 0)
    {
        $html = '<li>';
        $html .= '<fieldset style="width:300px;background:#fff">';

        $html .= '<label>' . $this->__('Page type:') . '</label><br/>';
        $html .= '<input class="input-text" name="'
            . $this->getElement()->getName() . '[page_type][]" value="'
            . $this->_getValue('page_type/' . $rowIndex) . '" ' . $this->_getDisabled() . '/> ';
        $html .= '<p class="note"><span>' . $this->__("Name of tracking pages, need for <strong>'dynx_pagetype'</strong> </br> Example: home, searchresults, offerdetail, conversionintent, conversion, other") . '</span></p>';

        $html .= '<div style="margin:5px 0 10px;">';

        $html .= '<label>' . $this->__('Full action name:') . '</label><br/>';
        $html .= '<input class="input-text" name="'
            . $this->getElement()->getName() . '[action_name][]" value="'
            . $this->_getValue('action_name/' . $rowIndex) . '" ' . $this->_getDisabled() . '/> ';
        $html .= '<p class="note"><span>' . $this->__("Magento full action name. </br> Example: for <strong>'home'</strong> page by default is  <strong>'cms_index_index'</strong>") . '</span></p>';

        $html .= '<div style="margin:5px 0 10px;">';

        $html .= '<label>' . $this->__('Data extract type:') . '</label><br/>';
        $html .= '<select name="' . $this->getElement()->getName() . '[data_type][]" >';
            foreach ($this->_types as $key => $type) {
                $html .= '<option value="' . $key . '" ' . ($this->_getValue('data_type/' . $rowIndex) == $key ? 'selected' : '') .  '>' . $type . '</option>';
            }
        $html .= '</select>';
        $html .= '<p class="note"><span>' . $this->__("Magento page type, need for extract data. </br> Example:  </br><strong>cart/checkout (extract quote items) </br> success (extract last order) </br> product (extract current product) </br> other (without data)'</strong>") . '</span></p>';

        $html .= '<div style="margin:5px 0 10px;">';

        $html .= $this->_getRemoveRowButtonHtml();

        $html .= '</div>';
        $html .= '</fieldset>';
        $html .= '</li>';

        return $html;
    }

    protected function _getDisabled()
    {
        return $this->getElement()->getDisabled() ? ' disabled' : '';
    }

    protected function _getValue($key)
    {
        return $this->getElement()->getData('value/' . $key);
    }

    protected function _getSelected($key, $value)
    {
        return $this->getElement()->getData('value/' . $key) == $value ? 'selected="selected"' : '';
    }

    protected function _getAddRowButtonHtml($container, $template, $title='Add')
    {
        if (!isset($this->_addRowButtonHtml[$container])) {
            $this->_addRowButtonHtml[$container] = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('add ' . $this->_getDisabled())
                    ->setLabel($this->__($title))
                    ->setOnClick("Element.insert($('" . $container . "'), {bottom: $('" . $template . "').innerHTML})")
                    ->setDisabled($this->_getDisabled())
                    ->toHtml();
        }
        return $this->_addRowButtonHtml[$container];
    }

    protected function _getRemoveRowButtonHtml($selector = 'li', $title = 'Remove')
    {
        if (!$this->_removeRowButtonHtml) {
            $this->_removeRowButtonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('delete v-middle ' . $this->_getDisabled())
                    ->setLabel($this->__($title))
                    ->setOnClick("Element.remove($(this).up('" . $selector . "'))")
                    ->setDisabled($this->_getDisabled())
                    ->toHtml();
        }
        return $this->_removeRowButtonHtml;
    }
}
