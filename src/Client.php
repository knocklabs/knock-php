<?php

namespace Knock\KnockSdk;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Exception;
use Knock\KnockSdk\Api\BulkOperations;
use Knock\KnockSdk\Api\Feeds;
use Knock\KnockSdk\Api\Messages;
use Knock\KnockSdk\Api\Objects;
use Knock\KnockSdk\Api\Users;
use Knock\KnockSdk\Api\Workflows;
use Knock\KnockSdk\HttpClient\Builder;
use Knock\KnockSdk\HttpClient\Plugins\Authentication;
use Knock\KnockSdk\HttpClient\Plugins\ExceptionThrower;

class Client
{
    /**
     * @var string
     */
    protected string $host = 'https://api.knock.app';

    /**
     * @var string
     */
    protected string $prefix = '/v1';

    /**
     * The HTTP client builder.
     *
     * @var Builder
     */
    protected Builder $httpClientBuilder;

    /**
     * @param string $token
     * @param Builder|null $httpClientBuilder
     */
    public function __construct(string $token, Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new ExceptionThrower());
        $builder->addPlugin(new Authentication($token));

        $this->setHost($this->host);
    }

    /**
     * @param string $url
     * @return void
     */
    public function setHost(string $url): void
    {
        $uri = $this->getHttpClientBuilder()->getUriFactory()->createUri($url);

        $this->getHttpClientBuilder()->removePlugin(AddHostPlugin::class);
        $this->getHttpClientBuilder()->addPlugin(new AddHostPlugin($uri));
    }

    /**
     * @param string $prefix
     * @return void
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the HTTP client.
     *
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * Get the HTTP client builder.
     *
     * @return Builder
     */
    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }

    /**
     * @return BulkOperations
     */
    public function bulkOperations(): BulkOperations
    {
        return new BulkOperations($this);
    }

    /**
     * @return Feeds
     */
    public function feeds(): Feeds
    {
        return new Feeds($this);
    }

    /**
     * @return Messages
     */
    public function messages(): Messages
    {
        return new Messages($this);
    }

    /**
     * @return Objects
     */
    public function objects(): Objects
    {
        return new Objects($this);
    }

    /**
     * @return Users
     */
    public function users(): Users
    {
        return new Users($this);
    }

    /**
     * @return Workflows
     */
    public function workflows(): Workflows
    {
        return new Workflows($this);
    }

    /**
     * @param string $key
     * @param array $body
     * @return array
     * @throws Exception
     */
    public function notify(string $key, array $body): array
    {
        return $this->workflows()->trigger($key, $body);
    }
}
