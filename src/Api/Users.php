<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Users extends AbstractApi
{
    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function identify(string $userId, array $body = [], array $headers = []): array
    {
        $url = $this->url('/users/%s', $userId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $userId, array $params = [], array $headers = []): array
    {
        $url = $this->url('/users/%s', $userId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $userId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getMessages(string $userId, array $params = [], array $headers = []): array
    {
        $url = $this->url('/users/%s/messages', $userId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function delete(string $userId, array $body = [], array $headers = [])
    {
        $url = $this->url('/users/%s', $userId);

        return $this->deleteRequest($url, $body, $headers);
    }

    /**
     * @param string $toUserId
     * @param string $fromUserId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function merge(string $toUserId, string $fromUserId, array $headers = []): array
    {
        $url = $this->url('/users/%s/merge', $toUserId);

        return $this->postRequest($url, ['from_user_id' => $fromUserId], $headers);
    }

    /**
     * @param array $users
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkIdentify(array $users = [], array $headers = []): array
    {
        $url = $this->url('/users/bulk/identify');

        return $this->postRequest($url, ['users' => $users], $headers);
    }

    /**
     * @param array $userIds
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkDelete(array $userIds = [], array $headers = []): array
    {
        $url = $this->url('/users/bulk/delete');

        return $this->postRequest($url, ['user_ids' => $userIds], $headers);
    }

    /**
     * @param string $userId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getPreferences(string $userId, array $params = [], array $headers = []): array
    {
        $url = $this->url('/users/%s/preferences', $userId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $userId
     * @param string $preferenceId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getPreference(string $userId, string $preferenceId, array $params = [], array $headers = []): array
    {
        $url = $this->url('/users/%s/preferences/%s', $userId, $preferenceId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $userId
     * @param array $body
     * @param string $preferenceSetId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function setPreferences(
        string $userId,
        array $body = [],
        string $preferenceSetId = 'default',
        array $headers = []
    ): array {
        $url = $this->url('/users/%s/preferences/%s', $userId, $preferenceSetId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkSetPreferences(array $body, array $headers = []): array
    {
        $url = $this->url('/users/bulk/preferences');

        return $this->postRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param string $channelId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getChannelData(string $userId, string $channelId, array $headers = []): array
    {
        $url = $this->url('/users/%s/channel_data/%s', $userId, $channelId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $userId
     * @param string $channelId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function setChannelData(string $userId, string $channelId, array $body, array $headers = []): array
    {
        $body = ['data' => $body];
        $url = $this->url('/users/%s/channel_data/%s', $userId, $channelId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $userId
     * @param string $channelId
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function unsetChannelData(string $userId, string $channelId, array $headers = [])
    {
        $url = $this->url('/users/%s/channel_data/%s', $userId, $channelId);

        return $this->deleteRequest($url, [], $headers);
    }
}
