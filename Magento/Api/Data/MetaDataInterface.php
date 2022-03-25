<?php

declare(strict_types=1);

namespace Verfacto\Magento\Api\Data;

interface MetaDataInterface
{
    public const END_POINT = 'https://api.verfacto.com/auth/v1/';
    public const END_POINT_TRACKING_ID = 'plugins/magento_v2';
    public const END_POINT_ACCOUNT = 'signin';
    public const END_POINT_DISABLE_ACCOUNT = '/schedule-account-deletion';
    public const REDIRECT_URL = 'verfacto_magento/integration/index';
    public const ACTION_URL = 'verfacto_magento/integration/login';
}
