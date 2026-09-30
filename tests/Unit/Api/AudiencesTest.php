<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Audiences;
use PHPUnit\Framework\Attributes\Test;

class AudiencesTest extends ApiTestCase
{
    #[Test]
    public function will_list_audience_members()
    {
        $key = 'vip-users';
        $expected = $this->getContent(sprintf('%s/data/responses/audience-members.json', __DIR__));

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/audiences/%s/members', $key))
            ->willReturn($expected);

        $this->assertEquals($expected, $audiences->listMembers($key));
    }

    #[Test]
    public function will_add_audience_members()
    {
        $key = 'vip-users';
        $members = [['user' => ['id' => 'dr_sattler'], 'tenant' => 'ingen_isla_nublar']];
        $params = ['create_audience' => true];

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/audiences/%s/members', $key), ['members' => $members], [], $params)
            ->willReturn('');

        $this->assertEquals('', $audiences->addMembers($key, $members, $params));
    }

    #[Test]
    public function will_remove_audience_members()
    {
        $key = 'vip-users';
        $members = [['user' => ['id' => 'dr_sattler']]];

        $audiences = $this->getApiMock();
        $audiences->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/audiences/%s/members', $key), ['members' => $members])
            ->willReturn('');

        $this->assertEquals('', $audiences->removeMembers($key, $members));
    }

    protected function getApiClass(): string
    {
        return Audiences::class;
    }
}
