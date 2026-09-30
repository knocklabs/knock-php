<?php

namespace Tests\Unit\HttpClient\Utils;

use Knock\KnockSdk\HttpClient\Utils\QueryStringBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

class QueryStringBuilderTest extends TestCase
{
    /**
     * @param array $query
     * @param string $expected
     */
    #[DataProvider('queryStringProvider')]
    public function testBuild(array $query, string $expected): void
    {
        $this->assertSame(sprintf('?%s', $expected), QueryStringBuilder::build($query));
    }

    public static function queryStringProvider()
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

        yield 'lists of arrays use indexed brackets' => [
            [
                'objects' => [
                    ['collection' => 'projects', 'id' => 'p1'],
                    ['collection' => 'teams', 'id' => 't1'],
                ],
            ],
            'objects%5B0%5D%5Bcollection%5D=projects&objects%5B0%5D%5Bid%5D=p1'
                . '&objects%5B1%5D%5Bcollection%5D=teams&objects%5B1%5D%5Bid%5D=t1',
        ];

        yield 'nested null values are skipped' => [
            [
                'query_options' => ['cursor' => null, 'limit' => 10],
            ],
            'query_options%5Blimit%5D=10',
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
