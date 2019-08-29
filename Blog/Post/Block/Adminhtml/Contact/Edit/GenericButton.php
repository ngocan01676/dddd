<?php

namespace Blog\Post\Block\Adminhtml\Contact\Edit;

use Magento\Backend\Block\Widget\Context;
use Blog\Post\Api\ContactRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allnewsRepository;
    
    public function __construct(
        Context $context,
        ContactRepositoryInterface $allnewsRepository
    ) {
        $this->context = $context;
        $this->allnewsRepository = $allnewsRepository;
    }

    public function getNewsId()
    {
        try {
            return $this->allnewsRepository->getById(
                $this->context->getRequest()->getParam('contact_id')
            )->getId();
        }
		catch (NoSuchEntityException $e) {
        
		}
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
