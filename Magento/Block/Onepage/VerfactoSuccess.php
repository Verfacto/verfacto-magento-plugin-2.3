<?php

declare(strict_types=1);

namespace Verfacto\Magento\Block\Onepage;

use Magento\Checkout\Block\Onepage\Success;

class VerfactoSuccess extends Success
{
    /**
     * @return string
     */
    public function getEmail()
    {
        $order = $this->_checkoutSession->getLastRealOrder();

        return $order->getCustomerEmail();
    }
}
