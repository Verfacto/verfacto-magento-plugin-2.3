<?php

declare(strict_types=1);

namespace Verfacto\Magento\Controller\Adminhtml\Integration;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;


class Index extends Action implements HttpGetActionInterface
{
    public const MENU_ID = 'Verfacto_Magento::integration';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @inheirtDoc
     */
    public function execute()
    {
        return $this->resultPageFactory->create()->setActiveMenu(static::MENU_ID);
    }
}
