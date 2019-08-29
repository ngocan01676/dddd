<?php
namespace Blog\Post\Model\ResourceModel\Contact;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
  protected $_idFieldName = 'contact_id';
	
	// protected $_eventPrefix = 'news_Contact_collection';

 //    protected $_eventObject = 'Contact_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Blog\Post\Model\Contact', 'Blog\Post\Model\ResourceModel\Contact');
	}
}