<?php

namespace Blog\Post\Model;

use Blog\Post\Api\Data\ContactInterfaceFactory ;
use Blog\Post\Api\ContactRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Blog\Post\Model\ResourceModel\Contact as ResourceContact;
use Blog\Post\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class ContactRepository implements ContactRepositoryInterface
{
    protected $resource;

    protected $ContactFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataContactFactory;

    private $storeManager;

    public function __construct(
        ResourceContact $resource,
        ContactFactory $ContactFactory,
        ContactInterfaceFactory $dataContactFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->ContactFactory = $ContactFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataContactFactory = $dataContactFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Blog\Post\Api\Data\ContactInterface $news)
    {
        if ($news->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $news->setStoreId($storeId);
        }
        try {
            $this->resource->save($news);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the news: %1', $exception->getMessage()),
                $exception
            );
        }
        return $news;
    }

    public function getById($newsId)
    {
		$news = $this->ContactFactory->create();
        $news->load($newsId);
        if (!$news->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $newsId));
        }
        return $news;
    }
	
    public function delete(\Blog\Post\Api\Data\ContactInterface $news)
    {
        try {
            $this->resource->delete($news);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the news: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($newsId)
    {
        return $this->delete($this->getById($newsId));
    }
}
