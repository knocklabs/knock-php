<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Providers;

class ProvidersTest extends ApiTest
{
    private const CHANNEL_ID = '6a2a5f5c-2d2b-4f5b-9a7e-3c0e4a1b2c3d';

    /** @test */
    public function will_check_slack_auth()
    {
        $params = ['access_token_object' => '{"collection":"projects","object_id":"project_123"}'];
        $expected = $this->getContent(sprintf('%s/data/responses/slack-auth-check.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/providers/slack/%s/auth_check', self::CHANNEL_ID), $params)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->slackAuthCheck(self::CHANNEL_ID, $params));
    }

    /** @test */
    public function will_json_encode_slack_access_token_object_arrays()
    {
        $tokenObject = ['collection' => 'projects', 'object_id' => 'project_123'];
        $queryOptions = ['limit' => 10, 'types' => 'public_channel'];
        $expected = $this->getContent(sprintf('%s/data/responses/slack-channels.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('getRequest')
            ->with(
                sprintf('/providers/slack/%s/channels', self::CHANNEL_ID),
                ['access_token_object' => json_encode($tokenObject), 'query_options' => $queryOptions]
            )
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->slackListChannels(self::CHANNEL_ID, [
            'access_token_object' => $tokenObject,
            'query_options' => $queryOptions,
        ]));
    }

    /** @test */
    public function will_revoke_slack_access()
    {
        $params = ['access_token_object' => '{"user_id":"user_123"}'];
        $expected = $this->getContent(sprintf('%s/data/responses/provider-revoke-access.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/providers/slack/%s/revoke_access', self::CHANNEL_ID), [], [], $params)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->slackRevokeAccess(self::CHANNEL_ID, $params));
    }

    /** @test */
    public function will_check_ms_teams_auth()
    {
        $tenantObject = ['collection' => 'projects', 'object_id' => 'project_123'];
        $expected = $this->getContent(sprintf('%s/data/responses/ms-teams-auth-check.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('getRequest')
            ->with(
                sprintf('/providers/ms-teams/%s/auth_check', self::CHANNEL_ID),
                ['ms_teams_tenant_object' => json_encode($tenantObject)]
            )
            ->will($this->returnValue($expected));

        $this->assertEquals(
            $expected,
            $providers->msTeamsAuthCheck(self::CHANNEL_ID, ['ms_teams_tenant_object' => $tenantObject])
        );
    }

    /** @test */
    public function will_list_ms_teams_teams()
    {
        $params = ['ms_teams_tenant_object' => '{"user_id":"user_123"}', 'query_options' => ['$top' => 10]];
        $expected = $this->getContent(sprintf('%s/data/responses/ms-teams-teams.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/providers/ms-teams/%s/teams', self::CHANNEL_ID), $params)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->msTeamsListTeams(self::CHANNEL_ID, $params));
    }

    /** @test */
    public function will_list_ms_teams_channels()
    {
        $params = ['ms_teams_tenant_object' => '{"user_id":"user_123"}', 'team_id' => 'team-1'];
        $expected = $this->getContent(sprintf('%s/data/responses/ms-teams-channels.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/providers/ms-teams/%s/channels', self::CHANNEL_ID), $params)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->msTeamsListChannels(self::CHANNEL_ID, $params));
    }

    /** @test */
    public function will_revoke_ms_teams_access()
    {
        $params = ['ms_teams_tenant_object' => '{"user_id":"user_123"}'];
        $expected = $this->getContent(sprintf('%s/data/responses/provider-revoke-access.json', __DIR__));

        $providers = $this->getApiMock();
        $providers->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/providers/ms-teams/%s/revoke_access', self::CHANNEL_ID), [], [], $params)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $providers->msTeamsRevokeAccess(self::CHANNEL_ID, $params));
    }

    protected function getApiClass(): string
    {
        return Providers::class;
    }
}
