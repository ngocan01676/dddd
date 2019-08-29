<?php
namespace Blog\Post\Controller\Adminhtml\Contact;
use Blog\Post\Model\ContactFactory;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;
	private $_customer;


	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Customer\Model\CustomerFactory $customer
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->contact=$customer;
	}
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Blog_Post::news_allnews');
	}

	public function execute()
	{ 
		// $model=$this->_customer->create();
		// $model=$this->_customer->getCollection()->getData();
		// $model = $this->_objectManager->create(\Magento\Customer\Model\Customer::class);
		// $model->getCollection()->getData();
		// echo "<pre>";
		// print_r($model);
		// die();
		$firstNumber = 1;
$secondNumber = 2;
$sum = $firstNumber + $secondNumber;
if (2 === $sum) {
    echo "it's wrong baby";
} else {
    echo "You right, baby";
}

		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('All Contact'));
		return $resultPage;
	}
}