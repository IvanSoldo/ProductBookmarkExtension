<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Model\ResourceModel\Bookmark;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Resource collection initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\ProductBookmark\Model\Bookmark::class,
            \Inchoo\ProductBookmark\Model\ResourceModel\Bookmark::class
        );
    }

    /**
     * Return Bookmarked Products and their count
     *
     * @return $this
     */
    public function addProductData()
    {
        $this->getSelect()
            ->join(
                ['product' => 'catalog_product_entity'],
                'main_table.product_id = product.entity_id',
                ['Sku' => 'product.sku']
            )
            ->columns(['product_id', new \Zend_Db_Expr('COUNT(`main_table`.`product_id`) as count')])
            ->group('main_table.product_id');

        return $this;
    }
}
