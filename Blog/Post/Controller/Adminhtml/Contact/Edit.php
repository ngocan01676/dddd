<?php

namespace Blog\Post\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	// /**
 //     * Core registry
 //     *
 //     * @var \Magento\Framework\Registry
 //     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Blog_Post::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allnews
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Rsgitech_News::news_allnews')
            ->addBreadcrumb(__('News'), __('News'))
            ->addBreadcrumb(__('Manage All News'), __('Manage All News'));
        return $resultPage;
    }

    // *
    //  * Edit Allnews
    //  *
    //  * @return \Magento\Backend\Model\View\Result\Allnews|\Magento\Backend\Model\View\Result\Redirect
    //  * @SuppressWarnings(PHPMD.NPathComplexity)
     
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('contact_id');
        $model = $this->_objectManager->create(\Blog\Post\Model\Contact::class);
        // if(!isset($id))
        //     echo "done";
        // die();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This news no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
             // var_dump($model->load($id)->getData());    
             // die();
        $this->_coreRegistry->register('news_allnews', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit News') : __('Add News'),
            $id ? __('Edit News') : __('Add News')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Contact'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('Add Contact'));

        return $resultPage;
    }

}
