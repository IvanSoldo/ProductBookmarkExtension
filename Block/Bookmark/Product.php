<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Block\Bookmark;

use Magento\Framework\View\Element\Template;

class Product extends Template
{
    public function getProductId()
    {
        return $this->getRequest()->getParam('product');
    }
}
