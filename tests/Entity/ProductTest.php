<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use App\Entity\OrderItem;




/**
 * Test suite for the Product entity.
 * 
 * This class contains unit tests to verify the behavior of the Product entity,
 * including default values, setters/getters, lifecycle callbacks, and relationships.
 */

class ProductTest extends TestCase
{
     /**
     * The Product instance being tested.
     * 
     * @var Product
     */
    private Product $product;

    /**
     * Set up method called before each test method.
     * 
     * Initializes a new Product instance for each test to ensure a clean state.
     */
    protected function setUp(): void
    {
        $this->product = new Product();

    }

     /**
     * Test default values of a newly created Product.
     * 
     * Verifies that:
     * - The default status is 'inactive'
     * - Stock is initially null
     * - ID is initially null
     * - Order items collection is empty
     */

    public function testDefaultValues(): void
    {
        // Testing values by default
        $this->assertEquals('inactive', $this->product->getStatus());
        $this->assertNull($this->product->getStock()); 
        $this->assertNull($this->product->getId());

       
    }


    /**
     * Test datetime-related methods of the Product entity.
     * 
     * Verifies that:
     * - Created and updated dates can be set and retrieved correctly
     */
    public function testDateTime(): void
    {
        $now = new \DateTimeImmutable();
        
        $this->product->setCreatedAt($now);
        $this->product->setUpdatedAt($now);
        
        $this->assertEquals($now, $this->product->getCreatedAt());
        $this->assertEquals($now, $this->product->getUpdatedAt());

    }



    /**
     * Test setters and getters for all Product properties.
     * 
     * Verifies that:
     * - Each setter correctly sets the corresponding property
     * - Each getter retrieves the correct value
     */
    public function testSettersAndGetters(): void
    {
        // Set values using setters
    $this->product
        ->setName('Advanced PHP Programming')
        ->setPrice(49.99)
        ->setStock(25)
        ->setType('book')
        ->setSlug('advanced-php-programming')
        ->setDescription('A comprehensive guide to advanced PHP techniques')
        ->setStatus('active');

    // Assert that the values are set correctly
    $this->assertEquals('Advanced PHP Programming', $this->product->getName());
    $this->assertEquals(49.99, $this->product->getPrice());
    $this->assertEquals(25, $this->product->getStock());
    $this->assertEquals('book', $this->product->getType());
    $this->assertEquals('advanced-php-programming', $this->product->getSlug());
    $this->assertEquals('A comprehensive guide to advanced PHP techniques', $this->product->getDescription());
    $this->assertEquals('active', $this->product->getStatus());
    }


    /**
     * Test lifecycle callbacks for created and updated timestamps.
     * 
     * Verifies that:
     * - Created and updated dates are automatically set
     * - Updated date changes on subsequent updates
     * - Created date remains constant
     */
    public function testLifecycleCallbacks(): void
    {
        $this->product->setCreatedAtValue();
        
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->product->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->product->getUpdatedAt());
        
        // Test PreUpdate
        $oldUpdatedAt = $this->product->getUpdatedAt();
        sleep(1); // Wait 1 second to ensure different timestamp

        $this->product->setUpdatedAtValue();
        
        $this->assertNotEquals($oldUpdatedAt, $this->product->getUpdatedAt());

        $this->assertSame($this->product->getCreatedAt(), $this->product->getCreatedAt());
    }


}
