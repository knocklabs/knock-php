<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Guides extends AbstractApi
{
    /**
     * @param string $userId
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getUserGuides(string $userId, string $channelId, array $params = [], array $headers = []): array
    {
        if (array_key_exists('data', $params) && is_array($params['data'])) {
            $params['data'] = json_encode($params['data']);
        }
        $url = $this->url('/users/%s/guides/%s', $userId, $channelId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function markAsSeen(string $userId, array $body, array $headers = []): array
    {
        $url = $this->url('/users/%s/guides/messages/seen', $userId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function markAsInteracted(string $userId, array $body, array $headers = []): array
    {
        $url = $this->url('/users/%s/guides/messages/interacted', $userId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function markAsArchived(string $userId, array $body, array $headers = []): array
    {
        $url = $this->url('/users/%s/guides/messages/archived', $userId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function markAsUnarchived(string $userId, array $body, array $headers = []): array
    {
        $url = $this->url('/users/%s/guides/messages/archived', $userId);

        return $this->deleteRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function resetEngagement(string $userId, array $body, array $headers = []): array
    {
        $url = $this->url('/users/%s/guides/engagements/reset', $userId);

        return $this->putRequest($url, $body, $headers);
    }
}
