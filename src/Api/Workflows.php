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

    /**
     * @param string $key
     * @param array $schedule_attrs
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function createSchedules(string $key, array $schedule_attrs, array $headers = []): array
    {
        $url = $this->url('/schedules');
        $schedule_attrs['workflow'] = $key;

        return $this->postRequest($url, $schedule_attrs, $headers);
    }

    /**
     * @param array $schedule_ids
     * @param array $schedule_attrs
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function updateSchedules(array $schedule_ids, array $schedule_attrs, array $headers = []): array
    {
        $url = $this->url('/schedules');
        $schedule_attrs['schedule_ids'] = $schedule_ids;

        return $this->putRequest($url, $schedule_attrs, $headers);
    }

    /**
     * @param array $schedule_ids
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function deleteSchedules(array $schedule_ids, array $headers = []): array
    {
        $url = $this->url('/schedules');
        $body = ['schedule_ids' => $schedule_ids];

        return $this->deleteRequest($url, $body, $headers);
    }

    /**
     * @param string $key
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function listSchedules(string $key, array $params = [], array $headers = []): array
    {
        $params['workflow'] = $key;
        $url = $this->url('/schedules');

        return $this->getRequest($url, $params, $headers);
    }
}
