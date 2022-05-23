<?php

namespace Tests;

use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;
use Knock\KnockSdk\Client;
use Knock\KnockSdk\HttpClient\Builder;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected Client $client;

    protected Builder $builder;

    public function setUp(): void
    {
        parent::setUp();

        Psr18ClientDiscovery::prependStrategy(MockClientStrategy::class);

        $this->builder = new Builder();
        $this->client = new Client('xxx', $this->builder);
    }
}
