<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Objects extends AbstractApi
{
    /**
     * @param string $collection
     * @param string $objectId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $collection, string $objectId, array $headers = []): array
    {
        $url = $this->url('/objects/%s/%s', $collection, $objectId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getMessages(string $collection, string $objectId, array $params = [], array $headers = []): array
    {
        if (array_key_exists('trigger_data', $params)) {
            $params['trigger_data'] = json_encode($params['trigger_data']);
        }
        $url = $this->url('/objects/%s/%s/messages', $collection, $objectId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function set(string $collection, string $objectId, array $body, array $headers = []): array
    {
        $url = $this->url('/objects/%s/%s', $collection, $objectId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function delete(string $collection, string $objectId, array $headers = [])
    {
        $url = $this->url('/objects/%s/%s', $collection, $objectId);

        return $this->deleteRequest($url, [], $headers);
    }

    /**
     * @param string $collection
     * @param array $objects
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkSet(string $collection, array $objects, array $headers = []): array
    {
        $url = $this->url('/objects/%s/bulk/set', $collection);

        return $this->postRequest($url, ['objects' => $objects], $headers);
    }

    /**
     * @param string $collection
     * @param array $objectIds
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkDelete(string $collection, array $objectIds, array $headers = []): array
    {
        $url = $this->url('/objects/%s/bulk/delete', $collection);

        return $this->postRequest($url, ['object_ids' => $objectIds], $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getPreferences(string $collection, string $objectId, array $headers = []): array
    {
        $url = $this->url('/objects/%s/%s/preferences', $collection, $objectId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param string $preferenceId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getPreference(string $collection, string $objectId, string $preferenceId, array $headers = []): array
    {
        $url = $this->url('/objects/%s/%s/preferences/%s', $collection, $objectId, $preferenceId);

        return $this->getRequest($url, $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param string $preferenceSetId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function setPreferences(
        string $collection,
        string $objectId,
        array $body,
        string $preferenceSetId = 'default',
        array $headers = []
    ): array {
        $url = $this->url('/objects/%s/%s/preferences/%s', $collection, $objectId, $preferenceSetId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param string $channelId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getChannelData(string $collection, string $objectId, string $channelId, array $headers = []): array
    {
        $url = $this->url('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param string $channelId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function setChannelData(
        string $collection,
        string $objectId,
        string $channelId,
        array $body,
        array $headers = []
    ): array {
        $body = ['data' => $body];
        $url = $this->url('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $collection
     * @param string $objectId
     * @param string $channelId
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function unsetChannelData(
        string $collection,
        string $objectId,
        string $channelId,
        array $headers = []
    ) {
        $url = $this->url('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId);

        return $this->deleteRequest($url, [], $headers);
    }
}
