<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Workflows;
use PHPUnit\Framework\Attributes\Test;

class WorkflowsTest extends ApiTestCase
{
    #[Test]
    public function will_trigger_workflow()
    {
        $key = 'new-comment';
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-trigger.json', __DIR__));

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/trigger', $key))
            ->willReturn($expected);

        $this->assertEquals($expected, $workflows->trigger($key, []));
    }

    #[Test]
    public function will_trigger_workflow_with_idempotency_key()
    {
        $key = 'new-comment';
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-trigger.json', __DIR__));
        $headers = ['Idempotency-Key' => '12345'];

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/trigger', $key), [], $headers)
            ->willReturn($expected);

        $this->assertEquals($expected, $workflows->trigger($key, [], $headers));
    }

    #[Test]
    public function will_cancel_workflow()
    {
        $key = 'new-comment';
        $expected = '';

        $workflows = $this->getApiMock();
        $workflows->expects($this->once())
            ->method('postRequest')
            ->with(sprintf('/workflows/%s/cancel', $key))
            ->willReturn($expected);

        $this->assertEquals($expected, $workflows->cancel($key, []));
    }

    #[Test]
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
            ->willReturn($expected);

        $this->assertEquals($expected, $workflows->bulkCreateSchedules($schedules));
    }

    protected function getApiClass(): string
    {
        return Workflows::class;
    }
}
