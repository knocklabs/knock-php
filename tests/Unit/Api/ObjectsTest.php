<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Objects;

class ObjectsTest extends ApiTest
{
    /** @test */
    public function will_get_object()
    {
        $collection = 'projects';
        $id = 'project-1';
        $expected = $this->getContent(sprintf('%s/data/responses/object.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/objects/%s/%s', $collection, $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->get($collection, $id));
    }

    /** @test */
    public function will_get_object_messages()
    {
        $collection = 'projects';
        $id = 'project-1';
        $expected = $this->getContent(sprintf('%s/data/responses/messages.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/objects/%s/%s/messages', $collection, $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->getMessages($collection, $id));
    }

    /** @test */
    public function will_set_object()
    {
        $collection = 'projects';
        $id = 'project-1';
        $expected = $this->getContent(sprintf('%s/data/responses/object.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/objects/%s/%s', $collection, $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->set($collection, $id, []));
    }

    /** @test */
    public function will_delete_object()
    {
        $collection = 'projects';
        $id = 'project-1';
        $expected = '';

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/objects/%s/%s', $collection, $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->delete($collection, $id));
    }

    /** @test */
    public function will_bulk_set_objects()
    {
        $collection = 'projects';
        $objectsData = [
            [
                'id' => 'project-1',
                'name' => 'Project one',
            ],
        ];
        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/objects/%s/bulk/set', $collection))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->bulkSet($collection, $objectsData));
    }

    /** @test */
    public function will_bulk_delete_objects()
    {
        $collection = 'projects';
        $objectIds = [
            'project-1',
            'project-2',
        ];
        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/objects/%s/bulk/delete', $collection))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->bulkDelete($collection, $objectIds));
    }

    /** @test */
    public function will_bulk_add_subscriptions()
    {
      $collection = 'projects';
      $subscriptions = [
          [
            'id' => 'object-1',
            'properties' => ['foo' => 'bar'],
            'recipients' => ['user-1', 'user-2']
          ]
      ];
      $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

      $objects = $this->getApiMock();
      $objects->expects($this->once())
          ->method('postRequest')
          ->with(sprintf('/objects/%s/bulk/subscriptions/add', $collection))
          ->will($this->returnValue($expected));

      $this->assertEquals($expected, $objects->bulkAddSubscriptions($collection, $subscriptions));
    }

    /** @test */
    public function will_get_object_preferences()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/objects/%s/%s/preferences', $collection, $objectId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->getPreferences($collection, $objectId));
    }

    /** @test */
    public function will_get_object_preference()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $preferenceId = '5c53b316-91f7-454f-ab27-66d111282685';
        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/objects/%s/%s/preferences/%s', $collection, $objectId, $preferenceId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->getPreference($collection, $objectId, $preferenceId));
    }

    /** @test */
    public function will_set_object_preference()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $expected = $this->getContent(sprintf('%s/data/responses/preference-set.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/objects/%s/%s/preferences/%s', $collection, $objectId, 'default'))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->setPreferences($collection, $objectId, []));
    }

    /** @test */
    public function will_get_object_channel_data()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->getChannelData($collection, $objectId, $channelId));
    }

    /** @test */
    public function will_set_object_channel_data()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = $this->getContent(sprintf('%s/data/responses/channel-data.json', __DIR__));

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->setChannelData($collection, $objectId, $channelId, []));
    }

    /** @test */
    public function will_unset_object_channel_data()
    {
        $collection = 'projects';
        $objectId = 'project-1';
        $channelId = 'ad2e1aab-76ae-4463-98c2-83488a841710';

        $expected = '';

        $objects = $this->getApiMock();
        $objects->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/objects/%s/%s/channel_data/%s', $collection, $objectId, $channelId))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $objects->unsetChannelData($collection, $objectId, $channelId));
    }

    protected function getApiClass(): string
    {
        return Objects::class;
    }
}
