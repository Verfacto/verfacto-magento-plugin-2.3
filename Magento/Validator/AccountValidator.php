<?php

declare(strict_types=1);

namespace Verfacto\Magento\Validator;

use Exception;
use Verfacto\Magento\Processor\RequestsProcessor;

class AccountValidator
{
    /**
     * @var RequestsProcessor
     */
    private $requestsProcessor;

    /**
     * AccountValidator constructor.
     *
     * @param RequestsProcessor $requestsProcessor
     */
    public function __construct(
        RequestsProcessor $requestsProcessor
    ) {
        $this->requestsProcessor = $requestsProcessor;
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $name
     * @throws Exception
     */
    public function validate(string $email, string $password, string $name): void
    {
        $checkVerfactoAccount = $this->requestsProcessor->signInAccount(
            $name,
            $password,
            $email
        );
        if (is_array($checkVerfactoAccount) && !isset($checkVerfactoAccount['user'])) {
            throw new Exception('Error - Looks like your credentials are invalid.');
        }
    }
}
