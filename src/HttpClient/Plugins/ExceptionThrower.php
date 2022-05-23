<?php

namespace Knock\KnockSdk\HttpClient\Plugins;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Knock\KnockSdk\Exception\ClientErrorException;
use Knock\KnockSdk\Exception\ExceptionInterface;
use Knock\KnockSdk\Exception\NotFoundException;
use Knock\KnockSdk\Exception\RuntimeException;
use Knock\KnockSdk\Exception\ServerErrorException;
use Knock\KnockSdk\Exception\UnauthorizedException;
use Knock\KnockSdk\Exception\ValidationFailedException;
use Knock\KnockSdk\HttpClient\Message\ResponseMediator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ExceptionThrower implements Plugin
{
    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @param RequestInterface $request
     * @param callable $next
     * @param callable $first
     *
     * @return Promise
     * @throws ExceptionInterface
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response): ResponseInterface {
            $status = $response->getStatusCode();

            if (400 <= $status && 600 > $status) {
                throw self::createException($status, ResponseMediator::getErrorMessage($response) ?? $response->getReasonPhrase());
            }

            return $response;
        });
    }

    /**
     * Create an exception from a status code and error message.
     *
     * @param int $status
     * @param string $message
     *
     * @return ExceptionInterface
     */
    protected static function createException(int $status, string $message): ExceptionInterface
    {
        if (401 === $status) {
            return new UnauthorizedException($message, $status);
        }

        if (404 === $status) {
            return new NotFoundException($message, $status);
        }

        if (422 === $status) {
            return new ValidationFailedException($message, $status);
        }

        if (400 <= $status && 499 >= $status) {
            return new ClientErrorException($message, $status);
        }

        if (500 <= $status && 599 >= $status) {
            return new ServerErrorException($message, $status);
        }

        return new RuntimeException($message, $status);
    }
}
