<?php

namespace Tests\Unit\Api;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockHttpClient;
use Knock\KnockSdk\Api\AbstractApi;
use Knock\KnockSdk\Client;
use Knock\KnockSdk\HttpClient\Builder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AbstractApiTest extends TestCase
{
    private MockHttpClient $httpClient;

    private AbstractApi $api;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = new MockHttpClient();
        $this->httpClient->setDefaultResponse(
            new Response(200, ['Content-Type' => 'application/json'], '{}')
        );

        $client = new Client('xxx', new Builder($this->httpClient));

        $this->api = new class ($client) extends AbstractApi {
            public function post(string $uri, array $body = [], array $params = [])
            {
                return $this->postRequest($uri, $body, [], $params);
            }

            public function put(string $uri, array $body = [], array $params = [])
            {
                return $this->putRequest($uri, $body, [], $params);
            }

            public function delete(string $uri, array $body = [], array $params = [])
            {
                return $this->deleteRequest($uri, $body, [], $params);
            }
        };
    }

    #[Test]
    public function will_send_query_params_on_post_requests()
    {
        $this->api->post('/tenants/bulk/delete', [], ['tenant_ids' => ['t1', 't2']]);

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/v1/tenants/bulk/delete', $request->getUri()->getPath());
        $this->assertSame('tenant_ids%5B%5D=t1&tenant_ids%5B%5D=t2', $request->getUri()->getQuery());
    }

    #[Test]
    public function will_send_query_params_and_body_on_put_requests()
    {
        $this->api->put('/providers/slack/chan/revoke_access', ['a' => 'b'], ['access_token_object' => '{}']);

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('PUT', $request->getMethod());
        $this->assertSame('access_token_object=%7B%7D', $request->getUri()->getQuery());
        $this->assertSame('{"a":"b"}', (string) $request->getBody());
    }

    #[Test]
    public function will_send_query_params_on_delete_requests()
    {
        $this->api->delete('/audiences/vip/members', ['members' => []], ['foo' => 'bar']);

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('DELETE', $request->getMethod());
        $this->assertSame('foo=bar', $request->getUri()->getQuery());
    }

    #[Test]
    public function will_not_add_a_query_string_without_params()
    {
        $this->api->post('/users/bulk/delete', ['user_ids' => ['u1']]);

        $this->assertSame('', $this->httpClient->getLastRequest()->getUri()->getQuery());
    }
}
