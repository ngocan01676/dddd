<?php

namespace Blog\Post\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action;
use Blog\Post\Model\Contact;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Blog\Post\Model\ContactFactory
     */
    private $ContactFactory;

    /**
     * @var \Blog\Post\Api\ContactRepositoryInterface
     */
    private $ContactRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Blog\Post\Model\ContactFactory $ContactFactory
     * @param \Blog\Post\Api\ContactRepositoryInterface $ContactRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Blog\Post\Model\ContactFactory $ContactFactory = null,
        \Blog\Post\Api\ContactRepositoryInterface $ContactRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->ContactFactory = $ContactFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Blog\Post\Model\ContactFactory::class);
        $this->ContactRepository = $ContactRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Blog\Post\Api\ContactRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Rsgitech_News::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();


        // echo "<pre>";
        // print_r($data);
        // die();
        if ($data) {
            if (isset($data['is_    active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Contact::is_active_ENABLED;
            }
            if (empty($data['contact_id'])) {
                $data['contact_id'] = null;
            }

            /** @var \Blog\Post\Model\Contact $model */
            $model = $this->ContactFactory->create();

            $id = $this->getRequest()->getParam('contact_id');
            if ($id) {
                try {
                    $model = $this->ContactRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This news no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'news_Contact_prepare_save',
                ['Contact' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->ContactRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the news.'));
                $this->dataPersistor->clear('news_Contact');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['contact_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the news.'));
            }

            $this->dataPersistor->set('news_Contact', $data);
            return $resultRedirect->setPath('*/*/edit', ['contact_id' => $this->getRequest()->getParam('contact_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
