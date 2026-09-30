<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class WorkflowRecipientRuns extends AbstractApi
{
    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function list(array $params = [], array $headers = []): array
    {
        $url = $this->url('/workflow_recipient_runs');

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $runId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $runId, array $headers = []): array
    {
        $url = $this->url('/workflow_recipient_runs/%s', $runId);

        return $this->getRequest($url, [], $headers);
    }
}
