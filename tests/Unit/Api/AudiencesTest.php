<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Audiences;

class AudiencesTest extends ApiTest
{
    /** @test */
    public function will_list_audience_members()
    {
        $key = 'vip-users';
        $expected = $this->getContent(sprintf('%s/data/responses/audience-members.json', __DIR__));

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/audiences/%s/members', $key))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $audiences->listMembers($key));
    }

    /** @test */
    public function will_add_audience_members()
    {
        $key = 'vip-users';
        $members = [['user' => ['id' => 'dr_sattler'], 'tenant' => 'ingen_isla_nublar']];
        $params = ['create_audience' => true];

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/audiences/%s/members', $key), ['members' => $members], [], $params)
            ->will($this->returnValue(''));

        $this->assertEquals('', $audiences->addMembers($key, $members, $params));
    }

    /** @test */
    public function will_remove_audience_members()
    {
        $key = 'vip-users';
        $members = [['user' => ['id' => 'dr_sattler']]];

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/audiences/%s/members', $key), ['members' => $members])
            ->will($this->returnValue(''));

        $this->assertEquals('', $audiences->removeMembers($key, $members));
    }

    protected function getApiClass(): string
    {
        return Audiences::class;
    }
}
