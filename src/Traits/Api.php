<?php

namespace PaylandsSDK\Traits;

trait Api
{
    static $API_URL = "https://api.paylands.com/v1";
    static $SANDBOX = "/sandbox";

    private function post(string $url, array $params): array
    {
        $payload_json = json_encode($params);
        $token = $this->getApiKey();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_json);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $token,
            )
        );

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }

    private function getURL(string $endpoint): string
    {
        $env = $this->getEnvironment();
        if ($env == 'sandbox') {
            return self::$API_URL  . self::$SANDBOX . $endpoint;
        }

        return self::$API_URL . $endpoint;
    }
}