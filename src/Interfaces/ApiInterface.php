<?php

namespace PaylandsSDK\Interfaces;

interface ApiInterface
{
    public function getApiKey(): string;

    public function getSignature(): string;

    public function getService(): string;

    public function getEnvironment(): string;

    public function getRedirectUrl(): string;

    public function getTokenized3DSUrl(): string;
}