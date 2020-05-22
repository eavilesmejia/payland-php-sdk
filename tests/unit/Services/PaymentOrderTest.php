<?php

use PHPUnit\Framework\TestCase;
use PaylandsSDK\Services\PaymentOrder;

class PaymentOrderTest extends TestCase
{

    public function testCreateOrder(): void
    {
        $pnp = new PaymentOrder(
            "be2dd40a38f34848a79b90958abf63f8",
            "aaLr6JoOQ5q7sazw16rb5acB",
            "716D4C07-72A5-41C6-9B55-E10680825F73",
            "sandbox"
        );

        //secure payment
        $order = $pnp->createOrder(
            100.5,
            "AUTHORIZATION",
            "123",
            "test05",
            "5",
            false,
            "http://requestbin.net/r/ze9kz2ze",
            'http://requestbin.net?ok=1',
            'http://requestbin.net?ko=1'
        );
        $this->assertIsArray($order);
        $this->assertIsString($pnp->getRedirectUrl() . $order["order"]["token"]);
        echo $pnp->getRedirectUrl() . $order["order"]["token"] . PHP_EOL;
    }
    public function testCreate3DSOrder(): void
    {
        $pnp = new PaymentOrder(
            "be2dd40a38f34848a79b90958abf63f8",
            "aaLr6JoOQ5q7sazw16rb5acB",
            "716D4C07-72A5-41C6-9B55-E10680825F73",
            "sandbox"
        );

        //secure payment
        $order = $pnp->createOrder(
            100.5,
            "AUTHORIZATION",
            "123",
            "test05",
            "5",
            true,
            "http://requestbin.net/r/s9nj2ms9",
            'http://requestbin.net/r/s9nj2ms9?ok=1',
            'http://requestbin.net/r/s9nj2ms9?ko=1',
            '0B4B3204-F9A9-4CFC-B9FD-1DDDB1CB0302' //card UUID
        );

        $this->assertIsArray($order);
        $this->assertIsString($pnp->getTokenized3DSUrl() . $order["order"]["token"]);
        echo $pnp->getTokenized3DSUrl() . $order["order"]["token"] . PHP_EOL;
    }

    public function testDirectPayment(): void
    {
        $pnp = new PaymentOrder(
            "be2dd40a38f34848a79b90958abf63f8",
            "aaLr6JoOQ5q7sazw16rb5acB",
            "716D4C07-72A5-41C6-9B55-E10680825F73",
            "sandbox"
        );

        $order = $pnp->createOrder(
            50.5,
            "AUTHORIZATION",
            "123",
            "test05",
            "6",
            false,
            "http://requestbin.net/r/s9nj2ms9",
            'http://requestbin.net/r/s9nj2ms9?ok=1',
            'http://requestbin.net/r/s9nj2ms9?ko=1'
        );

        $this->assertIsArray($order);

        $order_uuid = $order["order"]["uuid"];
        $card_uuid = "501D8E30-2CDA-459A-BA55-28FC5F05C5A8";
        $customer_ip = "190.53.39.47";

        $dp = $pnp->directPayment($customer_ip, $order_uuid, $card_uuid);
        $this->assertIsArray($dp);
    }
}