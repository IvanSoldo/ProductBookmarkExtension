<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Block;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\View\Result\LayoutFactory as LayoutResultFactory;

class Index extends Action
{

    private $layoutResultFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param LayoutResultFactory $layoutResultFactory
     */
    public function __construct(Context $context, LayoutResultFactory $layoutResultFactory)
    {
        parent::__construct($context);
        $this->layoutResultFactory = $layoutResultFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {
        $result = $this->layoutResultFactory->create();
        $result->addHandle('inchoo_ajax_bookmark');
        return $result;
    }
}
