<?php
namespace Aht\User\Controller\Adminhtml\User;
use Magento\Customer\Model\Customer\DataProvider;

class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;
	protected $user;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		DataProvider $user
        
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->user=$user;
	}
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	// protected function _isAllowed()
	// {
	// 	return $this->_authorization->isAllowed('Blog_Post::news_allnews');
	// }

	public function execute()
	{ 
  //        $list=$this->user->getData();
  //        echo "<pre>";
  //        print_r($list);
  
	    
		// die();
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('All User'));
		return $resultPage;
	}
}