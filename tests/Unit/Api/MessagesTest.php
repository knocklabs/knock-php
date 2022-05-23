<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Messages;

class MessagesTest extends ApiTest
{
    /** @test */
    public function will_list_messages()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/messages.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('getRequest')
            ->with('/messages')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->list());
    }

    /** @test */
    public function will_get_message()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $expected = $this->getContent(sprintf('%s/data/responses/message.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/messages/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->get($id));
    }

    /** @test */
    public function will_get_message_activities()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $expected = $this->getContent(sprintf('%s/data/responses/message-activities.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/messages/%s/activities', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->getActivities($id));
    }

    /** @test */
    public function will_get_message_events()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $expected = $this->getContent(sprintf('%s/data/responses/message-events.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/messages/%s/events', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->getEvents($id));
    }

    /** @test */
    public function will_get_message_content()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $expected = $this->getContent(sprintf('%s/data/responses/message-content.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/messages/%s/content', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->getContent($id));
    }

    /** @test */
    public function will_update_message_status()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $status = 'read';
        $expected = $this->getContent(sprintf('%s/data/responses/message.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/messages/%s/%s', $id, $status))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->updateStatus($id, $status));
    }

    /** @test */
    public function will_undo_message_status()
    {
        $id = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $status = 'read';
        $expected = $this->getContent(sprintf('%s/data/responses/message.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/messages/%s/%s', $id, $status))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->undoStatus($id, $status));
    }

    /** @test */
    public function will_bulk_update_message_status()
    {
        $status = 'read';
        $messageIds = [
            '8800f3fe-8b0d-47e1-a469-d17a27849d53',
            '85575f79-f186-4fd5-8bc6-ffdef78ab080',
        ];
        $expected = $this->getContent(sprintf('%s/data/responses/messages.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/messages/batch/%s', $status))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->bulkUpdateStatus($status, $messageIds));
    }

    /** @test */
    public function will_bulk_channel_status()
    {
        $channel = '3961db0c-4202-475d-a5a2-32b4579425d1';
        $status = 'read';

        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $messages = $this->getApiMock();
        $messages->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/channels/%s/messages/bulk/%s', $channel, $status))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $messages->bulkUpdateChannelStatus($channel, $status, []));
    }

    protected function getApiClass(): string
    {
        return Messages::class;
    }
}
