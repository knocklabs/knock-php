<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Workflows;

class WorkflowsTest extends ApiTest
{
    /** @test */
    public function will_trigger_workflow()
    {
        $key = 'new-comment';
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-trigger.json', __DIR__));

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/trigger', $key))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $workflows->trigger($key, []));
    }

    /** @test */
    public function will_trigger_workflow_with_idempotency_key()
    {
        $key = 'new-comment';
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-trigger.json', __DIR__));
        $headers = ['Idempotency-Key' => '12345'];

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/trigger', $key), [], $headers)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $workflows->trigger($key, [], $headers));
    }

    /** @test */
    public function will_cancel_workflow()
    {
        $key = 'new-comment';
        $expected = '';

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/cancel', $key))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $workflows->cancel($key, []));
    }

    /** @test */
    public function will_bulk_create_schedules()
    {
        $schedules = [[
            'workflow' => 'comment-created',
            'recipient' => 'dnedry',
            'repeats' => [['frequency' => 'daily']],
        ]];
        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with('/schedules/bulk/create', ['schedules' => $schedules])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $workflows->bulkCreateSchedules($schedules));
    }

    protected function getApiClass(): string
    {
        return Workflows::class;
    }
}
