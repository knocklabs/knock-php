<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Users;
use PHPUnit\Framework\Attributes\Test;

class UsersTest extends ApiTestCase
{
    #[Test]
    public function will_identify_user()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s', $id))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->identify($id));
    }

    #[Test]
    public function will_get_user_messages()
    {
        $id = '96300c2a-a7cf-438c-a260-ea4aabe5fdde';
        $expected = $this->getContent(sprintf('%s/data/responses/user-messages.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/messages', $id))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->getMessages($id));
    }

    #[Test]
    public function will_get_user()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with('/users/user_1')
            ->willReturn($expected);

        $this->assertEquals($expected, $users->get($id));
    }

    #[Test]
    public function will_delete_user()
    {
        $id = 'user_1';
        $expected = '';

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('deleteRequest')
            ->with('/users/user_1')
            ->willReturn($expected);

        $this->assertEquals($expected, $users->delete($id));
    }

    #[Test]
    public function will_merge_users()
    {
        $toUserId = 'bce76d3f-b8a1-49ba-9f9a-d8d346f352c8';
        $fromUserId = 'd99fb23a-413c-4c32-9565-5ea3f10c691d';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/users/%s/merge', $toUserId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->merge($toUserId, $fromUserId));
    }

    #[Test]
    public function will_bulk_identify_users()
    {
        $userData = [
            [
                'id' => '6711d4b6-7e8f-4c84-8388-47eec3be89d6',
            ],
        ];

        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with('/users/bulk/identify')
            ->willReturn($expected);

        $this->assertEquals($expected, $users->bulkIdentify($userData));
    }

    #[Test]
    public function will_bulk_delete_users()
    {
        $userIds = [
            '69687856-7f7a-47f9-9d7a-76f1d916cc18',
        ];

        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with('/users/bulk/delete')
            ->willReturn($expected);

        $this->assertEquals($expected, $users->bulkDelete($userIds));
    }

    #[Test]
    public function will_get_user_preferences()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/preferences', $userId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->getPreferences($userId));
    }

    #[Test]
    public function will_get_user_preference()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';
        $preferenceId = '9493171f-12ea-4fac-bb34-bcc7fa9c5d3f';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/preferences/%s', $userId, $preferenceId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->getPreference($userId, $preferenceId));
    }

    #[Test]
    public function will_set_user_preference()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s/preferences/%s', $userId, 'default'))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->setPreferences($userId, []));
    }

    #[Test]
    public function will_bulk_set_user_preferences()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/users/bulk/preferences'))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->bulkSetPreferences([]));
    }

    #[Test]
    public function will_get_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->getChannelData($userId, $channelId));
    }

    #[Test]
    public function will_set_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->setChannelData($userId, $channelId, []));
    }

    #[Test]
    public function will_unset_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = '';

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->unsetChannelData($userId, $channelId));
    }

    #[Test]
    public function will_unset_user_preferences()
    {
        $id = 'user_1';

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/users/%s/preferences/%s', $id, 'default'))
            ->willReturn('');

        $this->assertEquals('', $users->unsetPreferences($id));
    }

    #[Test]
    public function will_get_preference_center_config()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/preference-center-config.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/preference_center/config', $id))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->getPreferenceCenterConfig($id));
    }

    #[Test]
    public function will_generate_preference_center_signed_url()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/preference-center-signed-url.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/users/%s/preference_center/signed_url', $id))
            ->willReturn($expected);

        $this->assertEquals($expected, $users->generatePreferenceCenterSignedUrl($id));
    }

    protected function getApiClass(): string
    {
        return Users::class;
    }
}
