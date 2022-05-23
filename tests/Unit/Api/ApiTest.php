<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Client;
use Knock\KnockSdk\HttpClient\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Client\ClientInterface;
use Tests\TestCase;
use function array_merge;

abstract class ApiTest extends TestCase
{
    /**
     * @return string
     */
    abstract protected function getApiClass(): string;

    protected function getApiMock(array $methods = []): MockObject
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $builder = new Builder($httpClient);
        $client = new Client('xxx', $builder);

        return $this->getMockBuilder($this->getApiClass())
            ->onlyMethods(array_merge(['getRequest', 'postRequest', 'deleteRequest', 'putRequest'], $methods))
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    public function getContent($path)
    {
        $content = file_get_contents($path);

        return json_decode($content, true);
    }
}
