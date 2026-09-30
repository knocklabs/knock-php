<?php

namespace Knock\KnockSdk\Api;

use Http\Client\Exception;

class Providers extends AbstractApi
{
    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function slackCheckAuth(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/slack/%s/auth_check', $channelId);

        return $this->getRequest($url, self::encodeJsonParam($params, 'access_token_object'), $headers);
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function slackListChannels(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/slack/%s/channels', $channelId);

        return $this->getRequest($url, self::encodeJsonParam($params, 'access_token_object'), $headers);
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function slackRevokeAccess(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/slack/%s/revoke_access', $channelId);

        return $this->putRequest($url, [], $headers, self::encodeJsonParam($params, 'access_token_object'));
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function msTeamsCheckAuth(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/ms-teams/%s/auth_check', $channelId);

        return $this->getRequest($url, self::encodeJsonParam($params, 'ms_teams_tenant_object'), $headers);
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function msTeamsListTeams(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/ms-teams/%s/teams', $channelId);

        return $this->getRequest($url, self::encodeJsonParam($params, 'ms_teams_tenant_object'), $headers);
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function msTeamsListChannels(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/ms-teams/%s/channels', $channelId);

        return $this->getRequest($url, self::encodeJsonParam($params, 'ms_teams_tenant_object'), $headers);
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function msTeamsRevokeAccess(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/ms-teams/%s/revoke_access', $channelId);

        return $this->putRequest($url, [], $headers, self::encodeJsonParam($params, 'ms_teams_tenant_object'));
    }
}
