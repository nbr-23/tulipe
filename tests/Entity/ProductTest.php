<?php

namespace App\Tests\Entity;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;


use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product();
        // Initialize the dates = required
        $this->product->setCreatedAt(new \DateTimeImmutable());
        $this->product->setUpdatedAt(new \DateTimeImmutable());
    }

    public function testDefaultValues(): void
    {
        // Testing values by default
        $this->assertEquals('active', $this->product->getStatus());
        $this->assertNull($this->product->getStock()); 
        $this->assertNull($this->product->getId());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->product->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->product->getUpdatedAt());
    }
    public function testBasicSettersAndGetters(): void
    {
        $name = 'Test Product';
        $price = '99.99';
        $stock = 10;
        $type = 'book';
        $slug = 'test-product';
        $description = 'Test Description';

        $this->product
            ->setName($name)
            ->setPrice($price)
            ->setStock($stock)
            ->setType($type)
            ->setSlug($slug)
            ->setDescription($description);

        // Verify that each value is correctly set
        $this->assertEquals($name, $this->product->getName());
        $this->assertEquals($price, $this->product->getPrice());
        $this->assertEquals($stock, $this->product->getStock());
        $this->assertEquals($type, $this->product->getType());
        $this->assertEquals($slug, $this->product->getSlug());
        $this->assertEquals($description, $this->product->getDescription());
    }

    public function testStatusValues(): void
    {
        // Test default status
        $this->assertEquals('active', $this->product->getStatus());

        // Test changing  status
        $this->product->setStatus('inactive');
        $this->assertEquals('inactive', $this->product->getStatus());
    }

    public function testOrderItemsCollection(): void
    {
        // Test initial state of order items
        $this->assertInstanceOf(Collection::class, $this->product->getOrderItems());
        $this->assertTrue($this->product->getOrderItems()->isEmpty());
    }

}
