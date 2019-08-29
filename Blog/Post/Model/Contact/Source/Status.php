<?php

namespace Blog\Post\Model\Contact\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $Contact;

    public function __construct(\Blog\Post\Model\Contact $Contact)
    {
        $this->Contact = $Contact;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->Contact->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
