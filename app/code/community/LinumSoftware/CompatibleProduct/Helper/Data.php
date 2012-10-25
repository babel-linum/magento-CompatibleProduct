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
 * @copyright   Copyright (c) 2012 Linum Software GmbH (http://www.linum.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
 */

class LinumSoftware_CompatibleProduct_Helper_Data extends Mage_Core_Helper_Abstract {

  public function _log($msg)
  {
    Mage::Log($msg, 0, "compatibleproduct.log");
  }
  
  public function getConfig($path)
  {
    // This method doesn't depend on stores being loaded.
    return (string) Mage::getConfig()->getNode('default/compatibleproduct/compatibleproduct/'.$path);
  }
  
  public function debugLog() {
    return ($this->getConfig('debuglog'));
  }
  
  public function isEnabled() {
    return ($this->getConfig('enabled'));
  }
  
}

?>
