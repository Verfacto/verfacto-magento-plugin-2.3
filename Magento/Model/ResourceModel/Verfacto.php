<?php

declare(strict_types=1);

namespace Verfacto\Magento\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Verfacto\Magento\Api\Data\VerfactoInterface;

class Verfacto extends AbstractDb
{
    /**
     * @inheriDoc
     */
    protected function _construct()
    {
        $this->_init(VerfactoInterface::TABLE_NAME, VerfactoInterface::ID);
    }
}
