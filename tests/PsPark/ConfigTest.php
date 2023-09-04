<?php

declare(strict_types=1);

namespace PsPark;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConstruct(): void
    {
        $testJwtKey = 'test-jwt-key';
        $testApiKey = 'test-api-key';
        $testOptions = [
            'foo' => 'bar',
            'bar' => 'bas',
        ];

        $requestConfig = new Config(jwtKey: $testJwtKey, apiKey: $testApiKey, curlOptions: $testOptions);

        $this->assertEquals($testJwtKey, $requestConfig->getJwtKey());
        $this->assertEquals($testApiKey, $requestConfig->getApiKey());
        $this->assertEquals($testOptions, $requestConfig->getCurlOptions());
    }

    public function testDebugMode(): void
    {
        $testJwtKey = 'test-jwt-key';
        $testApiKey = 'test-api-key';

        $requestConfig = (new Config($testJwtKey, $testApiKey))->enableDebugMode();

        $this->assertTrue($requestConfig->isDebugMode());
    }

    public function testOptions(): void
    {
        $testJwtKey = 'test-jwt-key';
        $testApiKey = 'test-api-key';
        $options = [
            Config::CUSTOM_BASE_URL_OPTION => 'https://host.com',
        ];

        $requestConfig = new Config(jwtKey: $testJwtKey, apiKey: $testApiKey, options: $options);

        $this->assertTrue($requestConfig->hasOptions(Config::CUSTOM_BASE_URL_OPTION));
        $this->assertSame(
            $requestConfig->getOptionByKey(Config::CUSTOM_BASE_URL_OPTION),
            $options[Config::CUSTOM_BASE_URL_OPTION]
        );
    }
}
