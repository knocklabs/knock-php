<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Feeds extends AbstractApi
{
    /**
     * @param string $userId
     * @param string $feedId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getUserFeed(string $userId, string $feedId, array $params = [], array $headers = []): array
    {
        if (array_key_exists('trigger_data', $params)) {
          $params['trigger_data'] = json_encode($params['trigger_data']);
        }
        $url = $this->url('/users/%s/feeds/%s', $userId, $feedId);

        return $this->getRequest($url, $params, $headers);
    }
}
