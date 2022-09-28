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
    }
}
