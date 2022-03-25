<?php

declare(strict_types=1);

namespace Verfacto\Magento\Model;

use Magento\Framework\Model\AbstractModel;
use Verfacto\Magento\Api\Data\VerfactoInterface;
use Verfacto\Magento\Model\ResourceModel\Verfacto as ResourceModel;

class Verfacto extends AbstractModel implements VerfactoInterface
{
    /**
     * @inheriDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get consumer id.
     *
     * @return int|null
     */
    public function getConsumerId()
    {
        return $this->getData(self::CONSUMER_ID);
    }

    /**
     * Set consumer id.
     *
     * @param int $consumerId
     * @return $this
     */
    public function setConsumerId($consumerId)
    {
        return $this->setData(self::CONSUMER_ID, $consumerId);
    }

    /**
     * Set token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        return $this->setData(self::TOKEN, $token);
    }

    /**
     * Get token.
     *
     * @return string|null
     */
    public function getToken()
    {
        return $this->getData(self::TOKEN);
    }

    /**
     * Set token secret.
     *
     * @param string $tokenSecret
     * @return $this
     */
    public function setTokenSecret($tokenSecret)
    {
        return $this->setData(self::TOKEN_SECRET, $tokenSecret);
    }

    /**
     * Get token secret.
     *
     * @return string|null
     */
    public function getTokenSecret()
    {
        return $this->getData(self::TOKEN_SECRET);
    }

    /**
     * Set account email.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::ACCOUNT_EMAIL, $email);
    }

    /**
     * Get account email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::ACCOUNT_EMAIL);
    }

    /**
     * Set account name.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        return $this->setData(self::ACCOUNT_NAME, $name);
    }

    /**
     * Get account name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::ACCOUNT_NAME);
    }

    /**
     * Set account password.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        return $this->setData(self::ACCOUNT_PASSWORD, $password);
    }

    /**
     * Get account password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->getData(self::ACCOUNT_PASSWORD);
    }

    /**
     * Get account id.
     *
     * @return int|null
     */
    public function getAccountId()
    {
        return $this->getData(self::ACCOUNT_ID);
    }

    /**
     * Set account id.
     *
     * @param int $accountId
     * @return $this
     */
    public function setAccountId($accountId)
    {
        return $this->setData(self::ACCOUNT_ID, $accountId);
    }

    /**
     * Get tracking id.
     *
     * @return string|null
     */
    public function getTrackingId()
    {
        return $this->getData(self::TRACKING_ID);
    }

    /**
     * Set tracking id.
     *
     * @param string $trackingId
     * @return $this
     */
    public function setTrackingId($trackingId)
    {
        return $this->setData(self::TRACKING_ID, $trackingId);
    }

    /**
     * Get tracking Id.
     *
     * @return int
     */
    public function getIsEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }

    /**
     * Set tracking Id.
     *
     * @param int $isEnabled
     * @return $this
     */
    public function setIsEnabled($isEnabled)
    {
        return $this->setData(self::IS_ENABLED, $isEnabled);
    }

    /**
     * Get tracking Id is active.
     *
     * @return int
     */
    public function getTrackingIdByStatusEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }
}
