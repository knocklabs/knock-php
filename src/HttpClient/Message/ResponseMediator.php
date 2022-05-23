<?php

namespace Knock\KnockSdk\HttpClient\Message;

use Knock\KnockSdk\Exception\RuntimeException;
use Knock\KnockSdk\HttpClient\Utils\JsonArray;
use Psr\Http\Message\ResponseInterface;
use function array_shift;
use function is_array;

class ResponseMediator
{
    /**
     * The content type header.
     *
     * @var string
     */
    public const CONTENT_TYPE_HEADER = 'Content-Type';

    /**
     * The JSON content type identifier.
     *
     * @var string
     */
    public const JSON_CONTENT_TYPE = 'application/json';

    /**
     * The octet stream content type identifier.
     *
     * @var string
     */
    public const STREAM_CONTENT_TYPE = 'application/octet-stream';

    /**
     * The multipart form data content type identifier.
     *
     * @var string
     */
    public const MULTIPART_CONTENT_TYPE = 'multipart/form-data';

    /**
     * Return the response body as a string or JSON array if content type is JSON.
     *
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = (string)$response->getBody();

        if (!\in_array($body, ['', 'null', 'true', 'false'], true) && 0 === \strpos($response->getHeaderLine(self::CONTENT_TYPE_HEADER), self::JSON_CONTENT_TYPE)) {
            return JsonArray::decode($body);
        }

        return $body;
    }

    /**
     * Get the error message from the response if present.
     *
     * @param ResponseInterface $response
     *
     * @return string|null
     */
    public static function getErrorMessage(ResponseInterface $response): ?string
    {
        try {
            $content = self::getContent($response);
        } catch (RuntimeException $e) {
            return null;
        }

        if (!is_array($content)) {
            return null;
        }

        if (isset($content['message'])) {
            $message = $content['message'];

            return $message;
        }

        return null;
    }
}
