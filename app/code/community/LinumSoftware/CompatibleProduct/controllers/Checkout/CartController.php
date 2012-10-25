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

class LinumSoftware_CompatibleProduct_Checkout_CartController extends Mage_Checkout_CartController
{
  public function compatibleproductfirecheckoutAction() {
    $this->worker();
    $this->loadLayout(array('firecheckout_index_updatecheckout', 'compatibleproduct_firecheckout_remove_unused_review_items'));
    $this->getResponse()->setBody($this->getLayout()->getBlock('checkout.review')->toHtml());
    
  }
  
  public function compatibleproductAction() {
    $this->worker();
    $this->loadLayout('checkout_cart_index');
    $this->getResponse()->setBody($this->getLayout()->getBlock('checkout.cart')->toHtml());
  }
  
  protected function worker() {
    Mage::Log(">compatibleproductAction:");
    
    if(0) {
      //Mage::Log("debug: " . $this->loadLayout()->getLayout()->getUpdate()->asString());
      Mage::Log("debug: " . implode('/', $this->loadLayout()->getLayout()->getUpdate()->getHandles()));
      Mage::Log("debug: " .  $this->getFullActionName());
      Mage::Log("debug: " .  $this->getRequest()->getModuleName());
      Mage::Log("debug: " .  $this->getRequest()->getRouteName());
      Mage::Log("debug: " .  $this->getRequest()->getModuleName());
    }
    
    foreach($this->_getCart()->getItems() as $item)
      {
	Mage::Log("product " . $item->getName() . " item id: " . $item->getItemId());
      }
    
    $did = (int) $this->getRequest()->getParam('did');
    $aid = (int) $this->getRequest()->getParam('aid');
    $qty = (int) $this->getRequest()->getParam('qty');
    if ($did && $aid && $qty) {
      Mage::Log("did = $did / aid = $aid / qty = $qty");
      try {
	$cart = $this->_getCart();
	$cart->removeItem($did);
	$cart->addProduct($aid, array('qty' => $qty));
	$cart->save();
      } catch (Exception $e) {
	echo $this->__('Cannot remove the item.');
	exit;
      }
    }
    
    foreach($this->_getCart()->getItems() as $item)
      {
	Mage::Log("product " . $item->getName() . " item id: " . $item->getId());
      }
    
    Mage::Log("<compatibleproductAction:");
  }
}

?>
