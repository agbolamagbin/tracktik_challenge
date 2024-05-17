<?php

namespace Tests\Unit;

use App\Services\EmployeeService;
use PHPUnit\Framework\TestCase;

class EmployeeServiceTest extends TestCase
{
    protected $employeeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->employeeService = new EmployeeService();
    }

    public function testMapDataProviderOne()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email_address' => 'john.doe@example.com',
            'occupation' => 'Engineer',
        ];

        $mappedData = $this->employeeService->mapData('provider_one', $data);

        $this->assertEquals($data['first_name'], $mappedData['firstName']);
        $this->assertEquals($data['last_name'], $mappedData['lastName']);
        $this->assertEquals($data['email_address'], $mappedData['email']);
        $this->assertEquals($data['occupation'], $mappedData['jobTitle']);
    }
	
	public function testMapDataProviderTwo()
    {
        $data = [
            'givenName' => 'John',
            'surname' => 'Doe',
            'contactEmail' => 'john.doe@example.com',
            'position' => 'Engineer',
        ];

        $mappedData = $this->employeeService->mapData('provider_two', $data);

        $this->assertEquals($data['givenName'], $mappedData['firstName']);
        $this->assertEquals($data['surname'], $mappedData['lastName']);
        $this->assertEquals($data['contactEmail'], $mappedData['email']);
        $this->assertEquals($data['position'], $mappedData['jobTitle']);
    }
}