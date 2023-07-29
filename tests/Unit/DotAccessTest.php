<?php

namespace Tests\Unit\App\Console;

use Defuse\Crypto\Crypto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Urisoft\DotAccess;

class DotAccessTest extends TestCase
{
    public function testGetExistingKey()
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

        $wrapper = new DotAccess($data);

        $name = $wrapper->get('user.name');
        $email = $wrapper->get('user.email');
        $city = $wrapper->get('user.address.city');

        $this->assertEquals('John Doe', $name);
        $this->assertEquals('john.doe@example.com', $email);
        $this->assertEquals('New York', $city);
    }

    public function testGetNonExistingKeyWithDefault()
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

        $wrapper = new DotAccess($data);

        $default = 'N/A';
        $zipCode = $wrapper->get('user.address.zip_code', $default);

        $this->assertEquals($default, $zipCode);
    }

    public function testSetKey()
    {
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ],
        ];

        $wrapper = new DotAccess($data);

        $age = 30;
        $wrapper->set('user.age', $age);

        $this->assertEquals($age, $wrapper->get('user.age'));
    }

    public function testHasKey()
    {
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ],
        ];

        $wrapper = new DotAccess($data);

        $this->assertTrue($wrapper->has('user.name'));
        $this->assertTrue($wrapper->has('user.email'));
        $this->assertFalse($wrapper->has('user.age'));
    }

    public function testRemoveKey()
    {
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ],
        ];

        $wrapper = new DotAccess($data);

        $wrapper->remove('user.email');

        $this->assertFalse($wrapper->has('user.email'));
    }
}
