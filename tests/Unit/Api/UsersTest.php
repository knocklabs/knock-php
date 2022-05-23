<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Users;

class UsersTest extends ApiTest
{
    /** @test */
    public function will_identify_user()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->identify($id));
    }

    /** @test */
    public function will_get_user_messages()
    {
        $id = '96300c2a-a7cf-438c-a260-ea4aabe5fdde';
        $expected = $this->getContent(sprintf('%s/data/responses/user-messages.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/messages', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->getMessages($id));
    }

    /** @test */
    public function will_get_user()
    {
        $id = 'user_1';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with('/users/user_1')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->get($id));
    }

    /** @test */
    public function will_delete_user()
    {
        $id = 'user_1';
        $expected = '';

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('deleteRequest')
            ->with('/users/user_1')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->delete($id));
    }

    /** @test */
    public function will_merge_users()
    {
        $toUserId = 'bce76d3f-b8a1-49ba-9f9a-d8d346f352c8';
        $fromUserId = 'd99fb23a-413c-4c32-9565-5ea3f10c691d';
        $expected = $this->getContent(sprintf('%s/data/responses/user.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/users/%s/merge', $toUserId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->merge($toUserId, $fromUserId));
    }

    /** @test */
    public function will_bulk_identify_users()
    {
        $userData = [
            [
                'id' => '6711d4b6-7e8f-4c84-8388-47eec3be89d6',
            ]
        ];

        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with('/users/bulk/identify')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->bulkIdentify($userData));
    }

    /** @test */
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
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->bulkDelete($userIds));
    }

    /** @test */
    public function will_get_user_preferences()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/preferences', $userId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->getPreferences($userId));
    }

    /** @test */
    public function will_get_user_preference()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';
        $preferenceId = '9493171f-12ea-4fac-bb34-bcc7fa9c5d3f';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/preferences/%s', $userId, $preferenceId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->getPreference($userId, $preferenceId));
    }

    /** @test */
    public function will_set_user_preference()
    {
        $userId = '69687856-7f7a-47f9-9d7a-76f1d916cc18';

        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s/preferences/%s', $userId, 'default'))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->setPreferences($userId, []));
    }

    /** @test */
    public function will_bulk_set_user_preferences()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/users/bulk/preferences'))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->bulkSetPreferences([]));
    }

    /** @test */
    public function will_get_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->getChannelData($userId, $channelId));
    }

    /** @test */
    public function will_set_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->setChannelData($userId, $channelId, []));
    }

    /** @test */
    public function will_unset_user_channel_data()
    {
        $userId = 'user_1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = '';

        $users = $this->getApiMock();
        $users->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/users/%s/channel_data/%s', $userId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $users->unsetChannelData($userId, $channelId));
    }

    protected function getApiClass(): string
    {
        return Users::class;
    }
}
