<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Messages extends AbstractApi
{
    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function list(array $params = [], array $headers = []): array
    {
        if (array_key_exists('trigger_data', $params)) {
          $params['trigger_data'] = json_encode($params['trigger_data']);
        }
        $url = $this->url('/messages');

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $messageId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $messageId, array $headers = []): array
    {
        $url = $this->url('/messages/%s', $messageId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $messageId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getActivities(string $messageId, array $params = [], array $headers = []): array
    {
        if (array_key_exists('trigger_data', $params)) {
          $params['trigger_data'] = json_encode($params['trigger_data']);
        }
        $url = $this->url('/messages/%s/activities', $messageId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $messageId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getEvents(string $messageId, array $params = [], array $headers = []): array
    {
        $url = $this->url('/messages/%s/events', $messageId);

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $messageId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function getContent(string $messageId, array $headers = []): array
    {
        $url = $this->url('/messages/%s/content', $messageId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $messageId
     * @param string $status
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function updateStatus(string $messageId, string $status, array $headers = []): array
    {
        $url = $this->url('/messages/%s/%s', $messageId, $status);

        return $this->putRequest($url, [], $headers);
    }

    /**
     * @param string $messageId
     * @param string $status
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function undoStatus(string $messageId, string $status, array $headers = []): array
    {
        $url = $this->url('/messages/%s/%s', $messageId, $status);

        return $this->deleteRequest($url, [], $headers);
    }

    /**
     * @param string $status
     * @param array $messageIds
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function batchChangeStatus(string $status, array $messageIds, array $headers = []): array
    {
        $url = $this->url('/messages/batch/%s', $status);

        return $this->postRequest($url, ['message_ids' => $messageIds], $headers);
    }

    /**
     * @param string $channel
     * @param string $status
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkUpdateChannelStatus(string $channel, string $status, array $body, array $headers = []): array
    {
        $url = $this->url('/channels/%s/messages/bulk/%s', $channel, $status);

        return $this->postRequest($url, $body, $headers);
    }
}
