<?php

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    /**
     * The Address instance being tested.
     * 
     * @var Address
     */
    private Address $address;

    /**
     * Set up method called before each test method.
     * 
     * Initializes a new Address instance for each test to ensure a clean state.
     */
    protected function setUp(): void
    {
        $this->address = new Address();
    }

    /**
     * Test default values of a newly created Address.
     * 
     * Verifies that:
     * - ID is initially null
     * - Type, first name, last name, street1, street2, city, state, country, zip code, and phone are initially null
     * - User is initially null
     * - Default flag is false
     * - Created at is an instance of DateTimeImmutable
     */
    public function testDefaultValues(): void
    {
        $this->assertNull($this->address->getId());
        $this->assertNull($this->address->getType());
        $this->assertNull($this->address->getFirstName());
        $this->assertNull($this->address->getLastName());
        $this->assertNull($this->address->getStreet1());
        $this->assertNull($this->address->getStreet2());
        $this->assertNull($this->address->getCity());
        $this->assertNull($this->address->getState());
        $this->assertNull($this->address->getCountry());
        $this->assertNull($this->address->getZipCode());
        $this->assertNull($this->address->getPhone());
        $this->assertNull($this->address->getUser());
        $this->assertNull($this->address->isDefault());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->address->getCreatedAt());
    }

    /**
     * Test setters and getters for Address entity.
     * 
     * Verifies that:
     * - Each setter correctly sets the corresponding property
     * - Each getter retrieves the correct value
     */
    public function testSettersAndGetters(): void
    {
        $type = 'billing';
        $firstName = 'John';
        $lastName = 'Doe';
        $street1 = '123 Main St';
        $street2 = 'Apt 4B';
        $city = 'New York';
        $state = 'NY';
        $country = 'US';
        $zipCode = '10001';
        $phone = '+123456789';
        $isDefault = true;
        $user = $this->createMock(User::class);

        $this->address
            ->setType($type)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setStreet1($street1)
            ->setStreet2($street2)
            ->setCity($city)
            ->setState($state)
            ->setCountry($country)
            ->setZipCode($zipCode)
            ->setPhone($phone)
            ->setIsDefault($isDefault)
            ->setUser($user);

        $this->assertEquals($type, $this->address->getType());
        $this->assertEquals($firstName, $this->address->getFirstName());
        $this->assertEquals($lastName, $this->address->getLastName());
        $this->assertEquals($street1, $this->address->getStreet1());
        $this->assertEquals($street2, $this->address->getStreet2());
        $this->assertEquals($city, $this->address->getCity());
        $this->assertEquals($state, $this->address->getState());
        $this->assertEquals($country, $this->address->getCountry());
        $this->assertEquals($zipCode, $this->address->getZipCode());
        $this->assertEquals($phone, $this->address->getPhone());
        $this->assertTrue($this->address->isDefault());
        $this->assertSame($user, $this->address->getUser());
    }

    /**
     * Test the relationship between Address and User entities.
     * 
     * Verifies that:
     * - A user can be set and retrieved from an address
     */
    public function testUserRelation(): void
    {
        $user = new User();

        // Set user
        $this->address->setUser($user);
        $this->assertSame($user, $this->address->getUser());

        // Unset user
        $this->address->setUser(null);
        $this->assertNull($this->address->getUser());
    }
}
