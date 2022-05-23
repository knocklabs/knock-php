<?php

namespace Tests\Unit\HttpClient\Message;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Knock\KnockSdk\Exception\RuntimeException;
use Knock\KnockSdk\HttpClient\Message\ResponseMediator;
use PHPUnit\Framework\TestCase;

class ResponseMediatorTest extends TestCase
{
    /** @test */
    public function get_content(): void
    {
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor('{"foo": "bar"}')
        );

        $this->assertSame(['foo' => 'bar'], ResponseMediator::getContent($response));
    }

    /** @test */
    public function get_content_not_json(): void
    {
        $response = new Response(
            200,
            [],
            Utils::streamFor('foobar')
        );

        $this->assertSame('foobar', ResponseMediator::getContent($response));
    }

    /** @test */
    public function get_content_invalid_json(): void
    {
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor('foobar')
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('json_decode error: Syntax error');

        ResponseMediator::getContent($response);
    }

    /** @test */
    public function get_error_message_invalid_json(): void
    {
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor('foobar')
        );

        $this->assertNull(ResponseMediator::getErrorMessage($response));
    }
}
