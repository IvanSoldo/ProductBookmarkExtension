<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller\Adminhtml\Bookmark;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;

class Index extends Action
{

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_ProductBookmark::productbookmark');
    }

    /**
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_ProductBookmark::productbookmark');
        $resultPage->getConfig()->getTitle()->prepend(__('Bookmarks'));

        return $resultPage;
    }
}
