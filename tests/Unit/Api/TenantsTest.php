<?php

namespace Tests\Unit\Api;

use Knock\KnockSdk\Api\Tenants;

class TenantsTest extends ApiTest
{
    /** @test */
    public function will_list_tenants()
    {
        $expected = $this->getContent(sprintf('%s/data/responses/tenants.json', __DIR__));

        $tenants = $this->getApiMock();
        $tenants->expects($this->once())
            ->method('getRequest')
            ->with('/tenants')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tenants->list());
    }

    /** @test */
    public function will_get_tenant()
    {
        $id = 'tenant-123';
        $expected = $this->getContent(sprintf('%s/data/responses/tenant.json', __DIR__));

        $tenants = $this->getApiMock();
        $tenants->expects($this->once())
            ->method('getRequest')
            ->with(sprintf('/tenants/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tenants->get($id));
    }

    /** @test */
    public function will_set_tenant()
    {
        $id = 'tenant-123';
        $expected = $this->getContent(sprintf('%s/data/responses/tenant.json', __DIR__));

        $tenants = $this->getApiMock();
        $tenants->expects($this->once())
            ->method('putRequest')
            ->with(sprintf('/tenants/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tenants->set($id, []));
    }

    /** @test */
    public function will_delete_tenant()
    {
        $id = 'tenant-123';
        $expected = '';

        $tenants = $this->getApiMock();
        $tenants->expects($this->once())
            ->method('deleteRequest')
            ->with(sprintf('/tenants/%s', $id))
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tenants->delete($id));
    }

    protected function getApiClass(): string
    {
        return Tenants::class;
    }
}
