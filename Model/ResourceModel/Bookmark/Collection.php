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

    public function getProducts()
    {
        $this->getSelect()
            ->join(
                ['product' => 'catalog_product_entity'],
                'main_table.product_id = product.entity_id',
                'product.sku as Sku'
            )
            ->columns(['product_id', new \Zend_Db_Expr('COUNT(`main_table`.`product_id`) as count')])
            ->group('main_table.product_id');

        return $this;
    }
}
