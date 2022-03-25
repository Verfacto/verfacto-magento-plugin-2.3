<?php

namespace Verfacto\Magento\Model\System\Message;

use Magento\Framework\Notification\MessageInterface;
use Verfacto\Magento\ViewModel\Verfacto;

class VerfactoNotification implements MessageInterface
{
    /**
     * @var Verfacto
     */
    private $verfacto;

    /**
     * @param Verfacto $verfacto
     */
    public function __construct(
        Verfacto $verfacto
    ) {
        $this->verfacto = $verfacto;
    }

    public function getIdentity()
    {
        // Retrieve unique message identity
        return 'identity';
    }

    public function isDisplayed()
    {
        if (!$this->verfacto->checkIntegration()) {
            return true;
        }
        return false;
    }

    public function getText()
    {
        return 'Verfacto module is not active. Please re-integrate it at \'Marketing -> Analytics & Insights -> Verfacto Data Analytics\'.';
    }

    public function getSeverity()
    {
        return self::SEVERITY_MAJOR;
    }
}
