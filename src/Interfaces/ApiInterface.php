<?php

namespace PaylandsSDK\Interfaces;

interface ApiInterface
{
    public function getApiKey(): string;

    public function getSignature(): string;

    public function getService(): string;

    public function getEnvironment(): string;

}