<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Audiences extends AbstractApi
{
    /**
     * @param string $key
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function listMembers(string $key, array $headers = []): array
    {
        $url = $this->url('/audiences/%s/members', $key);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $key
     * @param array $members
     * @param array $params
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function addMembers(string $key, array $members, array $params = [], array $headers = [])
    {
        $url = $this->url('/audiences/%s/members', $key);

        return $this->postRequest($url, ['members' => $members], $headers, $params);
    }

    /**
     * @param string $key
     * @param array $members
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function removeMembers(string $key, array $members, array $headers = [])
    {
        $url = $this->url('/audiences/%s/members', $key);

        return $this->deleteRequest($url, ['members' => $members], $headers);
    }
}
