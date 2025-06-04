<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductOptionSelect2\Observer;

use Magento\Catalog\Model\Product\Option;
use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2025 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class CatalogProductOptionCompositeQuoteItemBundleSelect implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        /** @var Option $option */
        $option = $observer->getData('option');

        $optionType = $option->getType();

        if ($optionType === 'select2') {
            /** @var DataObject $resultData */
            $resultData = $observer->getData('result');

            $resultData->setData(
                'use_multiple_block',
                true
            );
        }
    }
}
