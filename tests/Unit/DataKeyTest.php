<?php

use PHPUnit\Framework\TestCase;
use Urisoft\DataKey;

class DataKeyTest extends TestCase
{
    public function testDotAccessWithExistingKey()
    {
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'address' => [
                    'city' => 'New York',
                    'country' => 'USA',
                ],
            ],
        ];

        // Using the wrapper function
        $name = DataKey::get($data, 'user.name');
        $email = DataKey::get($data, 'user.email');
        $city = DataKey::get($data, 'user.address.city');

        $this->assertEquals('John Doe', $name);
        $this->assertEquals('john.doe@example.com', $email);
        $this->assertEquals('New York', $city);
    }

    public function testDotAccessWithNonExistingKey()
    {
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'address' => [
                    'city' => 'New York',
                    'country' => 'USA',
                ],
            ],
        ];

        // Using the wrapper function with a non-existing key and a default value
        $zipCode = DataKey::get($data, 'user.address.zip_code', 'N/A');

        $this->assertEquals('N/A', $zipCode);
    }
}
