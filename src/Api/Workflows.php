<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Workflows extends AbstractApi
{
    /**
     * @param string $key
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function trigger(string $key, array $body, array $headers = []): array
    {
        $url = $this->url('/workflows/%s/trigger', $key);

        return $this->postRequest($url, $body, $headers);
    }

    /**
     * @param string $key
     * @param array $body
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function cancel(string $key, array $body, array $headers = [])
    {
        $url = $this->url('/workflows/%s/cancel', $key);

        return $this->postRequest($url, $body, $headers);
    }
}
