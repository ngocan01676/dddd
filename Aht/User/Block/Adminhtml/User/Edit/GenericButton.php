<?php

namespace Aht\User\Block\Adminhtml\User\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allnewsRepository;
    
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $allnewsRepository
    ) {
        $this->context = $context;
        $this->allnewsRepository = $allnewsRepository;
    }

    public function getNewsId()
    {
        try {
            return $this->allnewsRepository->getById(
                $this->context->getRequest()->getParam('Customer_id')
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
