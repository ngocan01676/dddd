<?php
namespace Blog\Post\Controller\Adminhtml\Contact;

use Magento\Backend\App\Action\Context;
use Blog\Post\Api\ContactRepositoryInterface as ContactRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Blog\Post\Api\Data\ContactInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $ContactRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        ContactRepository $ContactRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->ContactRepository = $ContactRepository;
        $this->jsonFactory = $jsonFactory;
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
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        var_dump($postItems);
      exit();
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $newsId) {
            $news = $this->ContactRepository->getById($newsId);
            try {
                $newsData = $postItems[$newsId];
                $extendedNewsData = $news->getData();
                $this->setNewsData($news, $extendedNewsData, $newsData);
                $this->ContactRepository->save($news);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithNewsId(
                    $news,
                    __('Something went wrong while saving the news.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithNewsId(ContactInterface $news, $errorText)
    {
        return '[News ID: ' . $news->getId() . '] ' . $errorText;
    }

    public function setNewsData(\Blog\Post\Model\Contact $news, array $extendedNewsData, array $newsData)
    {
        $news->setData(array_merge($news->getData(), $extendedNewsData, $newsData));
        return $this;
    }
}
