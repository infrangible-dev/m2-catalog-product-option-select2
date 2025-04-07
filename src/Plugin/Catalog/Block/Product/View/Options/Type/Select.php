<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductOptionSelect2\Plugin\Catalog\Block\Product\View\Options\Type;

use Infrangible\Core\Helper\Block;
use Infrangible\Core\Helper\Registry;
use Magento\Catalog\Block\Product\View\Options\Type\Select\MultipleFactory;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2025 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Select
{
    /** @var MultipleFactory */
    protected $multipleFactory;

    /** @var Registry */
    protected $registryHelper;

    /** @var Block */
    protected $blockHelper;

    public function __construct(MultipleFactory $multipleFactory, Registry $registryHelper, Block $blockHelper)
    {
        $this->multipleFactory = $multipleFactory;
        $this->registryHelper = $registryHelper;
        $this->blockHelper = $blockHelper;
    }

    public function aroundGetValuesHtml(
        \Magento\Catalog\Block\Product\View\Options\Type\Select $subject,
        callable $proceed
    ): string {
        $option = $subject->getOption();
        $optionType = $option->getType();

        if ($optionType === 'select2') {
            $this->registryHelper->register(
                'current_option',
                $option,
                true
            );

            $optionBlock = $this->multipleFactory->create();

            $optionBlock->setOption($option);
            $optionBlock->setProduct($subject->getProduct());
            $optionBlock->setDataUsingMethod(
                'skip_js_reload_price',
                1
            );

            $result = $optionBlock->toHtml();

            $this->registryHelper->unregister('current_option');

            return sprintf(
                '%s%s',
                $result,
                $this->blockHelper->renderChildTemplateBlock(
                    $subject,
                    'Infrangible_CatalogProductOptionSelect2::product/view/options/type/select2.phtml',
                    ['option' => $option]
                )
            );
        } else {
            return $proceed();
        }
    }
}
