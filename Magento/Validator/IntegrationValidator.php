<?php

declare(strict_types=1);

namespace Verfacto\Magento\Validator;

use Magento\Integration\Model\IntegrationFactory;

class IntegrationValidator
{
    /**
     * @var IntegrationFactory
     */
    private $integrationFactory;

    /**
     * IntegrationValidator constructor.
     *
     * @param IntegrationFactory $integrationFactory
     */
    public function __construct(
        IntegrationFactory $integrationFactory
    ) {
        $this->integrationFactory = $integrationFactory;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function validate(string $name): bool
    {
        $integrationExists = $this->integrationFactory->create()->load($name, 'name')->getData();

        return empty($integrationExists);
    }
}
