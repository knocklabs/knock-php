<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Feeds;
use PHPUnit\Framework\Attributes\Test;

class FeedsTest extends ApiTestCase
{
    #[Test]
    public function will_return_feeds_for_user()
    {
        $userId = 'user_1';
        $feedId = '970f36fd-147a-4a7d-88f2-1b6550b15e0c';
        $expected = $this->getContent(sprintf('%s/data/responses/feed.json', __DIR__));

        $feeds = $this->getApiMock();
        $feeds->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/feeds/%s', $userId, $feedId))
            ->willReturn($expected);

        $this->assertEquals($expected, $feeds->getUserFeed($userId, $feedId));
    }

    #[Test]
    public function will_get_user_feed_settings()
    {
        $userId = 'user_1';
        $feedId = '0a0e0f28-6a52-4c7f-8b0a-2b7a0d3e4f11';
        $expected = $this->getContent(sprintf('%s/data/responses/feed-settings.json', __DIR__));

        $feeds = $this->getApiMock();
        $feeds->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/feeds/%s/settings', $userId, $feedId))
            ->willReturn($expected);

        $this->assertEquals($expected, $feeds->getUserFeedSettings($userId, $feedId));
    }

    protected function getApiClass(): string
    {
        return Feeds::class;
    }
}
