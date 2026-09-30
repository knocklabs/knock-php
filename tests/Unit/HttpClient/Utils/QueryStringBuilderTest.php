<?php

namespace Tests\Unit\HttpClient\Utils;

use Knock\KnockSdk\HttpClient\Utils\QueryStringBuilder;
use PHPUnit\Framework\TestCase;

use function sprintf;

class QueryStringBuilderTest extends TestCase
{
    /**
     * @dataProvider queryStringProvider
     *
     * @param array $query
     * @param string $expected
     */
    public function testBuild(array $query, string $expected): void
    {
        $this->assertSame(sprintf('?%s', $expected), QueryStringBuilder::build($query));
    }

    public function queryStringProvider()
    {
        yield 'key value pairs' => [
            [
                'per_page' => 30,
            ],
            'per_page=30',
        ];

        yield 'list arrays use empty brackets' => [
            [
                'message_ids' => ['msg_1', 'msg_2'],
            ],
            'message_ids%5B%5D=msg_1&message_ids%5B%5D=msg_2',
        ];

        yield 'associative arrays use keyed brackets' => [
            [
                'query_options' => ['cursor' => 'abc', 'limit' => 10],
            ],
            'query_options%5Bcursor%5D=abc&query_options%5Blimit%5D=10',
        ];

        yield 'booleans are encoded as true and false' => [
            [
                'has_errors' => true,
                'create_audience' => false,
            ],
            'has_errors=true&create_audience=false',
        ];

        yield 'null values are skipped' => [
            [
                'tenant' => null,
                'workflow' => 'comment-created',
            ],
            'workflow=comment-created',
        ];
    }

    public function testBuildReturnsEmptyStringForEmptyQuery(): void
    {
        $this->assertSame('', QueryStringBuilder::build([]));
        $this->assertSame('', QueryStringBuilder::build(['tenant_ids' => []]));
    }
}
