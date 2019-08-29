<?php
namespace Blog\Post\Model;

use Blog\Post\Api\Data\ContactInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Contact extends AbstractModel implements ContactInterface, IdentityInterface
{
	const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

	
	const CACHE_TAG = 'blog_post';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Blog\Post\Model\ResourceModel\Contact');
    }
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
	
	public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
	
	public function getIds()
    {
        return parent::getData(self::CONTACT_ID);
    }
	
	
	
	public function setIds($id)
    {
        return $this->setData(self::CONTACT_ID, $id);
    }
        public function getNames()
    {
        return parent::getData(self::Name);
    }
    
    
    
    public function setNames($name)
    {
        return $this->setData(self::Name, $name);
    }
        public function getEmails()
    {
        return parent::getData(self::EMAIL);
    }
    
    
    
    public function setEmails($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
        public function getComments()
    {
        return parent::getData(self::COMMENT);
    }
    
    
    
    public function setComments($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }
        public function getIs_actives()
    {
        return parent::getData(self::IS_ACTIVE);
    }
    
    
    
    public function setIs_actives($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
        public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }
    
    
    
    public function setCreatedAt($CREATED_AT)
    {
        return $this->setData(self::CREATED_AT, $CREATED_AT);
    }

            public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }
    
    
    
    public function setUpdatedAt($UPDATED_AT)
    {
        return $this->setData(self::UPDATED_AT, $UPDATED_AT);
    }
    
    

    
	
	
}