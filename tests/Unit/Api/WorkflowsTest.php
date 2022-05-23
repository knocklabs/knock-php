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

    protected function getApiClass(): string
    {
        return Workflows::class;
    }
}
