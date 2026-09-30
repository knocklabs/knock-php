<?php

namespace Tests\Unit;

use Knock\KnockSdk\Api\Audiences;
use Knock\KnockSdk\Api\BulkOperations;
use Knock\KnockSdk\Api\Feeds;
use Knock\KnockSdk\Api\Messages;
use Knock\KnockSdk\Api\Objects;
use Knock\KnockSdk\Api\Providers;
use Knock\KnockSdk\Api\Tenants;
use Knock\KnockSdk\Api\Users;
use Knock\KnockSdk\Api\Workflows;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function will_return_provided_class_names($methodName, $className)
    {
        $this->assertInstanceOf($className, $this->client->$methodName());
    }

    public function provider(): array
    {
        return [
            ['audiences', Audiences::class],
            ['bulkOperations', BulkOperations::class],
            ['feeds', Feeds::class],
            ['messages', Messages::class],
            ['objects', Objects::class],
            ['providers', Providers::class],
            ['tenants', Tenants::class],
            ['users', Users::class],
            ['workflows', Workflows::class],
        ];
    }
}
