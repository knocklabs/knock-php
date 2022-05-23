<?php

namespace Tests\Unit\HttpClient;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Knock\KnockSdk\HttpClient\Builder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class BuilderTest extends TestCase
{
    /**
     * @var Builder
     */
    protected Builder $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new Builder(
            $this->createMock(ClientInterface::class),
            $this->createMock(RequestFactoryInterface::class),
        );
    }

    public function test_add_plugin_should_invalidate_http_client(): void
    {
        $client = $this->builder->getHttpClient();

        $this->builder->addPlugin($this->createMock(Plugin::class));

        $this->assertNotSame($client, $this->builder->getHttpClient());
    }

    public function test_remove_plugin_should_invalidate_http_client(): void
    {
        $this->builder->addPlugin($this->createMock(Plugin::class));

        $client = $this->builder->getHttpClient();

        $this->builder->removePlugin(Plugin::class);

        $this->assertNotSame($client, $this->builder->getHttpClient());
    }

    public function test_http_client_should_be_a_http_methods_client(): void
    {
        $this->assertInstanceOf(HttpMethodsClientInterface::class, $this->builder->getHttpClient());
    }
}
