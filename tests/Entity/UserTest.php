<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Order;


/**
 * Test suite for the User entity.
 * 
 * This class contains unit tests to verify the behavior of the User entity,
 * including default values, setters/getters, lifecycle callbacks, and relationships.
 */
class UserTest extends TestCase
{
    /**
     * The User instance being tested.
     * 
     * @var User
     */
    private User $user;

    /**
     * Set up method called before each test method.
     * 
     * Initializes a new User instance for each test to ensure a clean state.
     */
    protected function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * Test default values of a newly created User.
     * 
     * Verifies that:
     * - The default roles are set to ['ROLE_USER']
     * - ID is initially null
     * - Email, first name, last name, and last login are initially null
     * - Addresses and orders collections are empty
     */
    public function testDefaultValues(): void
    {
        // Default values test
        $this->assertNull($this->user->getId());
        $this->assertNull($this->user->getEmail());
        $this->assertNull($this->user->getFirstName());
        $this->assertNull($this->user->getLastName());
        $this->assertNull($this->user->getLastLogin());
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
        
        // Collection test
        $this->assertInstanceOf(Collection::class, $this->user->getAddresses());
        $this->assertInstanceOf(Collection::class, $this->user->getOrders());
        $this->assertTrue($this->user->getAddresses()->isEmpty());
        $this->assertTrue($this->user->getOrders()->isEmpty());
    }

    /**
     * Test setters and getters for User properties.
     * 
     * Verifies that the setters and getters work correctly for:
     * - Email
     * - Password
     * - Roles
     * - First name
     * - Last name
     */
    public function testSettersAndGetters(): void
    {
        $email = 'test@example.com';
        $password = 'hashedpassword123';
        $roles = ['ROLE_USER'];
        $firstName = 'John';
        $lastName = 'Doe';
        
        $this->user
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles)
            ->setFirstName($firstName)
            ->setLastName($lastName);
        
        $this->assertEquals($email, $this->user->getEmail());
        $this->assertEquals($password, $this->user->getPassword());
        $this->assertEquals($roles, $this->user->getRoles());
        $this->assertEquals($firstName, $this->user->getFirstName());
        $this->assertEquals($lastName, $this->user->getLastName());

    }


    /*     * Test datetime-related methods of the User entity.
     * 
     * Verifies that:
     * - Created, updated, and last login dates can be set and retrieved correctly
     */
    public function testDateTime(): void
    {
        $now = new \DateTimeImmutable();
        
        $this->user->setCreatedAt($now);
        $this->user->setUpdatedAt($now);
        $this->user->setLastLogin($now);
        
        $this->assertEquals($now, $this->user->getCreatedAt());
        $this->assertEquals($now, $this->user->getUpdatedAt());
        $this->assertEquals($now, $this->user->getLastLogin());
    }

    /*     * Test lifecycle callbacks of the User entity.
     * 
     * Verifies that:
     * - Created and updated dates are set correctly on pre-persist
     * - Updated date is set correctly on pre-update
     */
    public function testLifecycleCallbacks(): void
    {
        $this->user->setCreatedAtValue();
        
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->user->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->user->getUpdatedAt());
        
        // Test PreUpdate
        $oldUpdatedAt = $this->user->getUpdatedAt();
        sleep(1); // Wait 1 second to ensure different timestamp

        $this->user->setUpdatedAtValue();
        
        $this->assertNotEquals($oldUpdatedAt, $this->user->getUpdatedAt());

        $this->assertSame($this->user->getCreatedAt(), $this->user->getCreatedAt());
    }

    /*     * Test the relationship between User and Address entities.
     * 
     * Verifies that:
     * - Addresses can be added and removed correctly
     */
    public function testAddressRelation(): void
    {
        $address = new Address();
        
        // Test adding address
        $this->user->addAddress($address);
        $this->assertTrue($this->user->getAddresses()->contains($address));
        
        // Test removing address
        $this->user->removeAddress($address);
        $this->assertFalse($this->user->getAddresses()->contains($address));
    }

    /*     * Test the relationship between User and Order entities.
     * 
     * Verifies that:
     * - Orders can be added and removed correctly
     */
    public function testOrderRelation(): void
    {
        $order = new Order();
        
        // Test adding order
        $this->user->addOrder($order);
        $this->assertTrue($this->user->getOrders()->contains($order));
        
        // Test removing order
        $this->user->removeOrder($order);
        $this->assertFalse($this->user->getOrders()->contains($order));
    }

}
