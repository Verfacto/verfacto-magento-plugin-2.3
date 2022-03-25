<?php

declare(strict_types=1);

namespace Verfacto\Magento\Api\Data;

interface VerfactoInterface
{
    /**
     * Key columns.
     */
    public const ID = 'id';
    public const CONSUMER_ID = 'consumer_id';
    public const TOKEN = 'token';
    public const TOKEN_SECRET = 'token_secret';
    public const ACCOUNT_EMAIL = 'email';
    public const ACCOUNT_NAME = 'name';
    public const ACCOUNT_PASSWORD = 'password';
    public const ACCOUNT_ID = 'account_id';
    public const TRACKING_ID = 'tracking_id';
    public const IS_ENABLED = 'is_enabled';
    public const TABLE_NAME = 'verfacto_tracking_id';

    /**
     * Set id.
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set consumer id.
     *
     * @param int $id
     * @return $this
     */
    public function setConsumerId($id);

    /**
     * Get consumer id.
     *
     * @return int|null
     */
    public function getConsumerId();

    /**
     * Set token.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token);

    /**
     * Get token.
     *
     * @return string|null
     */
    public function getToken();

    /**
     * Set token secret.
     *
     * @param string $tokenSecret
     * @return $this
     */
    public function setTokenSecret($tokenSecret);

    /**
     * Get token secret.
     *
     * @return string|null
     */
    public function getTokenSecret();

    /**
     * Set account email.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * Get account email.
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set account name.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * Get account name.
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set account password.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password);

    /**
     * Get account password.
     *
     * @return string|null
     */
    public function getPassword();

    /**
     * Set account id.
     *
     * @param int $accountId
     * @return $this
     */
    public function setAccountId($accountId);

    /**
     * Get account id.
     *
     * @return int|null
     */
    public function getAccountId();

    /**
     * Set tracking id.
     *
     * @param string $trackingId
     * @return $this
     */
    public function setTrackingId($trackingId);

    /**
     * Get tracking id.
     *
     * @return string|null
     */
    public function getTrackingId();

    /**
     * Set tracking Id is active.
     *
     * @param int $isEnabled
     * @return $this
     */
    public function setIsEnabled($isEnabled);

    /**
     * Get tracking Id is active.
     *
     * @return int|null
     */
    public function getIsEnabled();
}
