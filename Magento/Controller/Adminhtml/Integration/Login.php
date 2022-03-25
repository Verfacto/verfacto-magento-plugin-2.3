<?php

declare(strict_types=1);

namespace Verfacto\Magento\Controller\Adminhtml\Integration;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Verfacto\Magento\Api\Data\MetaDataInterface;
use Verfacto\Magento\Processor\GenerateProcessor;
use Verfacto\Magento\Processor\IntegrationProcessor;
use Verfacto\Magento\Validator\AccountValidator;
use Verfacto\Magento\Validator\RequestValidator;

class Login extends Action
{
    /**
     * @var IntegrationProcessor
     */
    private $integrationProcessor;

    /**
     * @var GenerateProcessor
     */
    private $generateProcessor;

    /**
     * @var RequestValidator
     */
    private $requestValidator;

    /**
     * @var AccountValidator
     */
    private $accountValidator;

    /**
     * @param IntegrationProcessor $integrationProcessor
     * @param GenerateProcessor $generateProcessor
     * @param RequestValidator $requestValidator
     * @param AccountValidator $accountValidator
     * @param Context $context
     */
    public function __construct(
        IntegrationProcessor $integrationProcessor,
        GenerateProcessor $generateProcessor,
        RequestValidator $requestValidator,
        AccountValidator $accountValidator,
        Context $context
    ) {
        $this->integrationProcessor = $integrationProcessor;
        $this->generateProcessor = $generateProcessor;
        $this->requestValidator = $requestValidator;
        $this->accountValidator = $accountValidator;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');
        $name = $this->generateProcessor->buildName();

        try {
            $this->requestValidator->validate($email, $password);
            $this->accountValidator->validate($email, $password, $name);
            $this->integrationProcessor->process($name, $email, $password);
            $this->messageManager->addSuccessMessage($name . ' is integrated Successfully!');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath(MetaDataInterface::REDIRECT_URL);
    }
}
