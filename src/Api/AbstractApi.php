<?php

namespace Knock\KnockSdk\Api;

use function array_filter;
use function array_merge;
use function count;

use Http\Client\Exception;
use Knock\KnockSdk\Client;
use Knock\KnockSdk\HttpClient\Message\ResponseMediator;
use Knock\KnockSdk\HttpClient\Utils\JsonArray;
use Knock\KnockSdk\HttpClient\Utils\QueryStringBuilder;
use Psr\Http\Message\ResponseInterface;

use function sprintf;

abstract class AbstractApi
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * Create a new API instance.
     *
     * @param Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a GET request with query params and return the raw response.
     *
     * @param string $uri
     * @param array $params
     * @param array<string,string> $headers
     *
     * @return ResponseInterface
     * @throws Exception
     *
     */
    protected function getAsResponse(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        return $this->client->getHttpClient()->get($this->prepareUri($uri, $params), $headers);
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $params
     * @param array<string,string> $headers
     * @return array|string
     * @throws Exception
     */
    protected function getRequest(string $uri, array $params = [], array $headers = [])
    {
        $response = $this->getAsResponse($uri, $params, $headers);

        return ResponseMediator::getContent($response);
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $body
     * @param array<string,string> $headers
     * @return array|string
     * @throws Exception
     */
    protected function postRequest(string $uri, array $body = [], array $headers = [])
    {
        $body = self::prepareJsonBody($body);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->post($this->prepareUri($uri), $headers, $body);

        return ResponseMediator::getContent($response);
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $body
     * @param array<string,string> $headers
     * @return array|string
     * @throws Exception
     */
    protected function putRequest(string $uri, array $body = [], array $headers = [])
    {
        $body = self::prepareJsonBody($body);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->put($this->prepareUri($uri), $headers, $body ?? '');

        return ResponseMediator::getContent($response);
    }

    /**
     * @param string $uri
     * @param array<string,mixed> $body
     * @param array<string,string> $headers
     * @return array|string
     * @throws Exception
     */
    protected function deleteRequest(string $uri, array $body = [], array $headers = [])
    {
        $body = self::prepareJsonBody($body);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->delete($this->prepareUri($uri), $headers, $body ?? '');

        return ResponseMediator::getContent($response);
    }

    /**
     * Generate URL from base url and given endpoint.
     *
     * @param string $endpoint
     * @param array $replacements
     *
     * @return string
     */
    protected function url(string $endpoint, ...$replacements): string
    {
        return vsprintf($endpoint, $replacements);
    }

    /**
     * Prepare the request URI.
     *
     * @param string $uri
     * @param array $query
     *
     * @return string
     */
    protected function prepareUri(string $uri, array $query = []): string
    {
        $query = array_filter($query, function ($value): bool {
            return null !== $value;
        });

        return sprintf(
            '%s%s%s',
            $this->client->getPrefix(),
            $uri,
            QueryStringBuilder::build($query)
        );
    }

    /**
     * Add the JSON content type to the headers if one is not already present.
     *
     * @param array<string,string> $headers
     *
     * @return array<string,string>
     */
    private static function addJsonContentType(array $headers): array
    {
        return array_merge([ResponseMediator::CONTENT_TYPE_HEADER => ResponseMediator::JSON_CONTENT_TYPE], $headers);
    }

    /**
     * Prepare the request JSON body.
     *
     * @param array<string,mixed> $params
     *
     * @return string|null
     */
    private static function prepareJsonBody(array $params): ?string
    {
        $params = array_filter($params, function ($value): bool {
            return null !== $value;
        });

        if (0 === count($params)) {
            return null;
        }

        return JsonArray::encode($params);
    }
}
