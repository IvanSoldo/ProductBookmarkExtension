<?php

declare(strict_types=1);

namespace Inchoo\ProductBookmark\Observer;

use Inchoo\ProductBookmark\Api\BookmarkListRepositoryInterface;
use Inchoo\ProductBookmark\Api\Data\BookmarkListInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddDefaultBookmarkList implements ObserverInterface
{

    private $bookmarkListModelFactory;

    private $bookmarkListRepository;

    /**
     * AddDefaultBookmarkList constructor.
     * @param BookmarkListInterfaceFactory $bookmarkListModelFactory
     * @param BookmarkListRepositoryInterface $bookmarkListRepository
     */
    public function __construct(
        BookmarkListInterfaceFactory $bookmarkListModelFactory,
        BookmarkListRepositoryInterface $bookmarkListRepository
    ) {
        $this->bookmarkListModelFactory = $bookmarkListModelFactory;
        $this->bookmarkListRepository = $bookmarkListRepository;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $bookmarkList = $this->bookmarkListModelFactory->create();
        $bookmarkList->setBookmarkListTitle("Default");
        $bookmarkList->setIsDeletable(false);
        $bookmarkList->setCustomerId((int)$customer->getId());
        $this->bookmarkListRepository->save($bookmarkList);
    }
}
