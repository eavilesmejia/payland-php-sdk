<?php

namespace PaylandsSDK\Services;

use PaylandsSDK\Traits\Api;
use PaylandsSDK\Interfaces\ApiInterface;

class PaymentOrder implements ApiInterface
{
    use Api;

    const REDIRECT_URL = "/payment/process/";
    const TOKENIZED_3DS_URL = "/payment/tokenized/";

    const ENDPOINTS = [
        'create_order' => '/payment',
        'tokenized_3ds' => '/payment/tokenized/',
        'direct_payment' => '/payment/direct',
    ];

    /**
     * PNP User Api key - obtained from User PNP account
     * @var string
     */
    private $api_key;

    /**
     * PNP User signature - obtained from User PNP account
     * @var string
     */
    private $signature;

    /**
     * PNP User service - obtained from User PNP account
     * @var string
     */
    private $service;

    /**
     * Environment production|sandbox
     * @var string
     */
    private $environment;

    public function __construct(string $api_key, string $signature, string $service, string $environment)
    {
        $this->api_key = $api_key;
        $this->signature = $signature;
        $this->service = $service;
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function getRedirectUrl(): string
    {
        return $this->getURL(self::REDIRECT_URL);
    }

    public function getTokenized3DSUrl(): string
    {
        return $this->getURL(self::TOKENIZED_3DS_URL);
    }

    /**
     * @param float $amount
     * @param string $operative
     * @param string $customer_ext_id
     * @param string $description
     * @param string $additional
     * @param bool $secure
     * @param string $url_post
     * @param string $url_ok
     * @param string $url_ko
     * @param string $source_uuid
     * @return array
     */
    public function createOrder(float $amount, string $operative, string $customer_ext_id, string $description, string $additional, bool $secure, string $url_post, string $url_ok, string $url_ko, string $source_uuid = ''): array
    {
        $amount_in_cents = $this->toCents($amount);
        $payload = [
            "amount" => $amount_in_cents,
            "operative" => $operative,
            "signature" => $this->signature,
            "customer_ext_id" => $customer_ext_id,
            "description" => $description,
            "service" => $this->service,
            "secure" => $secure,
            "additional" => $additional,
            "url_post" => $url_post,
            "url_ok" => $url_ok,
            "url_ko" => $url_ko,
        ];

        if (!empty($source_uuid)) {
            $payload['source_uuid'] = $source_uuid;
        }
        $api_url = $this->getURL(self::ENDPOINTS['create_order']);
        return $this->post($api_url, $payload);
    }

    /**
     * @param string $customer_ip
     * @param string $order_uuid
     * @param string $card_uuid
     * @return array
     */
    public function directPayment(string $customer_ip, string $order_uuid, string $card_uuid): array
    {
        $payload = [
            "customer_ip" => $customer_ip,
            "order_uuid" => $order_uuid,
            "card_uuid" => $card_uuid,
            "signature" => $this->getSignature(),
        ];

        $direct_payment_url = $this->getURL(self::ENDPOINTS['direct_payment']);
        return $this->post($direct_payment_url, $payload);
    }

    /**
     * @param float $number
     * @return float
     */
    private function toCents($number)
    {
        return floor(100 * $number);
    }
}