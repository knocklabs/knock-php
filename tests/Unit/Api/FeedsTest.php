<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Feeds;

class FeedsTest extends ApiTest
{
    /** @test */
    public function will_return_feeds_for_user()
    {
        $userId = 'user_1';
        $feedId = '970f36fd-147a-4a7d-88f2-1b6550b15e0c';
        $expected = $this->getContent(sprintf('%s/data/responses/feed.json', __DIR__));

        $feeds = $this->getApiMock();
        $feeds->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/feeds/%s', $userId, $feedId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $feeds->getUserFeed($userId, $feedId));
    }

    protected function getApiClass(): string
    {
        return Feeds::class;
    }
}
