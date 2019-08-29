<?php
namespace Blog\Post\Block\Adminhtml;

class Contact extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_contact';
        $this->_blockGroup = 'Blog_Post';
        $this->_headerText = __('Manage News');

        parent::_construct();

        if ($this->_isAllowedAction('Blog_Post::save')) {
            $this->buttonList->update('add', 'label', __('Add News'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
