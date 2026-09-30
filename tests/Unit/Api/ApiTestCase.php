<?php

namespace Tests\Unit\Api;

use function array_merge;

use Knock\KnockSdk\Client;
use Knock\KnockSdk\HttpClient\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Client\ClientInterface;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    /**
     * @return string
     */
    abstract protected function getApiClass(): string;

    protected function getApiMock(array $methods = []): MockObject
    {
        $builder = new Builder($this->createStub(ClientInterface::class));
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
