<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeeAPITest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_validates_employee_data_for_provider_one_creation()
    {
        $response = $this->postJson('/api/provider1/employees', []);
        
        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_employee_data_for_provider_two_creation()
    {
        $response = $this->postJson('/api/provider2/employees', []);
        
        $response->assertStatus(422);
    }

    /** @test */
    public function it_creates_employee_for_provider_one()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'occupation' => $this->faker->jobTitle
        ];

        $response = $this->postJson('/api/provider1/employees', $data);
        
        $response->assertStatus(201);
    }

    /** @test */
    public function it_creates_employee_for_provider_two()
    {
        $data = [
            'givenName' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'contactEmail' => $this->faker->email,
            'position' => $this->faker->jobTitle
        ];

        $response = $this->postJson('/api/provider2/employees', $data);
        
        $response->assertStatus(201);
    }
}
