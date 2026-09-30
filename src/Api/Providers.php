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
    public function slackAuthCheck(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/slack/%s/auth_check', $channelId);

        return $this->getRequest($url, self::encodeSlackParams($params), $headers);
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

        return $this->getRequest($url, self::encodeSlackParams($params), $headers);
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

        return $this->putRequest($url, [], $headers, self::encodeSlackParams($params));
    }

    /**
     * @param string $channelId
     * @param array $params
     * @param array $headers
     * @return array
     * @throws Exception
     */
    public function msTeamsAuthCheck(string $channelId, array $params, array $headers = []): array
    {
        $url = $this->url('/providers/ms-teams/%s/auth_check', $channelId);

        return $this->getRequest($url, self::encodeMsTeamsParams($params), $headers);
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

        return $this->getRequest($url, self::encodeMsTeamsParams($params), $headers);
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

        return $this->getRequest($url, self::encodeMsTeamsParams($params), $headers);
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

        return $this->putRequest($url, [], $headers, self::encodeMsTeamsParams($params));
    }

    /**
     * @param array $params
     * @return array
     */
    private static function encodeSlackParams(array $params): array
    {
        return self::encodeJsonParam($params, 'access_token_object');
    }

    /**
     * @param array $params
     * @return array
     */
    private static function encodeMsTeamsParams(array $params): array
    {
        return self::encodeJsonParam($params, 'ms_teams_tenant_object');
    }

    /**
     * @param array $params
     * @param string $key
     * @return array
     */
    private static function encodeJsonParam(array $params, string $key): array
    {
        if (array_key_exists($key, $params) && is_array($params[$key])) {
            $params[$key] = json_encode($params[$key]);
        }

        return $params;
    }
}
