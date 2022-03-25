<?php

declare(strict_types=1);

namespace Verfacto\Magento\Model\ResourceModel\Verfacto;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Verfacto\Magento\Model\ResourceModel\Verfacto as VerfactoResourceModel;
use Verfacto\Magento\Model\Verfacto as VerfactoModel;

class Collection extends AbstractCollection
{
    /**
     * Remittance File Collection Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VerfactoModel::class, VerfactoResourceModel::class);
    }
}
