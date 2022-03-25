<?php

declare(strict_types=1);

namespace Verfacto\Magento\Validator;

use Exception;

class RequestValidator
{
    /**
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function validate(string $email, string $password): void
    {
        if (empty($email) || empty($password)) {
            throw new Exception('Please, Required fields can\'t be empty');
        }
    }
}
