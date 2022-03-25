<?php

declare(strict_types=1);

namespace Verfacto\Magento\Api;

use Magento\Integration\Model\Oauth\Token;

/**
 * Interface VerfactoManagerInterface
 * @package Verfacto\Magento\Api
 */
interface VerfactoManagerInterface
{
    /**
     * @param Token $verfacto
     * @param array $verfactoInfo
     * @param string $name
     * @param string $password
     * @param string $email
     * @return bool
     */
    public function addTrackingInfo(Token $verfacto, array $verfactoInfo, string $name, string $password, string $email);
}
