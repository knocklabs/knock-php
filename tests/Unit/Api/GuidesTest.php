<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Guides;

class GuidesTest extends ApiTest
{
    private const USER_ID = 'dr_sattler';

    /** @test */
    public function will_get_user_guides()
    {
        $channelId = '6a2a5f5c-2d2b-4f5b-9a7e-3c0e4a1b2c3d';
        $data = ['product_zone' => 'dashboard'];
        $expected = $this->getContent(sprintf('%s/data/responses/user-guides.json', __DIR__));

        $guides = $this->getApiMock();
        $guides->expects($this->once())
            ->method('getRequest')
            ->with(
                sprintf('/users/%s/guides/%s', self::USER_ID, $channelId),
                ['tenant' => 'ingen_isla_nublar', 'data' => json_encode($data)]
            )
            ->will($this->returnValue($expected));

        $this->assertEquals(
            $expected,
            $guides->getUserGuides(self::USER_ID, $channelId, ['tenant' => 'ingen_isla_nublar', 'data' => $data])
        );
    }

    /** @test */
    public function will_encode_empty_guide_data_as_an_object_and_pass_strings_through()
    {
        $channelId = '6a2a5f5c-2d2b-4f5b-9a7e-3c0e4a1b2c3d';
        $url = sprintf('/users/%s/guides/%s', self::USER_ID, $channelId);

        $guides = $this->getApiMock();
        $guides->expects($this->exactly(2))
            ->method('getRequest')
            ->withConsecutive([$url, ['data' => '{}']], [$url, ['data' => '{"page":"home"}']])
            ->will($this->returnValue([]));

        $guides->getUserGuides(self::USER_ID, $channelId, ['data' => []]);
        $guides->getUserGuides(self::USER_ID, $channelId, ['data' => '{"page":"home"}']);
    }

    /**
     * @test
     * @dataProvider guideActionProvider
     */
    public function will_perform_guide_actions(string $method, string $requestMethod, string $path)
    {
        $body = [
            'channel_id' => '6a2a5f5c-2d2b-4f5b-9a7e-3c0e4a1b2c3d',
            'guide_id' => '7e9dc78c-b3b1-4127-a54e-71f1899b831a',
            'guide_key' => 'tour_notification',
            'guide_step_ref' => 'lab_tours',
        ];
        $expected = $this->getContent(sprintf('%s/data/responses/guide-action.json', __DIR__));

        $guides = $this->getApiMock();
        $guides->expects($this->once())
            ->method($requestMethod)
            ->with(sprintf($path, self::USER_ID), $body)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $guides->$method(self::USER_ID, $body));
    }

    public function guideActionProvider(): array
    {
        return [
            ['markAsSeen', 'putRequest', '/users/%s/guides/messages/seen'],
            ['markAsInteracted', 'putRequest', '/users/%s/guides/messages/interacted'],
            ['markAsArchived', 'putRequest', '/users/%s/guides/messages/archived'],
            ['markAsUnarchived', 'deleteRequest', '/users/%s/guides/messages/archived'],
            ['resetEngagement', 'putRequest', '/users/%s/guides/engagements/reset'],
        ];
    }

    protected function getApiClass(): string
    {
        return Guides::class;
    }
}
