<?php

namespace Tests\Unit;

use Knock\KnockSdk\Api\Audiences;
use Knock\KnockSdk\Api\BulkOperations;
use Knock\KnockSdk\Api\Feeds;
use Knock\KnockSdk\Api\Guides;
use Knock\KnockSdk\Api\Messages;
use Knock\KnockSdk\Api\Objects;
use Knock\KnockSdk\Api\Providers;
use Knock\KnockSdk\Api\Tenants;
use Knock\KnockSdk\Api\Users;
use Knock\KnockSdk\Api\WorkflowRecipientRuns;
use Knock\KnockSdk\Api\Workflows;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientTest extends TestCase
{
    #[Test]
    #[DataProvider('provider')]
    public function will_return_provided_class_names($methodName, $className)
    {
        $this->assertInstanceOf($className, $this->client->$methodName());
    }

    public static function provider(): array
    {
        return [
            ['audiences', Audiences::class],
            ['bulkOperations', BulkOperations::class],
            ['feeds', Feeds::class],
            ['guides', Guides::class],
            ['messages', Messages::class],
            ['objects', Objects::class],
            ['providers', Providers::class],
            ['tenants', Tenants::class],
            ['users', Users::class],
            ['workflowRecipientRuns', WorkflowRecipientRuns::class],
            ['workflows', Workflows::class],
        ];
    }
}
