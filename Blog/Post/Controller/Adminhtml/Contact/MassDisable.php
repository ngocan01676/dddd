<?php

namespace Blog\Post\Controller\Adminhtml\Contact;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Blog\Post\Model\ResourceModel\Contact\CollectionFactory;

class MassDisable extends \Magento\Backend\App\Action
{

    protected $filter;
    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Get collection
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        // Update status to Disable
        foreach ($collection as $item) {
            $item->setIs_actives(false);
            $item->save();
        }

        // Display success message
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));

        // Redirect to List page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
