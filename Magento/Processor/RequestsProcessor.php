<?php

declare(strict_types=1);

namespace Verfacto\Magento\Processor;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;
use Verfacto\Magento\Api\Data\MetaDataInterface;

class RequestsProcessor
{
    /**
     * @var Json
     */
    private $json;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * IntegrationProcessor constructor.
     *
     * @param Json $json
     * @param Curl $curl
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Json $json,
        Curl $curl,
        StoreManagerInterface $storeManager
    ) {
        $this->json = $json;
        $this->curl = $curl;
        $this->storeManager = $storeManager;
    }

    /**
     * Get Tracking Info.
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $accessKey
     * @param string $accessKeySecret
     * @param string $accessToken
     * @param string $accessTokenSecret
     * @param string $shopUrl
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getTrackingData(
        string $name,
        string $password,
        string $email,
        string $accessKey,
        string $accessKeySecret,
        string $accessToken,
        string $accessTokenSecret,
        string $shopUrl
    ): array {
        $params = $this->json->serialize([
            'access_key'          => $accessKey,
            'access_key_secret'   => $accessKeySecret,
            'access_token'        => $accessToken,
            'access_token_secret' => $accessTokenSecret,
            'name'                => $name,
            'owner_email'         => $email,
            'shop_currency'       => $this->storeManager->getStore()->getCurrentCurrency()->getCode(),
            'shop_url'            => $shopUrl,
            'password'            => $password
        ]);

        $this->curl->addHeader('Content-Type', 'application/json');
        $this->curl->addHeader('Accept', '*/*');
        $this->curl->addHeader('Content-Length', strlen($params));
        $this->curl->post(MetaDataInterface::END_POINT . MetaDataInterface::END_POINT_TRACKING_ID, $params);

        return $this->json->unserialize($this->curl->getBody());
    }

    /**
     * Check Account Exists.
     *
     * @param string $name
     * @param string $password
     * @param string $email
     *
     * @return array
     */
    public function signInAccount(string $name, string $password, string $email): array
    {
        $params = $this->json->serialize([
            'account_name' => $name,
            'email'        => $email,
            'password'     => $password
        ]);

        $this->curl->addHeader('Content-Type', 'application/json');
        $this->curl->addHeader('Accept', '*/*');
        $this->curl->addHeader('Content-Length', strlen($params));
        $this->curl->post(MetaDataInterface::END_POINT . MetaDataInterface::END_POINT_ACCOUNT, $params);

        return $this->json->unserialize($this->curl->getBody());
    }

    /**
     * Disable Account.
     *
     * @param string $accountId
     * @param array $tokenData
     */
    public function disableModuleVerfacto(string $accountId, array $tokenData)
    {
        $params = $this->json->serialize([
            'to_delete_at'      => gmdate('Y-m-d H:i:s', strtotime('+14 DAY')),
            'send_notification' => true
        ]);

        $request_url = MetaDataInterface::END_POINT . 'accounts/' . $accountId . MetaDataInterface::END_POINT_DISABLE_ACCOUNT;

        $ch = curl_init($request_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Accept', '/',
                'Content-Length: ' . strlen($params),
                'Authorization: ' . $tokenData['auth_token']
            ]
        );
        curl_exec($ch);
        curl_close($ch);
    }
}
