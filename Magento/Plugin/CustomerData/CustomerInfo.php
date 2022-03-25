<?php

declare(strict_types=1);

namespace Verfacto\Magento\Plugin\CustomerData;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;

class CustomerInfo
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * CustomerInfo constructor.
     *
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(
        CurrentCustomer $currentCustomer
    ) {
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @param Customer $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(Customer $subject, array $result): array
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }
        $customer = $this->currentCustomer->getCustomer();
        $result['email'] = $customer->getEmail();

        return $result;
    }
}
