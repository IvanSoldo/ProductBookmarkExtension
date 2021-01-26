<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Controller;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

abstract class Bookmark extends Action
{
    protected $customerSession;

    /**
     * Bookmark constructor.
     * @param Context $context
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectToList()
    {
        return $this->_redirect('inchoo_bookmark/bookmarklist/index');
    }

    /**
     * @param int $id
     * @return bool
     */
    protected function checkOwner(int $id)
    {
        $customerId = (int)$this->customerSession->getId();
        if ($id !== $customerId) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            return false;
        }
        return true;
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface|null
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
            if (!$this->customerSession->getBeforeUrl()) {
                $this->customerSession->setBeforeUrl($this->
                _redirect->getRefererUrl());
            }
        }
        return parent::dispatch($request);
    }
}
