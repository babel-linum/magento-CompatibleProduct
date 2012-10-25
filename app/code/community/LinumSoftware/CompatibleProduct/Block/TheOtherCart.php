<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * @package     LinumSoftware_CompatibleProduct
 * @copyright   Copyright (c) 2012 Linum Software GmbH (http://www.linum.com/
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class LinumSoftware_CompatibleProduct_Block_TheOtherCart extends Mage_Core_Block_Template {
  
  protected function getProduct() {
    return $this->getParentBlock()->getItem()->getProduct();
  }
  
  public function getProductName() {
    return $this->getParentBlock()->getItem()->getName();
  }
  
  public function getProductId() {
    return $this->getParentBlock()->getItem()->getProductId();
  }
  
  public function getItemId() {
    return $this->getParentBlock()->getItem()->getItemId();
  }
  
  public function getCartQty() {
    return ($this->getParentBlock()->getItem()->getQty());
  }
  
  public function getCartDeleteUrl() {
    $_url = $this->getUrl('checkout/cart/delete',
			  array(
				'_secure' => true,
				'id'=>$this->getParentBlock()->getItem()->getId(),
				Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl()
				)
			  );
    return ($_url);
  }
  
  public function getCompatibleProduct() {
    $_product = $this->getProduct();
    $_compatible_product_nr = $_product->getData('astd_kompatibles_produkt');
    if(strlen($_compatible_product_nr) > 0) {
      $_alternate_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $_compatible_product_nr);
      return ($_alternate_product);
    }
    return (NULL);
  }
  
  public function getCompatibleProductId() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      return ($_cp->getEntityId());
    }
    return ('');
  }
  
  public function getCompatibleProductName() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      return ($_cp->getName());
    }
    return ('');
  }
  
  public function getCompatibleProductPrice() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      return ($_cp->getFinalPrice());
    }
    return ('');
  }
  
  public function getCompatibleProductPriceDifference() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      $_product = $this->getProduct();
      
      $_diff = $_product->getFinalPrice() - $_cp->getFinalPrice();
      if($_diff > 0.01) {
	return ($_diff);
      } else if($_diff < 0.01) {
	return ($_diff);
      } else {
	return (0);
      }
    }
    return ('');
  }
  
  public function getCompatibleProductPriceDifferenceText() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      $_product = $this->getProduct();
      $_diff = $_product->getFinalPrice() - $_cp->getFinalPrice();
      if($_diff > 0.01) {
	return ('günstiger');
      } else if($_diff < 0.01) {
	return ('teurer');
      } else {
	return ('preisgleich');
      }
    }
    return ('');
  }       
  
  public function getCompatibleProductURL() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      return ($_cp->getProductURL());
    }
  }
  
  public function getCompatibleProductIsInStock() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      $_stocklevel = (int)Mage::getModel('cataloginventory/stock_item')->loadByProduct($_cp)->getQty();
      if($_stocklevel > 0) {
	return (true);
      }
      return (false);
    }
  }
  
  public function getCompatibleProductDeliveryTime() {
    $_cp = $this->getCompatibleProduct();
    if($_cp) {
      return ($_cp->getData('astd_lieferzeit'));
    }
  }
  
}

?>
