<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\BulkOperations;

class BulkOperationsTest extends ApiTest
{
    /** @test */
    public function will_get_bulk_operation()
    {
        $id = 'b4f6f61e-3634-4e80-af0d-9c83e9acc6f3';
        $expected = $this->getContent(sprintf('%s/data/responses/bulk-operation.json', __DIR__));

        $bulkOperations = $this->getApiMock();
        $bulkOperations->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/bulk_operations/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $bulkOperations->get($id));
    }

    protected function getApiClass(): string
    {
        return BulkOperations::class;
    }
}
