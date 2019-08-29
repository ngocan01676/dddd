<?php

namespace Aht\User\Controller\Adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Encryption\EncryptorInterface;

class Save extends \Magento\Backend\App\Action
{


  private $hashpass;

  private $_userFactory;


  private $_userRepository;
  private $model;
  private $_customer;


  public function __construct(
    Action\Context $context,
    \Magento\Customer\Model\CustomerFactory $customer
   
  

  ) {


    
    $this->_customer=$customer;
    parent::__construct($context);
  }

  public function execute()
  {   

    $resultRedirect = $this->resultRedirectFactory->create();
    $data = $this->getRequest()->getPostValue();
    // $password=$this->hashpass->encrypt($data['pw1']);
    // echo "<pre>";
    // print_r($data);
    
    // die();
    if(isset($data['entity_id']))
    {
      // $model=$this->_customer->create();
      // $model=$this->_customer->load($data['entity_id']);
      $model = $this->_objectManager->create(\Magento\Customer\Model\Customer::class);
      $model->load($data['entity_id'])->getData();
      // echo "<pre>";
      // print_r($model);
      // die();
      $model->setPassword($data['pw1']);
      $model->save();
      return $resultRedirect->setPath('*/*/');
    }

    return $resultRedirect->setPath('*/*/');

  }


}
