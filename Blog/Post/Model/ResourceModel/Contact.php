<?php
namespace Blog\Post\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Contact extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected $_date;
	
	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
		\Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        parent::__construct($context);
		$this->_date = $date;
    }
	
	/**
     * Define main table
     */
	protected function _construct()
	{
		$this->_init('aht_blog_contact', 'contact_id');
	}
	
	protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdatedAt($this->_date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }
        return parent::_beforeSave($object);
    }
        public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}