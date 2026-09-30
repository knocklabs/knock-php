<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Tenants extends AbstractApi
{
    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function list(array $params = [], array $headers = []): array
    {
        $url = $this->url('/tenants');

        return $this->getRequest($url, $params, $headers);
    }

    /**
     * @param string $tenantId
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function get(string $tenantId, array $headers = []): array
    {
        $url = $this->url('/tenants/%s', $tenantId);

        return $this->getRequest($url, [], $headers);
    }

    /**
     * @param string $tenantId
     * @param array $body
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function set(string $tenantId, array $body, array $headers = []): array
    {
        $url = $this->url('/tenants/%s', $tenantId);

        return $this->putRequest($url, $body, $headers);
    }

    /**
     * @param string $tenantId
     * @param array $headers
     * @return array|string
     * @throws Exception
     */
    public function delete(string $tenantId, array $headers = [])
    {
        $url = $this->url('/tenants/%s', $tenantId);

        return $this->deleteRequest($url, [], $headers);
    }

    /**
     * @param array $tenants
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkSet(array $tenants, array $headers = []): array
    {
        $url = $this->url('/tenants/bulk/set');

        return $this->postRequest($url, ['tenants' => $tenants], $headers);
    }

    /**
     * @param array $tenantIds
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function bulkDelete(array $tenantIds, array $headers = []): array
    {
        $url = $this->url('/tenants/bulk/delete');

        return $this->postRequest($url, [], $headers, ['tenant_ids' => $tenantIds]);
    }
}
