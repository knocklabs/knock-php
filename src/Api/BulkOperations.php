<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class BulkOperations extends AbstractApi
{
    /**
     * @param string $operationId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $operationId, array $headers = []): array
    {
        $url = $this->url('/bulk_operations/%s', $operationId);

        return $this->getRequest($url, [], $headers);
    }
}
