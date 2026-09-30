<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\WorkflowRecipientRuns;
use PHPUnit\Framework\Attributes\Test;

class WorkflowRecipientRunsTest extends ApiTestCase
{
    #[Test]
    public function will_list_workflow_recipient_runs()
    {
        $params = ['workflow' => 'comment-created', 'status' => ['completed'], 'has_errors' => true];
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-recipient-runs.json', __DIR__));

        $runs = $this->getApiMock();
        $runs->expects($this->once())
            ->method('getRequest')
            ->with('/workflow_recipient_runs', $params)
            ->willReturn($expected);

        $this->assertEquals($expected, $runs->list($params));
    }

    #[Test]
    public function will_get_workflow_recipient_run()
    {
        $id = '123e4567-e89b-12d3-a456-426614174000';
        $expected = $this->getContent(sprintf('%s/data/responses/workflow-recipient-run.json', __DIR__));

        $runs = $this->getApiMock();
        $runs->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/workflow_recipient_runs/%s', $id))
            ->willReturn($expected);

        $this->assertEquals($expected, $runs->get($id));
    }

    protected function getApiClass(): string
    {
        return WorkflowRecipientRuns::class;
    }
}
